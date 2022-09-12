<?php

declare(strict_types=1);

namespace Samohina\Discount\Plugin\Block;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use \Samohina\Discount\Helper\Data;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddString
{
    private RequestInterface $request;

    private $helperData;

    private $productRepository;

    private $categoryRepository;

    private $priceCurrency;

    public function __construct(
        Data $helperData,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        PriceCurrencyInterface $priceCurrency
    )

    {
        $this->helperData = $helperData;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->priceCurrency = $priceCurrency;

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
    public function getDateEndSale() {
        return $this->helperData->getGeneralConfig('date_end_sale');
    }
    public function getQntDayEnd() {
        return $this->helperData->getGeneralConfig('qnt_day_end');
    }
    public function getProduct(){
        $productId = (int) $this->request->getParam('id');
        $product = $this->productRepository->getById($productId);
        return $product;
    }
    public function getCategoryName($categoryId){
        $category = $this->categoryRepository->get($categoryId);
        $categoryName = $category->getName();
        return $categoryName;
    }
    public function getCategoryNamesStr() {
        $categoryNames = [];
        $categoryIds = $this->getProduct()->getCategoryIds();
        foreach ($categoryIds as $categoryId){
            array_push($categoryNames, $this->getCategoryName($categoryId));
        }
        return implode("_", $categoryNames);
    }
    public function getDayLeft(){
        return strtotime($this->getDateEndSale()) - time();
    }

    public function getPercentDiscount() {
        return $this->helperData->getGeneralConfig('percent_discount');
    }
    public function getEnableDiscount() {
        return $this->helperData->getGeneralConfig('enable_discount');
    }
    public function getPriceWithDiscount() {
        return $this->priceCurrency->format($this->getProduct()->getPrice()*(100 - $this->getPercentDiscount())/100);
    }
    public function showMessageAboutEndSale(){
        if($this->getDayLeft() < (int)$this->getQntDayEnd()*24*60*60 && $this->getDayLeft() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getString () {
        $string = '<div>'.$this->getCategoryNamesStr().'_'.$this->getProduct()->getId().'_'.$this->getProduct()->getSku().'_'.$this->getProduct()->getTypeId().'</div>';
        return $string;
    }
    public function getMessage () {
       return '<div>'.__("Sale of this product ends at: %1", $this->getDateEndSale()).'</div>';
    }
    public function getInscriptionDiscounts () {
        return '<div>'.__("Only today this item can be purchased at a %1 % discount. Discounted price - %2.", $this->getPercentDiscount(), $this->getPriceWithDiscount()).'</div>';
    }
    public function getPathInfo (){
        return $this->request->getPathInfo();
    }
    public function afterGetPageHeading(
        \Magento\Theme\Block\Html\Title $subject, $result
    ) {
       // if (stripos($this->getPathInfo(), 'catalog/product/view') && $this->getIsEnable() && $this->belongToCategory() && $this->showMessageAboutEndSale()){
        if (stripos($this->getPathInfo(), 'catalog/product/view') && $this->getIsEnable() && $this->belongToCategory() && $this->getEnableDiscount()){
            //return $result.$this->getString();
           // return $result.$this->getMessage();
              return $result.$this->getInscriptionDiscounts();
        } else{
            return $result;
        }
    }
}
