<?php

namespace Magenest\UiKnockoutJs\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Add extends Action
{
    protected $resultPageFactory;

    public function __construct(

        Action\Context $context,

        PageFactory $resultPageFactory

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add Record'));
        return $resultPage;
    }
}
