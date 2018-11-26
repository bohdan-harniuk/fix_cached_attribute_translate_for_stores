<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Customer\Model\Metadata;

use Magento\Customer\Api\MetadataInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\Entity\AttributeCache;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Cached attribute metadata service
 */
class CachedMetadata implements MetadataInterface
{
    const CACHE_SEPARATOR = ';';

    /**
     * @var string
     */
    protected $entityType = 'none';

    /**
     * @var AttributeMetadataCache
     */
    private $attributeMetadataCache;

    /**
     * @var MetadataInterface
     */
    protected $metadata;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param MetadataInterface $metadata
     * @param StoreManagerInterface $storeManager
     * @param AttributeMetadataCache|null $attributeMetadataCache
     */
    public function __construct(
        MetadataInterface $metadata,
        StoreManagerInterface $storeManager,
        AttributeMetadataCache $attributeMetadataCache = null
    ) {
        $this->metadata = $metadata;
        $this->attributeMetadataCache = $attributeMetadataCache ?: ObjectManager::getInstance()
            ->get(AttributeMetadataCache::class);
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($formCode)
    {
        $attributes = $this->attributeMetadataCache->load($this->entityType, $formCode);
        if ($attributes !== false) {
            return $attributes;
        }
        $attributes = $this->metadata->getAttributes($formCode);
        $this->attributeMetadataCache->save($this->entityType, $attributes, $formCode);
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeMetadata($attributeCode)
    {
        $store = $this->storeManager->getStore()->getCode();
        $attributesMetadata = $this->attributeMetadataCache->load($this->entityType, $attributeCode . '_' .  $store);
        if (false !== $attributesMetadata) {
            return array_shift($attributesMetadata);
        }
        $attributeMetadata = $this->metadata->getAttributeMetadata($attributeCode);
        $this->attributeMetadataCache->save($this->entityType, [$attributeMetadata], $attributeCode . '_' .  $store);
        return $attributeMetadata;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllAttributesMetadata()
    {
        $store = $this->storeManager->getStore()->getCode();
        $attributes = $this->attributeMetadataCache->load($this->entityType, 'all_' . $store);
        if ($attributes !== false) {
            return $attributes;
        }
        $attributes = $this->metadata->getAllAttributesMetadata();
        $this->attributeMetadataCache->save($this->entityType, $attributes, 'all_' . $store);
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomAttributesMetadata($dataObjectClassName = null)
    {
        $store = $this->storeManager->getStore()->getCode();
        $attributes = $this->attributeMetadataCache->load($this->entityType, 'custom_' . $store);
        if ($attributes !== false) {
            return $attributes;
        }
        $attributes = $this->metadata->getCustomAttributesMetadata();
        $this->attributeMetadataCache->save($this->entityType, $attributes, 'custom_' . $store);
        return $attributes;
    }
}
