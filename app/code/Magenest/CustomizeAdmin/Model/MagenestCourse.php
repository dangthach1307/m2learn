<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Model;

use Magenest\CustomizeAdmin\Model\ResourceModel\MagenestCourse as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class MagenestCourse extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_course_model';
    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

}
