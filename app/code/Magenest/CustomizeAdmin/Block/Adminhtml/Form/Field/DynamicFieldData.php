<?php

namespace Magenest\CustomizeAdmin\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magenest\CustomizeAdmin\Block\Adminhtml\Form\Field\CustomColumn;
class DynamicFieldData extends AbstractFieldArray {
    private $dropdownRenderer;
    private $dateRenderer;
    protected function _prepareToRender() {
        //Add group customer dropdown
        $this->addColumn(
            'group_customer',
            [
                'label' => __('Customer Group'),
                'renderer' => $this->getDropdownRenderer(),
                'class'=>'required-entry',
                'style' => 'width:400px',
            ]
        );
        // Add course_start_time column with datetime input
        $this->addColumn(
            'course_start_time',
            [
                'label' => __('Start Time'),
                'class' => 'daterecuring',
                'style' => 'width:300px',
            ]
        );

        // Add course_end_time column with datetime input
        $this->addColumn(
            'course_end_time',
            [
                'label' => __('End Time'),
                'class' => 'daterecuring',
                'style' => 'width:300px',
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add More');
    }
    protected function _prepareArrayRow(DataObject $row) : void
    {
        $options = [];
        $groupCustomer = $row->getGroupCustomer();
        if ($groupCustomer !== null) {
            $options['option_' . $this->getDropdownRenderer()->calcOptionHash($groupCustomer)] = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
    // Renderer for the group_customer dropdown field
    private function getDropdownRenderer()
    {
        if (!$this->dropdownRenderer) {
            $this->dropdownRenderer = $this->getLayout()->createBlock(
                CustomColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->dropdownRenderer;
    }

    // Renderer for date input fields (course_start_time and course_end_time)
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = parent::_getElementHtml($element);
        $script = '<script type="text/javascript">
                require(["jquery", "jquery/ui", "mage/calendar"], function (jq) {
                    jq(function(){
                        function bindDatePicker() {
                            setTimeout(function() {
                                jq(".daterecuring").datepicker( { dateFormat: "mm/dd/yy" } );
                            }, 50);
                        }
                        bindDatePicker();
                        jq("button.action-add").on("click", function(e) {
                            bindDatePicker();
                        });
                    });
                });
            </script>';
        $html .= $script;
        return $html;
    }
}
