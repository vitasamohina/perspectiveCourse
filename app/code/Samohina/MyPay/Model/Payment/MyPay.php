<?php
namespace Samohina\MyPay\Model\Payment;
class MyPay extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'mypay';
}
