<?php

namespace Magenest\Movie\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
class ReadOnlyData extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setData('readonly',1);
        return $element->getElementHtml();
    }
}
