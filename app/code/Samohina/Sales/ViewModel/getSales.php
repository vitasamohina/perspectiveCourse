<?php

namespace Samohina\Sales\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;

class getSales implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $salesCollectionFactory;

    public function __construct(
        \Samohina\Sales\Model\ResourceModel\Sales\CollectionFactory $salesCollectionFactory


    ) {
        $this->salesCollectionFactory = $salesCollectionFactory;
    }
    public function getSales($filterName)
    {
        $salesCollection = $this->salesCollectionFactory->create();
        $salesCollection->addFieldToFilter('product_name', $filterName)
        ->load();

        return $salesCollection->getItems();
    }


}
