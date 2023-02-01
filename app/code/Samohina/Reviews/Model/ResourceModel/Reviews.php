<?php

namespace Samohina\Reviews\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reviews extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('review_store', 'review_id');
    }
}
