<?php

namespace Samohina\DataAcquisition\ViewModel;

class getShipping implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $shippingConfig;

    public function __construct(
        \Magento\Shipping\Model\Config $shippingConfig
    )
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function getShippingtList()
    {
        return $this->shippingConfig->getActiveCarriers();
    }


}
