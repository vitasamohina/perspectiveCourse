<?php

namespace Samohina\Currency\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ExchangeRates implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const XML_PATH_IS_ENABLED = 'samohina_currency/general/enable';
    const XML_PATH_UAH_COURSE_ENABLED ='samohina_currency/general/uah_course_enable';
    const XML_PATH_UAH_COURSE ='samohina_currency/general/uah_course';
    const XML_PATH_RUB_COURSE_ENABLED ='samohina_currency/general/uah_course_enable';
    const XML_PATH_RUB_COURSE ='samohina_currency/general/rub_course';
    const XML_PATH_EURO_COURSE_ENABLED ='samohina_currency/general/euro_course_enable';
    const XML_PATH_EURO_COURSE ='samohina_currency/general/euro_course';

    private $scopeConfig;

    private $productRepository;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
    }
    public function getIsEnable()
    {
       $isEnable = $this->scopeConfig->isSetFlag(self::XML_PATH_IS_ENABLED, ScopeInterface::SCOPE_STORE);

        return $isEnable;
    }
    public function getExchangeRatesUAH()
    {
        $ExchangeRatesUAH = $this->scopeConfig->getValue(self::XML_PATH_UAH_COURSE, ScopeInterface::SCOPE_STORE);

        $EnableExchangeRatesUAH = $this->scopeConfig->isSetFlag(self::XML_PATH_UAH_COURSE_ENABLED, ScopeInterface::SCOPE_STORE);

        $arrayExchangeRates = [
            "rates" => $ExchangeRatesUAH,
            "enable" => $EnableExchangeRatesUAH
        ];

        return $arrayExchangeRates;
    }
    public function getExchangeRatesRUB()
    {
        $ExchangeRatesRUB = $this->scopeConfig->getValue(self::XML_PATH_RUB_COURSE, ScopeInterface::SCOPE_STORE);

        $EnableExchangeRatesRUB = $this->scopeConfig->isSetFlag(self::XML_PATH_RUB_COURSE_ENABLED, ScopeInterface::SCOPE_STORE);

        $arrayExchangeRates = [
            "rates" => $ExchangeRatesRUB,
            "enable" => $EnableExchangeRatesRUB
        ];

        return $arrayExchangeRates;
    }
    public function getExchangeRatesEURO()
    {
        $ExchangeRatesEURO = $this->scopeConfig->getValue(self::XML_PATH_EURO_COURSE, ScopeInterface::SCOPE_STORE);

        $EnableExchangeRatesEURO = $this->scopeConfig->isSetFlag(self::XML_PATH_EURO_COURSE_ENABLED, ScopeInterface::SCOPE_STORE);

        $arrayExchangeRates = [
            "rates" => $ExchangeRatesEURO,
            "enable" => $EnableExchangeRatesEURO
        ];

        return $arrayExchangeRates;
    }
    public function getProductById($productId)
    {
        if (is_null($productId)) {
            return null;
        }

        $productModel = $this->productRepository->getById($productId);

        return $productModel;
    }
}

