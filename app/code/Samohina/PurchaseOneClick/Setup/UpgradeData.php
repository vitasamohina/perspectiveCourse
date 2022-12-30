<?php

namespace Samohina\PurchaseOneClick\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Sales\Setup\SalesSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $salesSetupFactory;

    public function __construct(SalesSetupFactory $salesSetupFactory)
    {
        $this->salesSetupFactory = $salesSetupFactory;
    }
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);
            $salesSetup->addAttribute(
                'order',
                'buy_one_click',
                [
                    'type' => 'varchar',
                    'length' => 5,
                    'visible' => false,
                    'required' => false,
                    'grid' => true
                ]
            );
        }
    }
}
