<?php

namespace Magenest\UiKnockoutJs\Block\Promotion;

use Magento\Framework\View\Element\Template;
use Magenest\UiKnockoutJs\Model\ResourceModel\GPromotion\CollectionFactory;
use Magento\Customer\Model\Session as CustomerSession;

class Popup extends Template
{
    protected $promotionCollectionFactory;
    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        CollectionFactory $promotionCollectionFactory,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->promotionCollectionFactory = $promotionCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getPromotionByCustomerGroup($customerGroupId)
    {
        $collection = $this->promotionCollectionFactory->create();
        $collection->addFieldToFilter('group_customer_id', $customerGroupId);
        $collection->addFieldToFilter('status', 1);

        return $collection->getData();
    }
    public function getCustomerGroupId()
    {
        return $this->_customerSession->getCustomer()->getGroupId();
    }
}
