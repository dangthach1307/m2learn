<?php

namespace Magenest\UiKnockoutJs\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magenest\UiKnockoutJs\Model\GPromotion;
class Save extends \Magento\Backend\App\Action
{
    /*
     * @var Blog
     */
    protected $promotionmodel;
    /**
     * @var Session
     */
    protected $adminsession;

    /**
     * @param Context $context
     * @param GPromotion $promotionmodel
     * @param Session $adminsession
     */
    public function __construct(
        Action\Context $context,
        GPromotion $promotionmodel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->promotionmodel = $promotionmodel;
        $this->adminsession = $adminsession;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $popup_id = $this->getRequest()->getParam('id');
            if ($popup_id) {
                $this->promotionmodel->load($popup_id);
            }
            $this->promotionmodel->setData($data);
            try {
                $this->promotionmodel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/new');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $this->promotionmodel->getId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException|\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
