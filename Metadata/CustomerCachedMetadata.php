<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Customer\Model\Metadata;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Cached customer attribute metadata service
 */
class CustomerCachedMetadata extends CachedMetadata implements CustomerMetadataInterface
{
    /**
     * @var string
     */
    protected $entityType = 'customer';

    /**
     * Constructor
     *
     * @param CustomerMetadata $metadata
     * @param StoreManagerInterface $storeManager
     * @param AttributeMetadataCache|null $attributeMetadataCache
     */
    public function __construct(
        CustomerMetadata $metadata,
        StoreManagerInterface $storeManager,
        AttributeMetadataCache $attributeMetadataCache = null
    ) {
        parent::__construct($metadata, $storeManager, $attributeMetadataCache);
    }
}
