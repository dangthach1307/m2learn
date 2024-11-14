<?php

namespace Magenest\Movie\Model\ResourceModel\Director;

use Magenest\Movie\Model\Director as Model;
use Magenest\Movie\Model\ResourceModel\Director as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_director_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
