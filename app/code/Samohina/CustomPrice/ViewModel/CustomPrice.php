<?php

namespace Samohina\CustomPrice\ViewModel;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class CustomPrice implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $productRepository;
    private PriceCurrencyInterface $priceCurrency;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
    }

    public function getCustomPrice($productId)
    {
        if ($this->productRepository->getById($productId)->getCustomPrice()){
            return $this->priceCurrency->format($this->productRepository->getById($productId)->getCustomPrice());
        }
        return false;


    }

}

