<?php
namespace Magenest\DatabaseEav\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\GroupRepositoryInterface;

class CustomerGroup extends Template
{
    protected $_customerSession;
    protected $groupRepository;

    public function __construct(
        Template\Context $context,
        Session $customerSession,
        GroupRepositoryInterface $groupRepository,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
        parent::__construct($context, $data);
    }
    public function getCustomerGroup()
    {
        $groupId = $this->_customerSession->getCustomer()->getGroupId();
        if ($groupId) {
            try {
                $group = $this->groupRepository->getById($groupId);
                return $group->getCode(); // Return the group name (code)
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                return __('Customer group not found.');
            }
        }
        return __('No customer group found.');
    }
}
