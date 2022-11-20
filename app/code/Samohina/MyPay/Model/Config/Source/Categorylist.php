<?php
namespace Samohina\Discount\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Categorylist implements ArrayInterface
{
    protected $_categoryHelper;

    public function __construct(\Magento\Catalog\Helper\Category $catalogCategory)
    {
        $this->_categoryHelper = $catalogCategory;
    }

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }

    public function toOptionArray()
    {

        $arr = $this->toArray();
        $ret = [];

        foreach ($arr as $key => $value)
        {

            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    public function toArray()
    {

        $categories = $this->getStoreCategories(true,false,true);

        $catagoryList = array();
        foreach ($categories as $category){

            $catagoryList[$category->getEntityId()] = __($category->getName().' (ID: '.$category->getEntityId().')');
        }

        return $catagoryList;
    }

}
