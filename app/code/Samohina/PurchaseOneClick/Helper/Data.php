<?php

namespace Samohina\PurchaseOneClick\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_ONE_CLICK = 'purchase_one_click/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {

        return $this->getConfigValue(self::XML_PATH_ONE_CLICK .'general/'. $code, $storeId);
    }

}
