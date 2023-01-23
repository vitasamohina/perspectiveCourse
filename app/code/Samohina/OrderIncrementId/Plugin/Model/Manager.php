<?php

declare(strict_types=1);

namespace Samohina\OrderIncrementId\Plugin\Model;



use Samohina\OrderIncrementId\Helper\Data;

class Manager
{
    private $helperData;
    public function __construct(
        Data $helperData
    )

    {
        $this->helperData = $helperData;

    }
    public function getIsEnable()
    {
        return $this->helperData->getGeneralConfig('enable');
    }

    public function beforeGetSequence(
        \Magento\SalesSequence\Model\Manager $subject, $entityType, $storeId
    ) {
        if($this->getIsEnable() && $entityType == 'order'){
            $storeId = 1;
        }
        return [$entityType, $storeId];
    }
}
