<?php

declare(strict_types=1);

namespace Samohina\Discount\Plugin\Model;

use \Samohina\Discount\Helper\Data;
use Magento\Framework\App\RequestInterface;

class ChangePrice
{
    private RequestInterface $request;

    private $helperData;

    private $customerSession;

    private $groupRepository;

    public function __construct(
        Data $helperData,
        RequestInterface $request,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
    )
    {
        $this->helperData = $helperData;
        $this->request = $request;
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
    public function belongToCategory ($subject) {
        $selectedCategoryArray = explode(",", $this->getSelectedCategories());
       foreach ($selectedCategoryArray as $categorySelected){
            if(in_array($categorySelected, $subject->getCategoryIds())){
                return true;
            }
        }
        return false;
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
    public function afterGetPrice(
        \Magento\Catalog\Model\Product $subject, $result
    ) {
        if ($this->getIsEnable() && $this->belongToCategory($subject) && $this->getEnableDiscount() && $this->belongToCustomerGroup()){
            return $result*(100 - $this->getPercentDiscount())/100;
        }
        return $result;
    }
}
