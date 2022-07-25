<?php
namespace Samohina\Database\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $_warehouseFactory;
    public function __construct(\Samohina\Database\Model\WarehouseFactory
                                $warehouseFactory)
    {
        $this->_warehouseFactory = $warehouseFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.12', '<')) {
            $data = [
                'name_war' => "Блискавка",
                'addr_war' => "м. Київ, вул. Дружби народів, 12",
                'id_cat' => 5,
                'id_prod' => 4,
                'kol_prod' => 199,
                'data_prod' => '2017-05-02 15:06:01',
            ];
            $warehouse = $this->_warehouseFactory->create();
            $warehouse->addData($data)->save();
        }
    }
}
