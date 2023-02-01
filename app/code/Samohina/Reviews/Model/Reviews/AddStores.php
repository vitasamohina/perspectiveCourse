<?php

namespace Samohina\Reviews\Model\Reviews;

use Magento\Review\Model\Review;
class AddStores
{

    private $reviewFactory;

    /**
     * @var Review
     */

    private $review;

    private $storeManager;

    private $reviewCollectionFactory;

    public function __construct(
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewCollectionFactory
    )
    {
        $this->reviewFactory = $reviewFactory;
        $this->storeManager = $storeManager;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
    }

    public function execute(\Closure $cl = null)
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
            if(is_callable($cl)) {
                $cl($review->getReviewId());
            }
        }

    }


}
