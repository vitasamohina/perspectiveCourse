<?php
namespace Samohina\MiddleName\Helper;

use Magento\Framework\App\Helper\Context;

class ModuleStatus extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    private $form;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form $form
    ) {
        $this->scopeConfig= $scopeConfig;
        $this->form = $form;
        parent::__construct($context);
    }

    public function checkShippingMethod()
    {
        $name=$this->form->getShippingMethod();

        if ($name=='freeshipping_freeshipping') {
            return true;
        } else {
            return false;
        }
    }
    public function getModuleStatus()
    {
        $moduleStatus=$this->scopeConfig->getValue('samohina_middlename/general/enable');
        if ($moduleStatus==1) {
            return true;
        } else {
            return false;
        }
    }



}
