<?php
namespace Samohina\Social\Model\Attribute\Frontend;
class Social extends
    \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    public function getValue(\Magento\Framework\DataObject $object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
return "<b>$value</b>";
}
}
