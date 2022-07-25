<?php

namespace Samohina\Database\ViewModel;



class Product implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $warehouseCollectionFactory;

    private $productRepository;

    public function __construct(
        \Samohina\Database\Model\ResourceModel\Warehouse\CollectionFactory $warehouseCollectionFactory,
         \Magento\Catalog\Api\ProductRepositoryInterface $productRepository

    ) {
        $this->warehouseCollectionFactory = $warehouseCollectionFactory;
        $this->productRepository = $productRepository;
       // $this->categoryFactory = $categoryFactory;
    }
    public function getWarehouses($product_id)
    {
        $warehouseCollection = $this->warehouseCollectionFactory->create();
        $warehouseCollection->addFieldToSelect('name_war')
            ->addFieldToFilter('kol_prod', ['gt' => 0])
        ->addFieldToFilter('id_prod', $product_id);

        return $warehouseCollection->getItems();
    }
    public function getProducts($categories)
    {
        $prodsOnWarehouseCollection = $this->warehouseCollectionFactory->create();
        $prodsOnWarehouseCollection->addFieldToSelect('id_prod')
            ->addFieldToFilter('id_cat', $categories)
         ->addFieldToFilter('kol_prod', ['gt' => 0])
            ->distinct(true);

        return $prodsOnWarehouseCollection->getItems();
    }
    public function getProductById($productId)
    {
        if (is_null($productId)) {
            return null;
        }
        $productModel = $this->productRepository->getById($productId);
        return $productModel;
    }

}

