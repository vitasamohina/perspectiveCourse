<?php

namespace Samohina\ItemsLeft\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ItemsLeft implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const XML_PATH_IS_ENABLED = 'samohina_itemsleft/general/enable';
    const XML_PATH_QUANTITY_STOCK ='samohina_itemsleft/general/quantity_items_left';

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
    public function getItemsLeft()
    {
        $itemsLeft = $this->scopeConfig->getValue(self::XML_PATH_QUANTITY_STOCK, ScopeInterface::SCOPE_STORE);

        return $itemsLeft;
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

