<?php

namespace Samohina\Database\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('samohina_database_warehouse')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('samohina_database_warehouse')
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'War ID'
                )
                ->addColumn(
                    'name_war',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'War Name'
                )
                ->addColumn(
                    'addr_war',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Addr war'
                )
                ->addColumn(
                    'id_cat',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    255,
                    [],
                    'Id Category'
                )
                ->addColumn(
                    'id_prod',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    [],
                    'Id product'
                )
                ->addColumn(
                    'kol_prod',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    255,
                    [],
                    'Kol prod'
                )
                ->addColumn(
                    'data_prod',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Warehouse Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('samohina_database_warehouse'),
                $setup->getIdxName(
                    $installer->getTable('samohina_database_warehouse'),
                    ['name_war', 'addr_war'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name_war', 'addr_war'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
