<?php

namespace Magenest\UiKnockoutJs\Plugin\Quote;

use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class SaveDeliveryOption
{
    private $timezone;
    public function __construct(TimezoneInterface $timezone)
    {
        $this->timezone = $timezone;
    }
    public function beforeAddProduct(
        \Magento\Quote\Model\Quote $subject,
        \Magento\Catalog\Model\Product $product,
        $request = null
    ) {
        if ($request === null) {
            return [$product, $request];
        }

        $deliveryOpt = $request->getDeliveryOpt();
        if ($deliveryOpt) {
            $subject->setDeliveryOpt($deliveryOpt);

            // Xử lý ngày giao hàng
            if ($deliveryOpt === 'current') {
                // Nếu là 'current', sử dụng ngày hiện tại
                $currentDate = $this->timezone->date()->format('Y-m-d');
                $subject->setDeliveryDate($currentDate);
            } elseif ($deliveryOpt === 'custom') {
                // Nếu là 'custom', sử dụng ngày được chọn
                $customDate = $request->getDeliveryDate();
                if ($customDate) {
                    $subject->setDeliveryDate($customDate);
                }
            }
        }

        return [$product, $request];
    }
}
