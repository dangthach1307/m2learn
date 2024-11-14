<?php
/*
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Model\MagenestCourse;

use Magenest\CustomizeAdmin\Model\ResourceModel\MagenestCourse\CollectionFactory as CourseCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    // @codingStandardsIgnoreStart
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CourseCollectionFactory $courseCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $courseCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    // @codingStandardsIgnoreEnd
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $course) {
            $this->loadedData[$course->getId()] = $course->getData();
        }
        return $this->loadedData;
    }
}
