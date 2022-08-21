<?php

namespace Samohina\AirFreight\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class airFreightOnly implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const XML_PATH_IS_ENABLED = 'samohina_airfreight/general/enable';
    const XML_PATH_BALLOON_WEIGHT ='samohina_airfreight/general/balloon_excess_product_weight';
    const XML_PATH_BALLOON_PAYMENT ='samohina_airfreight/general/balloon_additional_payment';

    const XML_PATH_HIGHSPEED_PLANE_WEIGHT ='samohina_airfreight/general/highspeed_plane_excess_product_weight';
    const XML_PATH_HIGHSPEED_PLANE_PAYMENT ='samohina_airfreight/general/highspeed_plane_additional_payment';

    const XML_PATH_CHARTER_PLANE_WEIGHT ='samohina_airfreight/general/charter_plane_excess_product_weight';
    const XML_PATH_CHARTER_PLANE_PAYMENT ='samohina_airfreight/general/charter_plane_additional_payment';

    const XML_PATH_SPACESHIP_WEIGHT ='samohina_airfreight/general/spaceship_excess_product_weight';
    const XML_PATH_SPACESHIP_PAYMENT ='samohina_airfreight/general/spaceship_additional_payment';

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
    public function getCurrentProduct()
    {
        $a=$this->registry->registry('current_product');
        return $this->registry->registry('current_product');
    }
    public function getAirFreightOnly()
    {
        return $this->getCurrentProduct()->getAirFreightOnlyAttribute();
    }
    public function getSizeMargin()
    {
        $productWeight = (int)$this->getProductWeight();

        if (
            $this->getAirFreightOnly() =='balloon'
            && $this->scopeConfig->getValue(self::XML_PATH_BALLOON_WEIGHT, ScopeInterface::SCOPE_STORE)
            && $this->scopeConfig->getValue(self::XML_PATH_BALLOON_PAYMENT , ScopeInterface::SCOPE_STORE)
            && (int)$this->scopeConfig->getValue(self::XML_PATH_BALLOON_WEIGHT, ScopeInterface::SCOPE_STORE) < $productWeight
        ) {
            $sizeMargin =$this->priceCurrency->format(($productWeight - (int)$this->scopeConfig->getValue(self::XML_PATH_BALLOON_WEIGHT, ScopeInterface::SCOPE_STORE))*(int)$this->scopeConfig->getValue(self::XML_PATH_BALLOON_PAYMENT , ScopeInterface::SCOPE_STORE));
        } elseif (
            $this->getAirFreightOnly() =='charter_plane'
            && $this->scopeConfig->getValue(self::XML_PATH_CHARTER_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE)
            && $this->scopeConfig->getValue(self::XML_PATH_CHARTER_PLANE_PAYMENT, ScopeInterface::SCOPE_STORE)
            && (int)$this->scopeConfig->getValue(self::XML_PATH_CHARTER_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE) < $productWeight){
            $sizeMargin = $this->priceCurrency->format(($productWeight - (int)$this->scopeConfig->getValue(self::XML_PATH_CHARTER_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE))*(int)$this->scopeConfig->getValue(self::XML_PATH_CHARTER_PLANE_PAYMENT, ScopeInterface::SCOPE_STORE));
        } elseif (
            $this->getAirFreightOnly() =='high_speed_plane'
            && $this->scopeConfig->getValue(self::XML_PATH_HIGHSPEED_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE)
            && $this->scopeConfig->getValue(self::XML_PATH_HIGHSPEED_PLANE_PAYMENT, ScopeInterface::SCOPE_STORE)
            && (int)$this->scopeConfig->getValue(self::XML_PATH_HIGHSPEED_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE) < $productWeight){
            $sizeMargin = $this->priceCurrency->format(($productWeight - (int)$this->scopeConfig->getValue(self::XML_PATH_HIGHSPEED_PLANE_WEIGHT, ScopeInterface::SCOPE_STORE))*(int)$this->scopeConfig->getValue(self::XML_PATH_HIGHSPEED_PLANE_PAYMENT, ScopeInterface::SCOPE_STORE));
        } elseif ($this->getAirFreightOnly() =='spaceship'
            && $this->scopeConfig->getValue(self::XML_PATH_SPACESHIP_WEIGHT, ScopeInterface::SCOPE_STORE)
            && $this->scopeConfig->getValue(self::XML_PATH_SPACESHIP_PAYMENT, ScopeInterface::SCOPE_STORE)
            && (int)$this->scopeConfig->getValue(self::XML_PATH_SPACESHIP_WEIGHT, ScopeInterface::SCOPE_STORE) < $productWeight){
            $sizeMargin = $this->priceCurrency->format(($productWeight - (int)$this->scopeConfig->getValue(self::XML_PATH_SPACESHIP_WEIGHT, ScopeInterface::SCOPE_STORE))*(int)$this->scopeConfig->getValue(self::XML_PATH_SPACESHIP_PAYMENT, ScopeInterface::SCOPE_STORE));
        } else {
            $sizeMargin=false;
        }
        return $sizeMargin;
    }
    public function getProductName(){
        return $this->getCurrentProduct()->getName();
    }
    public function getProductWeight(){

        return $this->getCurrentProduct()->getWeight();
    }
}

