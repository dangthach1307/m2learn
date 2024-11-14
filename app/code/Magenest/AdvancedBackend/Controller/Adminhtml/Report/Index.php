<?php
namespace Magenest\AdvancedBackend\Controller\Adminhtml\Report;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ){
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magenest_AdvancedBackend::movie_report');
        $resultPage->getConfig()->getTitle()->prepend(__('Magenest Movies Report'));
        return $resultPage;
    }
}
