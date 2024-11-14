<?php

namespace Magenest\Movie\Model\Config\Backend\Movie;

use Magento\Framework\App\Config\Value;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory as MovieCollectionFactory;

class MovieCount extends Value
{
    protected $movieCollectionFactory;

    public function __construct(
        MovieCollectionFactory $movieCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->movieCollectionFactory = $movieCollectionFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function afterLoad()
    {
        $collection = $this->movieCollectionFactory->create();
        $movieCount = $collection->getSize();
        $this->setValue($movieCount);
        return $this;
    }
}
