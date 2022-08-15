<?php

namespace AdminACL\CurrencySelection\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_registry;
    protected $helperData;

    public function __construct(
        \AdminACL\CurrencySelection\Helper\Data $helperData,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        array                                   $data = []
    )
    {
        $this->helperData = $helperData;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     *
     * @return current_product
     */
    public function getCurrentProduct()
    {
        if ($this->helperData->getGeneralConfig('enable'))
            return $this->_registry->registry('current_product');
    }

    /**
     *
     * @return str
     */
    public function getUahPrice()
    {
        if ($this->helperData->getGeneralConfig('UAH'))
            return $this->helperData->getGeneralConfig('display_uah') * $this->getCurrentProduct()->getFinalPrice() . ' UAH';
    }

    /**
     *
     * @return str
     */
    public function getRubPrice()
    {
        if ($this->helperData->getGeneralConfig('RUB'))
            return $this->helperData->getGeneralConfig('display_rub') * $this->getCurrentProduct()->getFinalPrice() . ' RUB';
    }

    /**
     *
     * @return str
     */
    public function getEuroPrice()
    {
        if ($this->helperData->getGeneralConfig('EURO'))
            return $this->helperData->getGeneralConfig('display_euro') * $this->getCurrentProduct()->getFinalPrice() . ' EURO';
    }
}
