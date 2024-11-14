<?php

namespace Magenest\Movie\Model;

use Magenest\Movie\Model\ResourceModel\Movie as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Movie extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_movie_model';

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
