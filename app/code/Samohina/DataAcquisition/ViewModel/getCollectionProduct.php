<?php

namespace Samohina\DataAcquisition\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;

class getCollectionProduct implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $productCollectionFactory;
    private $categoryFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory

    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryFactory = $categoryFactory;
    }
    public function getProducts()
    {
        $category_id = '4';
        $category = $this->categoryFactory->create()->load($category_id);
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*')
            ->addAttributeToFilter('price', ['gteq' => 50])
            ->addAttributeToFilter('price', ['lteq' => 60])
            ->addCategoryFilter($category)
            ->load();

        return $productCollection->getItems();
    }


}
