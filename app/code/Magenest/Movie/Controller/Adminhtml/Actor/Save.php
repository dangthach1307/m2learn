<?php
/**
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magenest\Movie\Model\Actor;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\Controller\Result\Redirect;

class Save extends Action
{
    /**
     * @var Actor
     */
    protected $actorModel;
    /**
     * @var Session
     */
    protected $adminSession;

    /**
     * @param Context $context
     * @param Actor $actorModel
     * @param Session $adminSession
     */
    public function __construct(
        Action\Context $context,
        Actor          $actorModel,
        Session        $adminSession
    ) {
        parent::__construct($context);
        $this->actorModel = $actorModel;
        $this->adminSession = $adminSession;
    }

    /**
     * Save Movie record action
     *
     * @return Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $actor_id = $this->getRequest()->getParam('actor_id');
            if ($actor_id) {
                $this->actorModel->load($actor_id);
            }
            $this->actorModel->setData($data);
            try {
                $this->actorModel->save();
                $movie_id = $this->actorModel->getId();
                $this->messageManager->addSuccess(__('The data has been saved.'));

                $this->actorModel->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['actor_id' => $this->actorModel->getId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException|\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['actor_id' => $this->getRequest()->getParam('actor_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
