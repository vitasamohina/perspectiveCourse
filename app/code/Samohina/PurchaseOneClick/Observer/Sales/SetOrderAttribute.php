<?php
namespace Samohina\PurchaseOneClick\Observer\Sales;

class SetOrderAttribute implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $attributeBuyOneClick = $observer->getData('quote')->getBuyOneClick();
        if($attributeBuyOneClick){
            $order= $observer->getData('order');
            $order->setBuyOneClick($attributeBuyOneClick);
            $order->save();
        }

    }
}
