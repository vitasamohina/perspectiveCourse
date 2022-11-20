<?php

namespace Samohina\MiddleName\Plugin;

class DefineField
{
    /**
     * @var \Samohina\MiddleName\Helper\ModuleStatus
     */
    protected $helper;

    public function __construct(
        \Samohina\MiddleName\Helper\ModuleStatus $helper
    ) {
        $this->helper = $helper;
    }

    public function afterGetAttributes(\Magento\Customer\Model\Metadata\Form $subject, $result)
    {
        $moduleStatus=$this->helper->getModuleStatus();
        if ($moduleStatus==true) {
            $checkShippingMethod=$this->helper->checkShippingMethod();

            if ($checkShippingMethod==true) {
                if (!empty($result['middlename'])) {
                    $result['middlename']->setData('required', true)
                                         ->setData('frontend_class', 'required-entry');
                    return $result;
                } else {
                    return $result;
                }
            }
        }

        return $result;
    }
}
