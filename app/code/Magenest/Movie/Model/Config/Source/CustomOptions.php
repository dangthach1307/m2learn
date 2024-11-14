<?php

namespace Magenest\Movie\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class CustomOptions implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['label'=>__('show'), 'value'=>1],
            ['label'=>__('not-show'), 'value'=>2],
        ];
    }
}
