<?php

namespace Samohina\Database\Model\ResourceModel\Warehouse;

class Collection extends
    \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Samohina\Database\Model\Warehouse',
            'Samohina\Database\Model\ResourceModel\Warehouse');
    }
}

