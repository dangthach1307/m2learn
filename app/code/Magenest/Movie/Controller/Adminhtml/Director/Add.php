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

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Add extends Action
{
    protected $resultFactory;
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add Director'));
        return $resultPage;
    }
}