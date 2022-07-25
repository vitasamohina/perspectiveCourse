<?php
namespace Samohina\Sales\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class UpdateData implements DataPatchInterface
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
        $sampleData = [
            [
                'id' => '9',
                'price' => '90',
            ],
            [
                'id' => '10',
                'price' => '50',
            ],
            [
                'id' => '11',
                'price' => '60',
            ],
            [
                'id' => '12',
                'price' => '120',
            ],
            [
                'id' => '13',
                'price' => '50',
            ]
        ];
        $this->moduleDataSetup->startSetup();
        $sales=$this->salesFactory->create();
        foreach ($sampleData as $data) {
            $salesIdToUpdate = (int)$data['id'];
            $this->salesResource->load($sales, $salesIdToUpdate);
            $sales->setData($data);
            $this->salesResource->save($sales);
        }
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
