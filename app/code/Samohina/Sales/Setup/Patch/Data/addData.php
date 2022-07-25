<?php
namespace Samohina\Sales\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class addData implements DataPatchInterface
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
                'product_name' => 'Мобильный телефон Samsung Galaxy M32 6/128GB Light Blue',
                'qnt' => '2',
                'date' => '2022-05-02',
                'discount' => '0.3',
            ],
            [
                'product_name' => 'Планшет Lenovo Tab P11 Wi-Fi 64GB Slate Grey',
                'qnt' => '3',
                'date' => '2022-01-02',
                'discount' => '0.6',
            ],
            [
                'product_name' => 'Стиральный порошок Persil автомат "Свежесть от Силан" 8.1 кг',
                'qnt' => '4',
                'date' => '2022-06-06',
                'discount' => '0.7',
            ],
            [
                'product_name' => 'Вешалка Мій Дім Idea Home для одежды тяжелой 45х23х5',
                'qnt' => '1',
                'date' => '2021-12-12',
                'discount' => '0.2',
            ],
            [
                'product_name' => 'Планшет Lenovo Tab P11 Wi-Fi 64GB Slate Grey',
                'qnt' => '1',
                'date' => '2020-12-12',
                'discount' => '0.3',
            ]

        ];
        $this->moduleDataSetup->startSetup();
        $sales=$this->salesFactory->create();
        foreach ($sampleData as $data) {
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
