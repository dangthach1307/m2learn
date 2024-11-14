<?php

namespace Magenest\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Director extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_director_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('magenest_director', 'director_id');
        $this->_useIsObjectNew = true;
    }
}
