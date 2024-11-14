<?php
/**
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magenest\Movie\Model\Movie;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;

class Save extends Action
{
    /**
     * @var Movie
     */
    protected $movieModel;
    /**
     * @var Session
     */
    protected $adminSession;

    /**
     * @param Context $context
     * @param Movie $movieModel
     * @param Session $adminSession
     */
    public function __construct(
        Action\Context $context,
        Movie          $movieModel,
        Session        $adminSession
    ) {
        parent::__construct($context);
        $this->movieModel = $movieModel;
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
            $movie_id = $this->getRequest()->getParam('movie_id');
            if ($movie_id) {
                $this->movieModel->load($movie_id);
            }
            $this->movieModel->setData($data);
            try {
                $this->movieModel->save();
                $movie_id = $this->movieModel->getId();
                $this->messageManager->addSuccess(__('The data has been saved.'));

                //Save Data to Pivot table
                if (isset($data['actor_ids']) && is_array($data['actor_ids'])) {
                    $this->saveMovieActorsData($movie_id, $data['actor_ids']);
                }
                $this->movieModel->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['movie_id' => $this->movieModel->getId(), '_current' => true]);
                    }
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException|\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['movie_id' => $this->getRequest()->getParam('movie_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function saveMovieActorsData($movie_id, $actor_ids)
    {
        $connection = $this->movieModel->getResource()->getConnection();
        $pivotTable = $this->movieModel->getResource()->getTable('magenest_movie_actor');

        foreach ($actor_ids as $actor_id) {
            $connection->insertOnDuplicate($pivotTable, [
                'movie_id' => $movie_id,
                'actor_id' => $actor_id
            ], ['actor_id']);
        }
    }
}
