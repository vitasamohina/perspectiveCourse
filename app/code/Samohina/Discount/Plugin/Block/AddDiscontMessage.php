<?php

declare(strict_types=1);

namespace Samohina\Discount\Plugin\Block;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use \Samohina\Discount\Helper\Data;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddDiscontMessage
{
    private RequestInterface $request;

    private $helperData;

    private $productRepository;

    private $categoryRepository;

    private $priceCurrency;

    private $customerSession;

    private $groupRepository;

    public function __construct(
        Data $helperData,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    )

    {
        $this->helperData = $helperData;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->priceCurrency = $priceCurrency;
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
    }
    public function getIsEnable()
    {
        return $this->helperData->getGeneralConfig('enable');
    }
    public function getSelectedCategories() {
        return $this->helperData->getGeneralConfig('categorylist');
    }
    public function belongToCategory () {
        $selectedCategoryArray = explode(",", $this->getSelectedCategories());
        foreach ($selectedCategoryArray as $categorySelected){
            if(in_array($categorySelected, $this->getProduct()->getCategoryIds())){
                return true;
            }
        }
        return false;
    }

    public function getProduct(){
        $productId = (int) $this->request->getParam('id');
        $product = $this->productRepository->getById($productId);
        return $product;
    }

    public function getPercentDiscount() {
        return $this->helperData->getGeneralConfig('percent_discount');
    }
    public function getEnableDiscount() {
        return $this->helperData->getGeneralConfig('enable_discount');
    }
    public function getSelectedCustomerGroup() {
        return (int)$this->helperData->getGeneralConfig('customer_group');
    }
    public function getPriceWithDiscount() {
        return $this->priceCurrency->format($this->getProduct()->getPrice()*(100 - $this->getPercentDiscount())/100);
    }

    public function getPathInfo (){
        return $this->request->getPathInfo();
    }
    public function getGroupId(){
        if($this->customerSession->isLoggedIn()){
            $customerGroup=$this->customerSession->getCustomer()->getGroupId();
        }else{
            $customerGroup = false;
        }
        return $customerGroup;
    }
    public function belongToCustomerGroup () {

        if ($this->getGroupId() && (int)$this->getGroupId() == $this->getSelectedCustomerGroup()){
            return true;
        }
        return false;
    }
    public function getCustomerGroupCode (){
        return $this->groupRepository->getById($this->getSelectedCustomerGroup())->getCode();
    }

    public function getInscriptionDiscounts () {
        return '<div style="font-size: 18px; border: 1px solid red; margin-top: 20px;padding: 10px;">'.__("Only today %1 can purchase this item at a %2 % discount. Price today is %3 instead of %4.", $this->getCustomerGroupCode(), $this->getPercentDiscount(), $this->getPriceWithDiscount(), $this->priceCurrency->format($this->getProduct()->getPrice())).'</div>';
    }

    public function afterGetPageHeading(
        \Magento\Theme\Block\Html\Title $subject, $result
    ) {
       // if (stripos($this->getPathInfo(), 'catalog/product/view') && $this->getIsEnable() && $this->belongToCategory() && $this->showMessageAboutEndSale()){
        //if (stripos($this->getPathInfo(), 'catalog/product/view') && $this->getIsEnable() && $this->belongToCategory() && $this->getEnableDiscount() && $this->belongToCustomerGroup()){
        if (stripos($this->getPathInfo(), 'catalog/product/view') && $this->getIsEnable() && $this->belongToCategory() && $this->getEnableDiscount()){
              return $result.$this->getInscriptionDiscounts();
        } else{
            return $result;
        }
    }
}
