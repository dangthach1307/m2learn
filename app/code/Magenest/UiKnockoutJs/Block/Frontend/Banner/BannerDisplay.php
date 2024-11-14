<?php

namespace Magenest\UiKnockoutJs\Block\Frontend\Banner;

use Magento\Framework\View\Element\Template;
use Magenest\UiKnockoutJs\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class BannerDisplay extends Template
{
    protected $collectionFactory;
    protected $storeManager;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }
    public function getBanners()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('enable',1);
        $collection->setOrder('id','ASC');
        $collection->setPageSize(2);
        return $collection;
    }
    public function getImageUrl($imagePath)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl . 'banner/image/' . $imagePath;
    }
}
