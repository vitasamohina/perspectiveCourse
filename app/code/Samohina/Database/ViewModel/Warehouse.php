<?php

namespace Samohina\Database\ViewModel;



class Warehouse implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $warehouseCollectionFactory;

    public function __construct(
        \Samohina\Database\Model\ResourceModel\Warehouse\CollectionFactory $warehouseCollectionFactory
    ) {
        $this->warehouseCollectionFactory = $warehouseCollectionFactory;
    }
    public function getAllWarehouses()
    {
        $warehouseAllCollection = $this->warehouseCollectionFactory->create()->load();

        return $warehouseAllCollection->getItems();
    }

    public function getWarehouses($specifiedWarehouse)
    {
        $warehouseCollection = $this->warehouseCollectionFactory->create();
        $warehouseCollection->addFieldToSelect(['name_war', 'id_cat', 'data_prod'])
        ->addFieldToFilter('name_war', $specifiedWarehouse);

        return $warehouseCollection->getItems();
    }



}

