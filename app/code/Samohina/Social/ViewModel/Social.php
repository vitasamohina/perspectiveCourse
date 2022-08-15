<?php

namespace Samohina\Social\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Social implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const XML_PATH_IS_ENABLED = 'samohina_social/general/enable';
    const XML_PATH_SOCIAL_PERCENT ='samohina_social/general/persent_social';

    private $scopeConfig;

    private $registry;

    private PriceCurrencyInterface $priceCurrency;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Registry  $registry,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->registry = $registry;
        $this->priceCurrency = $priceCurrency;
    }
    public function getIsEnable()
    {
       $isEnable = $this->scopeConfig->isSetFlag(self::XML_PATH_IS_ENABLED, ScopeInterface::SCOPE_STORE);

        return $isEnable;
    }
    public function getSocialPercent()
    {
        $socialPercent = $this->scopeConfig->getValue(self::XML_PATH_SOCIAL_PERCENT, ScopeInterface::SCOPE_STORE);

        return $socialPercent;
    }
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
    public function getSocialAttribute()
    {
        return $this->getCurrentProduct()->getSocialAttribute();
    }
    public function getSocialPrice()
    {
        if (is_null($this->getSocialPercent())) {
            return null;
        }
        return $this->priceCurrency->format($this->getCurrentProduct()->getFinalPrice()*$this->getSocialPercent()/100);
    }
}

