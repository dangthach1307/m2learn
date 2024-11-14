<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\AdvancedBackend\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;

class Rating extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['rating']) {
                    $data = [];
                    for ($i = 0; $i < 10; $i++) {
                        if ($i < $item['rating']) {
                            $data[] = 'selected';
                        } else {
                            $data[] = 'notSelected';
                        }
                    }

                    $item['rating'] = $data;
                }
            }
        }
        return parent::prepareDataSource($dataSource);
    }
}
