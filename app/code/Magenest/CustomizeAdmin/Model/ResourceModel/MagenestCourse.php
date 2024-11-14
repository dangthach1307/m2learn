<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MagenestCourse extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_course_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('magenest_course', 'id');
        $this->_useIsObjectNew = true;
    }

}
