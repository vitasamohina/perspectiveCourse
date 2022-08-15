<?php

namespace Samohina\Social\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class SocialInCategory implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const XML_PATH_IS_ENABLED = 'samohina_social/general/enable';

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

    public function getSocialAttribute($productId)
    {
        return $this->getProductById($productId)->getSocialAttribute();
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

