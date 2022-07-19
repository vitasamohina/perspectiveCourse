<?php

namespace Samohina\DataAcquisition\ViewModel;

class getPayment implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $paymentConfig;

    public function __construct(
        \Magento\Payment\Model\Config $paymentConfig
    )
    {
        $this->paymentConfig = $paymentConfig;
    }


    public function getPaymentList()
    {
        return $this->paymentConfig->getActiveMethods();
    }


}
