<?php

namespace Magenest\UiKnockoutJs\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
class GroupCustomerOption implements ArrayInterface
{
    private $customerGroupCollectionFactory;

    public function __construct(
        CustomerGroupCollectionFactory $customerGroupCollectionFactory
    )
    {
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }
    public function toOptionArray()
    {
        $groups = $this->customerGroupCollectionFactory->create();
        $options = [];
        foreach ($groups as $group) {
            $options[] = [
                'value' => $group->getCustomerGroupId(),
                'label' => $group->getCustomerGroupCode(),
            ];
        }
        return $options;
    }
}
