<?php

namespace Samohina\MyPay\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH_PAYMENT = 'payment/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getCategory($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_PAYMENT .'mypay/categorylist', $storeId);
    }

}

