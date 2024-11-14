<?php

namespace Magenest\CustomizeAdmin\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
class CustomColumn extends Select
{
    protected $customerGroupCollection;
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        CustomerGroupCollection $customerGroupCollection, // Inject customer group collection
        array $data = []
    ) {
        $this->customerGroupCollection = $customerGroupCollection;
        parent::__construct($context, $data);
    }
    public function setInputName($value)
    {
        return $this->setName($value);
    }
    public function setInputId($value)
    {
        return $this->setId($value);
    }
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    private function getSourceOptions()
    {
        $options = [];
        $customerGroups = $this->customerGroupCollection->toOptionArray();

        foreach ($customerGroups as $group) {
            $options[] = [
                'label' => $group['label'],
                'value' => $group['value'],
            ];
        }

        return $options;
    }
}
