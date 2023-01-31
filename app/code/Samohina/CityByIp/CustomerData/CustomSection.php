<?php

namespace Samohina\CityByIp\CustomerData;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;

class CustomSection implements SectionSourceInterface
{
    private $customerSession;

    public function __construct(
        Session      $customerSession
    ) {
        $this->customerSession = $customerSession;
    }
    public function getSectionData()
    {
        return [
            'customer_city' => $this->customerSession->getData('client_city'),
        ];
    }
}
