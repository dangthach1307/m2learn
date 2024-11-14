<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order;

class OrderZeroTotalObserver implements ObserverInterface
{
    protected $invoiceService;
    protected $transaction;

    public function __construct(
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\DB\Transaction $transaction
    )
    {
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        if ($order->getGrandTotal() == 0 && $order->getState() == Order::STATE_NEW) {

            $order->setState(Order::STATE_PROCESSING)
                ->setStatus(Order::STATE_PROCESSING);
            $order->save();

            if ($order->canInvoice()) {
                $invoice = $this->invoiceService->prepareInvoice($order);
                $invoice->register();
                $invoice->pay();
                $this->transaction->addObject($invoice)->addObject($invoice->getOrder())->save();
            }
        }
    }
}
