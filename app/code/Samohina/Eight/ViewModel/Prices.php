<?php

namespace Samohina\Eight\ViewModel;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Samohina\Eight\Helper\Data;
use \Magento\Catalog\Model\Product;
use \Magento\Catalog\Model\ProductRepository;
use \Magento\Framework\Registry;

class Prices implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    private $helperData;

    private $registry;

    private $productRepository;

    private $productCatalog;

    private $ruleFactory;

    private $customerSession;

    private $storeManager;
    private $date;


    public function __construct(
        Data $helperData,
        Product $productCatalog,
        ProductRepository $productRepository,
        Registry $registry,
        \Magento\CatalogRule\Model\ResourceModel\Rule $ruleFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    )
    {
        $this->helperData = $helperData;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->productCatalog = $productCatalog;
        $this->ruleFactory = $ruleFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->date = $date;
    }

    public function getIsEnable()
    {
        return $this->helperData->getGeneralConfig('enable');
    }

    public function CurrentProduct() {
        return $this->registry->registry('current_product');
    }

    public function getBasePrice() {
        if ($this->helperData->getGeneralConfig('base_price')){
            return $this->CurrentProduct()->getPrice();
        } else {
            return null;
        }
    }

    public function getSpecialPrice() {
        if ($this->helperData->getGeneralConfig('special_price')){
            return $this->CurrentProduct()->getSpecialPrice();
        } else {
            return null;
        }
    }

    public function getTierPrice() {
        if ($this->helperData->getGeneralConfig('tier_price')){
            return $this->CurrentProduct()->getTierPrice();
        } else {
            return null;
        }
    }

    public function getFinalPrice(){
        if ($this->helperData->getGeneralConfig('final_price')){
            return $this->CurrentProduct()->getFinalPrice();
        } else {
            return null;
        }
    }

   public function getCatalogRule(){
       if ($this->helperData->getGeneralConfig('catalog_rule_price')){
           $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
           $productId = $this->CurrentProduct()->getId();
           $websiteId = $this->storeManager->getStore()->getWebsiteId();
           $dateTs = $this->date->gmtDate();

           return $this->ruleFactory->getRulesFromProduct($dateTs, $websiteId, $customerGroupId, $productId);
       } else {
           return null;
       }

    }


}
