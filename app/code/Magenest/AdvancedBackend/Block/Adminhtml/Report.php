<?php

namespace Magenest\AdvancedBackend\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoCollectionFactory;


class Report extends Template
{
    protected $moduleList;
    protected $customerCollectionFactory;
    protected $productCollectionFactory;
    protected $orderCollectionFactory;
    protected $invoiceCollectionFactory;
    protected $creditmemoCollectionFactory;

    public function __construct(
        Template\Context $context,
        ModuleListInterface $moduleList,
        CustomerCollectionFactory $customerCollectionFactory,
        ProductCollectionFactory $productCollectionFactory,
        OrderCollectionFactory $orderCollectionFactory,
        InvoiceCollectionFactory $invoiceCollectionFactory,
        CreditmemoCollectionFactory $creditmemoCollectionFactory,
        array $data = []
    ) {
        $this->moduleList = $moduleList;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->invoiceCollectionFactory = $invoiceCollectionFactory;
        $this->creditmemoCollectionFactory = $creditmemoCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getTotalModules()
    {
        $allModules = $this->moduleList->getAll();
        $magentoModules = array_filter($allModules, function ($module) {
            return strpos($module['name'], 'Magento_') === 0;
        });
        $otherModules = array_filter($allModules, function ($module) {
            return strpos($module['name'], 'Magento_') !== 0;
        });

        return [
            'total' => count($allModules),
            'magento' => count($magentoModules),
            'others' => count($otherModules),
        ];
    }

    public function getTotalCustomers()
    {
        return $this->customerCollectionFactory->create()->getSize();
    }

    public function getTotalProducts()
    {
        return $this->productCollectionFactory->create()->getSize();
    }

    public function getTotalOrders()
    {
        return $this->orderCollectionFactory->create()->getSize();
    }

    public function getTotalInvoices()
    {
        return $this->invoiceCollectionFactory->create()->getSize();
    }

    public function getTotalCreditmemos()
    {
        return $this->creditmemoCollectionFactory->create()->getSize();
    }
}
