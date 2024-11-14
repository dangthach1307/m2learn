<?php

namespace Magenest\AdvancedBackend\Plugin;

use Closure;
use Magento\Sales\Ui\Component\Listing\Columns\OrderId;

class SalesOrderGrid
{
    /**
     * Modify Order grid to add Odd/Even column.
     *
     * @param OrderId $subject
     * @param Closure $proceed
     * @param array $dataSource
     * @return mixed
     */
    public function aroundPrepareDataSource(
        OrderId $subject,
        Closure $proceed,
        array   $dataSource
    )
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $orderId = $item['entity_id'];
                $item['odd_even'] = ($orderId % 2 == 0) ? 'Even' : 'Odd';
            }
        }

        return $proceed($dataSource);
    }
}
