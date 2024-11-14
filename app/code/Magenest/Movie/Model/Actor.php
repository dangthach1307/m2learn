<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Model\ResourceModel\Actor as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Actor extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_actor_model';

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
