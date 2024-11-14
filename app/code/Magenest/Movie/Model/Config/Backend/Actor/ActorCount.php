<?php

namespace Magenest\Movie\Model\Config\Backend\Actor;

use Magento\Framework\App\Config\Value;
use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory as ActorCollectionFactory;

class ActorCount extends Value
{
    protected $actorCollectionFactory;

    public function __construct(
        ActorCollectionFactory $actorCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->actorCollectionFactory = $actorCollectionFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function afterLoad()
    {
        $collection = $this->actorCollectionFactory->create();
        $count = $collection->getSize();
        $this->setValue($count);
        return $this;
    }
}
