<?php

declare(strict_types=1);

namespace  Samohina\Sales\Model\ResourceModel\Sales;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(\Samohina\Sales\Model\Sales::class, \Samohina\Sales\Model\ResourceModel\Sales::class);
    }
}
