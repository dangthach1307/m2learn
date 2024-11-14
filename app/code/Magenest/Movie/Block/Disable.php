<?php
namespace Magenest\Movie\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Disable extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
//        Với disable chỉ dùng được cho 1 field,
//        nếu có nhiều field thì nó chỉ hoạt động cho field đầu tiên
        $element->setDisabled('disabled');
        return $element->getElementHtml();
    }
}
