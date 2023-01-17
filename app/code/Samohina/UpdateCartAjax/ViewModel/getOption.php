<?php

namespace Samohina\UpdateCartAjax\ViewModel;

class getOption implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $productHelper;

    public function __construct(

        \Magento\Catalog\Helper\Product $productHelper

    ) {

        $this->productHelper = $productHelper;
    }
    public function setConfigValue($product, $buyRequest)
    {
        return $this->productHelper->prepareProductOptions($product, $buyRequest);
    }

}
