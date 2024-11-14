<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\DatabaseEav\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Observes the `customer_save_before` event.
 */
class SaveCustomerTelephoneObserver implements ObserverInterface
{
    /**
     * Observer for customer_save_before.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $telephone = $customer->getTelephone();
        // Kiểm tra định dạng số điện thoại
        if (!preg_match('/^0[0-9]{9}$/', $telephone)) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Số điện thoại không hợp lệ.'));
        }

        // Nếu số điện thoại hợp lệ, tiếp tục lưu
        $customer->setTelephone($telephone);
    }
}
