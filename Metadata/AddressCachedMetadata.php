<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Customer\Model\Metadata;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Cached customer address attribute metadata
 */
class AddressCachedMetadata extends CachedMetadata implements AddressMetadataInterface
{
    /**
     * @var string
     */
    protected $entityType = 'customer_address';

    /**
     * Constructor
     *
     * @param AddressMetadata $metadata
     * @param StoreManagerInterface $storeManager
     * @param AttributeMetadataCache|null $attributeMetadataCache
     */
    public function __construct(
        AddressMetadata $metadata,
        StoreManagerInterface $storeManager,
        AttributeMetadataCache $attributeMetadataCache = null
    ) {
        parent::__construct($metadata, $storeManager, $attributeMetadataCache);
    }
}
