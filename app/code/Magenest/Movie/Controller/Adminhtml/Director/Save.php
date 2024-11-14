<?php
/**
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magenest\Movie\Model\Director;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;

class Save extends Action
{
    /**
     * @var Director
     */
    protected $directorModel;
    /**
     * @var Session
     */
    protected $adminSession;

    /**
     * @param Context $context
     * @param Director $directorModel
     * @param Session $adminSession
     */
    public function __construct(
        Action\Context $context,
        Director       $directorModel,
        Session        $adminSession
    ) {
        parent::__construct($context);
        $this->directorModel = $directorModel;
        $this->adminSession = $adminSession;
    }

    /**
     * Save Movie record action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $director_id = $this->getRequest()->getParam('director_id');
            if ($director_id) {
                $this->directorModel->load($director_id);
            }
            $this->directorModel->setData($data);
            try {
                $this->directorModel->save();
                $movie_id = $this->directorModel->getId();
                $this->messageManager->addSuccess(__('The data has been saved.'));

                $this->directorModel->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['director_id' => $this->directorModel->getId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException|\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['movie_id' => $this->getRequest()->getParam('director_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


}
