<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\UiKnockoutJs\Block\Frontend\CustomDelivery;

class DeliveryOption extends \Magento\Framework\View\Element\Template
{
    public function getDeliveryOptions()
    {
        return [
            'current'=>__('Giao hàng trong ngày'),
            'custom'=>__('Tự chọn ngày giao hàng')
        ];
    }
}
