<?php
namespace Samohina\Sales\Model;
use Magento\Framework\Model\AbstractModel;
class Sales extends AbstractModel{
    protected function _construct()
    {
        $this->_init("Samohina\Sales\Model\ResourceModel\Sales");
    }
}

