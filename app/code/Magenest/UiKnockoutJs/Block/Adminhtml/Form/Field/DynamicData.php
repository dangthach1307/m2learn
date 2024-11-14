<?php

namespace Magenest\UiKnockoutJs\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
class DynamicData extends AbstractFieldArray
{
    private $colorRenderer;
    protected function _prepareToRender()
    {
        //Add color name column
        $this->addColumn(
            'color_name',
            [
                'label' => __('Color name'),
                'class'=>'required-entry',
            ]
        );
        //Add color code column
        $this->addColumn(
            'color_code',
            [
                'label' => __('Color code'),
                'class'=>'required-entry',
                'renderer' => $this->getColorRenderer(),
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add More');
    }
    protected function _prepareArrayRow(DataObject $row) : void
    {

    }
    private function getColorRenderer()
    {
        if (!$this->colorRenderer) {
            $this->colorRenderer = $this->getLayout()->createBlock(
                \Magenest\UiKnockoutJs\Block\Adminhtml\Form\Field\ColorRenderer::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->colorRenderer;
    }
}
