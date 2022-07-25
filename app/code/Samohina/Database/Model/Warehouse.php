<?php
namespace Samohina\Database\Model;
class Warehouse extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Samohina\Database\Model\ResourceModel\Warehouse');
    }
}
