<?php

namespace Samohina\CityByIp\Model\ResourceModel\City;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct(): void
    {
        $this->_init(
                \Samohina\CityByIp\Model\City::class,
                \Samohina\CityByIp\Model\ResourceModel\City::class
        );
    }

}
