<?php

namespace Samohina\CustomPrice\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;

class CustomContent extends AbstractModifier
{
    private $locator;
    private $helperData;

    public function __construct(
        LocatorInterface $locator,
        \Samohina\CustomPrice\Helper\Data $helperData
    ) {
        $this->locator = $locator;
        $this->helperData = $helperData;
    }

    public function modifyMeta(array $meta)
    {
         $meta = array_replace_recursive(
            $meta,
            [
                'product-details' => [
                    'children' => [
                        'container_custom_price' => [
                            'children' => [
                                'custom_price' => $this->getCustomPrice(),
                                'use_config_custom_price' => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'dataType' => 'number',
                                                'formElement' => Checkbox::NAME,
                                                'componentType' => Field::NAME,
                                                'description' => __('Allow Modify'),
                                                'dataScope' => 'use_config_custom_price',
                                                'percent' => $this->helperData->getGeneralConfig('persent_custom_price'),
                                                'component' => 'Samohina_CustomPrice/js/components/use-config-settings',
                                                 'valueMap' => [
                                                    'false' => '0',
                                                    'true' => '1',
                                                ],
                                                'links' => [
                                                        'linkedValueTo' => 'product_form.product_form_data_source:data.product.custom_price',
                                                        'linkedValueFrom' => 'product_form.product_form_data_source:data.product.price'
                                                    ],
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]

],
                ]
            ]
        );
       return $meta;
    }
    public function getCustomPrice()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Price'),
                        'additionalClasses' => 'admin__field-small',
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'dataScope' => 'custom_price',
                            'imports' => [
                                    'disabled' =>  '!${$.parentName}.use_config_${$.index}:checked',
                                    '__disableTmpl' => ['disabled' => false],
                                ]

                    ],
                ],
            ],
        ];
    }
    public function modifyData(array $data)
    {
        $modelId = $this->locator->getProduct()->getId();

        $percent= ((int)$this->helperData->getGeneralConfig('persent_custom_price') + 100)/100;

       if (isset($data[$modelId][static::DATA_SOURCE_DEFAULT]['custom_price']) && $data[$modelId][static::DATA_SOURCE_DEFAULT]['custom_price'] && round($data[$modelId][static::DATA_SOURCE_DEFAULT]['custom_price'], 0) !== round($data[$modelId][static::DATA_SOURCE_DEFAULT]['price']*$percent, 0)){
            $data[$modelId][static::DATA_SOURCE_DEFAULT]['use_config_custom_price'] = '1';
        }
        return $data;

    }

}
