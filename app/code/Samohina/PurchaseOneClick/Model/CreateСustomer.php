<?php

namespace Samohina\PurchaseOneClick\Model;


use Magento\Store\Model\StoreManagerInterface;


class CreateСustomer
{
    private $storeManager;
    private $customerFactory;

    public function __construct(
        StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        $this->storeManager = $storeManager;
        $this->customerFactory  = $customerFactory;
    }
    public function createCustomer($customerName, $customerEmail, $customerSurname)
    {
        try {
            //create account

            $websiteId = $this->storeManager->getStore()->getWebsiteId();

            $customer   = $this->customerFactory->create();
            $customer->setWebsiteId($websiteId);
            $customer->setStore($this->storeManager->getStore());


            $customer->setEmail($customerEmail);
            $customer->setFirstname($customerName);
            $customer->setLastname($customerSurname);
            $customer->setPassword("password");


            $customer->save();
            //$customer->sendNewAccountEmail();

            return true;
        } catch (\Exception $e) {
            $this->logger->info('[CreateOrder] ERROR: ' . $e->getMessage());
            $this->logger->info('Line - ' . $e->getLine() . ', ' . $e->getFile());
            $this->logger->info($e->getTraceAsString());
        }

        return false;
    }

}
