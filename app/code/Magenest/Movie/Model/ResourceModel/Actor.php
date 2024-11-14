<?php

namespace Magenest\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Actor extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'magenest_actor_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('magenest_actor', 'actor_id');
        $this->_useIsObjectNew = true;
    }
}
