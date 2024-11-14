<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\UiKnockoutJs\Model;

use Magenest\UiKnockoutJs\Model\ResourceModel\Banner as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_banner_model';

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
