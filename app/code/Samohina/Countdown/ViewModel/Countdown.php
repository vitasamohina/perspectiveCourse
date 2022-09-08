<?php

namespace Samohina\Countdown\ViewModel;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Samohina\Eight\Helper\Data;
use \Magento\Catalog\Model\Product;
use \Magento\Catalog\Model\ProductRepository;
use \Magento\Framework\Registry;

class Countdown implements \Magento\Framework\View\Element\Block\ArgumentInterface
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
    public function CurrentProduct() {
        return $this->registry->registry('current_product');
    }
    public function getEndSpecialPrice() {
        return $this->CurrentProduct()->getSpecialToDate();
    }
    public function getCatalogRule(){
            $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
            $productId = $this->CurrentProduct()->getId();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $dateTs = $this->date->gmtDate();
            return $this->ruleFactory->getRulesFromProduct($dateTs, $websiteId, $customerGroupId, $productId);
    }
    public function getMinEndRuleTime () {
        $rule = $this->getCatalogRule();
        if (is_null($rule) || empty($rule)){
            return null;
        }
        $arrayEndRuleTime = array();

        foreach ($rule as $ruleItem){
            array_push($arrayEndRuleTime, $ruleItem['to_time']);
        }
        return min($arrayEndRuleTime);

    }
    public function getMinEndTime(){

        if(is_null($this->getEndSpecialPrice())){
            $minAllTime = $this->getMinEndRuleTime();
        }elseif(is_null($this->getMinEndRuleTime())){
            $minAllTime = strtotime($this->getEndSpecialPrice());
        }elseif($this->getMinEndRuleTime() > strtotime($this->getEndSpecialPrice() && !is_null($this->getEndSpecialPrice()) && !is_null($this->getMinEndRuleTime()))){
            $minAllTime = strtotime($this->getEndSpecialPrice());
        }elseif($this->getMinEndRuleTime() < strtotime($this->getEndSpecialPrice() && !is_null($this->getEndSpecialPrice()) && !is_null($this->getMinEndRuleTime()))){
            $minAllTime = $this->getMinEndRuleTime;
        }else{
            $minAllTime = false;
        }
        if ($minAllTime){
            $minAllTime =  date("Y/m/d", $minAllTime);
        }
        return  $minAllTime;
    }
}
