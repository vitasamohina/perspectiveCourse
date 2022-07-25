<?php

namespace Samohina\Database\ViewModel;



class TabWarehouse implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $warehouseCollectionFactory;

    public function __construct(
        \Samohina\Database\Model\ResourceModel\Warehouse\CollectionFactory $warehouseCollectionFactory
    ) {
        $this->warehouseCollectionFactory = $warehouseCollectionFactory;
    }

    public function getWarehouses($product_id)
    {
        $warehouseCollection = $this->warehouseCollectionFactory->create();
        $warehouseCollection->addFieldToSelect(['name_war', 'kol_prod', 'addr_war'])
        ->addFieldToFilter('id_prod', $product_id)->load();
        return $warehouseCollection->getItems();
    }



}

