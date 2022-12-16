<?php
namespace Samohina\CustomPrice\Setup\Patch\Data;

   use Magento\Catalog\Model\Product\Attribute\Backend\Price;
   use Magento\Eav\Setup\EavSetup;
   use Magento\Eav\Setup\EavSetupFactory;
   use Magento\Framework\Setup\ModuleDataSetupInterface;
   use Magento\Framework\Setup\Patch\DataPatchInterface;
class AddAttributeCustomPrice implements DataPatchInterface
{

    private $moduleDataSetup;

    private $eavSetupFactory;


    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this ->moduleDataSetup]);
$eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY,
    'custom_price', [
        'type' => 'decimal',
        'input' => 'price',
        'backend' => Price::class,
        'frontend' => '',
        'label' => 'Custom price',
        'class' => '',
        'source' =>'',
        'global' =>
            \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => false,
        'default' => '',
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => true,
        'used_in_product_listing' => true,
        'is_html_allowed_on_front' => true,
        'unique' => false

    ]);
}


    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }


    public static function getVersion()
    {
        return '2.0.0';
    }
}
