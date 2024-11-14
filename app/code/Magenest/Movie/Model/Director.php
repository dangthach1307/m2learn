<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Model\ResourceModel\Director as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Director extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_director_model';

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
