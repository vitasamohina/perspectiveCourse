<?php
/**
 * Copyright © 2019 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Samohina\Sales\Setup\Patch\Schema;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class AddColumn implements SchemaPatchInterface
{
    private $moduleDataSetup;
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }
    public static function getDependencies()
    {
        return [];
    }
    public function getAliases()
    {
        return [];
    }
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('samohina_sales'),
            'price',
            [
                'type' => 'decimal',
                'scale' => '2',
                'precision' => '10',
                'nullable' => true,
                'comment' => 'Price',
            ]
        );
        $this->moduleDataSetup->endSetup();
    }
}
