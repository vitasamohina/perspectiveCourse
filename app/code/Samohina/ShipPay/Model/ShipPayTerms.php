<?php
namespace Samohina\ShipPay\Model;

use \Samohina\ShipPay\Helper\Data;
class ShipPayTerms
{
    private $customerSession;

    private $helperData;

    public function __construct(
        Data $helperData,
        \Magento\Customer\Model\Session $customerSession
    )

    {
        $this->helperData = $helperData;
        $this->customerSession = $customerSession;
    }

    public function getIsEnable()
    {
        return $this->helperData->getGeneralConfig('enable');
    }

    public function getTotal() {
        return $this->helperData->getGeneralConfig('total');
    }

    public function getQuantity() {

       return $this->helperData->getGeneralConfig('quantity');

    }

    public function getSelectedPayment() {

        return $this->helperData->getGeneralConfig('paymentlist');

    }
    public function getSelectedShipping() {
        return $this->helperData->getGeneralConfig('shipmentlist');
    }

    public function getCustomerGroupId(){

        if ($this->customerSession->isLoggedIn()) {
            $customerGroup=$this->customerSession->getCustomer()->getGroupId();

        } else {
            $customerGroup = false;
        }
        return $customerGroup;
    }

    public function isLargeWholesale() {
        if ($this->getCustomerGroupId() == 5){
            return true;
        }
        return false;
    }
    public function isWholesale() {
        if ($this->getCustomerGroupId() == 2){
            return true;
        }
        return false;
    }
}
