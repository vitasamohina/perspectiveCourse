<?php
namespace Samohina\PurchaseOneClick\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Paylist implements ArrayInterface
{
    private $paymentConfig;

    public function __construct(\Magento\Payment\Model\Config $paymentConfig)
    {
        $this->paymentConfig = $paymentConfig;
    }

    public function getPaymentList()
    {
        return $this->paymentConfig->getActiveMethods();;
    }

    public function toOptionArray()
    {

        $arr = $this->toArray();
        $ret = [];

        foreach ($arr as $key => $value)
        {

            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    public function toArray()
    {

        $payments = $this->getPaymentList();

        $paymentList = array();
        foreach ($payments as $payment){

            $paymentList[$payment->getCode()] = $payment->getTitle();
        }

        return $paymentList;
    }

}
