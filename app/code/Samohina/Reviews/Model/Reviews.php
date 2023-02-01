<?php

namespace Samohina\Reviews\Model;

use Samohina\Reviews\Model\ResourceModel\Reviews as ReviewsResourceModel;
use Magento\Framework\Model\AbstractModel;

class Reviews extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ReviewsResourceModel::class);
    }
}
