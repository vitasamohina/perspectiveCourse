<?php
namespace Samohina\AirFreight\Setup\Patch\Data;

   use Magento\Eav\Setup\EavSetup;
   use Magento\Eav\Setup\EavSetupFactory;
   use Magento\Framework\Setup\ModuleDataSetupInterface;
   use Magento\Framework\Setup\Patch\DataPatchInterface;
class AddAttributeAirFreight implements DataPatchInterface
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
    'air_freight_only_attribute', [
        'type' => 'varchar',
        'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
        'frontend' => '',
        'label' => 'Air freight only',
        'input' => 'select',
        'class' => '',
        'source' =>
            'Samohina\AirFreight\Model\Attribute\Source\AirFreight',
        'global' =>
            \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
        'visible' => true,
        'required' => true,
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
