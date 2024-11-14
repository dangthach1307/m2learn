<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\UiKnockoutJs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_banner_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('magenest_banner', 'id');
        $this->_useIsObjectNew = true;
    }
}
