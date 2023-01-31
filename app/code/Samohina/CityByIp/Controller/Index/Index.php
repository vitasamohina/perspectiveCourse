<?php

namespace Samohina\CityByIp\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\Context;

class Index implements ActionInterface
{
    private $city;

    private $customerSession;

    private $context;

    private $resultJsonFactory;


    public function __construct(
        \Samohina\CityByIp\Service\GeolocationService $city,
        \Magento\Customer\Model\Session $customerSession,
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->city = $city;
        $this->customerSession = $customerSession;
        $this->context = $context;
        $this->resultJsonFactory = $resultJsonFactory;
    }

     public function execute()
    {
        if ($this->context->getRequest()->getParams()['city']){
            $city = $this->context->getRequest()->getParams()['city'];
            $this->customerSession->setData('client_city', $city);
        } else {
            $clientCity = $this->customerSession->getData('client_city');
            if (!isset($clientCity)) {
                $this->customerSession->setData('client_city', $this->city->getCityByIp());
            }
        }

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(['client_city' => $this->customerSession->getData('client_city')]);

        return $resultJson;

    }
}
