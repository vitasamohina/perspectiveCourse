<?php
namespace Samohina\Sales\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Sales extends AbstractDb{
    public function _construct()
    {
        $this->_init("samohina_sales", 'id');
    }
}
