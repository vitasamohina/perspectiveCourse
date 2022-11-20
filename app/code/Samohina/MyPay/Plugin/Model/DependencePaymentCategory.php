<?php
namespace Samohina\MyPay\Plugin\Model;

class DependencePaymentCategory
{
    private $helper;

    private $productRepository;

    public function __construct(
        \Samohina\MyPay\Helper\Data $helper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )

    {
    $this->helper = $helper;
    $this->productRepository = $productRepository;
    }
    public function afterGetAvailableMethods(
        \Magento\Payment\Model\MethodList $subject,
                                          $availableMethods,
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {

        foreach ($availableMethods as $key => $method) {
            // Here we will hide CashonDeliver method while customer select FlateRate Shipping Method
            if(($method->getCode() == 'mypay') && !$this->getСategoriesIntended($quote)) {
                unset($availableMethods[$key]);
            }
        }

        return $availableMethods;
    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return string
     */
    private function getCategoryIdsFromQuote($quote)
    {
        $categoryIds=[];
        foreach ($quote->getItems() as $item ) {
            $product = $this->productRepository->getById($item->getProductId());
            foreach ($product->getCategoryIds() as $categoryId){
                array_push($categoryIds, $categoryId);
            }
        }
        return $categoryIds;
    }
   private function getСategoriesIntended($quote)
    {
        $categoriesIntended=$this->helper->getCategory();

        $categoriesIntendedArray = explode(",", $categoriesIntended);
        $сategoryIdsFromQuote = $this->getCategoryIdsFromQuote($quote);

        foreach ($сategoryIdsFromQuote as $categoryId) {
            if(in_array($categoryId, $categoriesIntendedArray)){
                return true;
            }
        }
        return false;

    }
}
