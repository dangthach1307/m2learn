<?php

namespace Magenest\UiKnockoutJs\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Observes the `sales_model_service_quote_submit_before` event.
 */
class ConverQuoteToOrderObserver implements ObserverInterface
{
    /**
     * Observer for sales_model_service_quote_submit_before.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $quote=$observer->getQuote();
        $order=$observer->getOrder();
        $order->setDeliveryOpt($quote->getDeliveryOpt());
        $order->setDeliveryDate($quote->getDeliveryDate());
    }
}
