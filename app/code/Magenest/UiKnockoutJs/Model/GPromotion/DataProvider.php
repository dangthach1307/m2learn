<?php
/*
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\UiKnockoutJs\Model\GPromotion;

use Magenest\UiKnockoutJs\Model\ResourceModel\GPromotion\CollectionFactory as GPromotionCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;
    // @codingStandardsIgnoreStart
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        GPromotionCollectionFactory $gpromotionCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $gpromotionCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    // @codingStandardsIgnoreEnd
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $popup) {
            $this->loadedData[$popup->getId()] = $popup->getData();
        }
        return $this->loadedData;
    }
}
