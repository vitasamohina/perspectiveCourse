<?php

namespace Samohina\Reviews\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Review\Model\Review;

class AddData implements DataPatchInterface
{
    private $reviewFactory;

    /**
     * @var Review
     */

    private $review;

    private $storeManager;

    private $reviewCollectionFactory;

    public function __construct(
        \Magento\Review\Model\reviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewCollectionFactory

    ) {
        $this->reviewFactory = $reviewFactory;
        $this->storeManager = $storeManager;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
    }

    public function apply()
    {
        $stores = $this->storeManager->getStores();
        $storesId= array();
        foreach ($stores as $storeId => $storeData) {
            $storesId[] = $storeId;
        }

        $reviewCollection = $this->reviewCollectionFactory->create();
        $reviewCollection->addFieldToSelect('*')
            ->load();
        $allReviews = $reviewCollection->getItems();

        foreach ($allReviews  as $review) {
            $review = $this->reviewFactory->create()
                ->load((int)$review->getReviewId());

            $review->setStores($storesId)->save();
        }

    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }


}
