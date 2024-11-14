<?php

namespace Magenest\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Movie extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_movie_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('magenest_movie', 'movie_id');
        $this->_useIsObjectNew = true;
    }
}
