<?php
namespace Samohina\PurchaseOneClick\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Shiplist implements ArrayInterface
{
    private $shippingConfig;

    public function __construct(\Magento\Shipping\Model\Config $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function getActiveCarriers()
    {
        return $this->shippingConfig->getActiveCarriers();
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

        $shippings = $this->getActiveCarriers();

        $shipList = array();
        foreach ($shippings as $shipping){

            $shipList[$shipping->getId()] = $shipping->getId();
        }

        return $shipList;
    }

}
