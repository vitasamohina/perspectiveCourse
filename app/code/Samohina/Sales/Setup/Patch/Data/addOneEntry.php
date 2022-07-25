<?php
namespace Samohina\Sales\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class addOneEntry implements DataPatchInterface
{
    private $salesFactory;
    private $salesResource;
    private $moduleDataSetup;
    public function __construct(
        \Samohina\Sales\Model\SalesFactory $salesFactory,
        \Samohina\Sales\Model\ResourceModel\Sales $salesResource,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->salesFactory = $salesFactory;
        $this->salesResource = $salesResource;
        $this->moduleDataSetup=$moduleDataSetup;
    }
    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $sales=$this->salesFactory->create();
        $sales->setProductName('Телевизор Akai UA40LEP1T2')->setQnt('1')
        ->setDate('2017-05-02')->setDiscount('0.5');
        $this->salesResource->save($sales);
        $this->moduleDataSetup->endSetup();
}
    public static function getDependencies()
    {
        return [];
    }
    public function getAliases()
    {
        return [];
    }
}
