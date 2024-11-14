<?php

namespace Magenest\CustomizeAdmin\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\OrderRepository;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Filesystem;
use Magento\Framework\Controller\ResultFactory;
class OrderItems extends Action
{
    /**
     * @var FileFactory
     */
    protected $fileFactory;
    /**
     * @var OrderRepository
     */
    protected $orderRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @param Context $context
     * @param FileFactory $fileFactory
     * @param OrderRepository $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filesystem $filesystem
     * @param DirectoryList $directoryList
     */
    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        OrderRepository $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filesystem $filesystem,
        DirectoryList $directoryList
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filesystem = $filesystem;
        $this->directoryList = $directoryList;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        //Get all order data
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();

        // Step 2: Prepare CSV header
        $csvData = [];
        $csvData[] = ['Order ID', 'Order Date', 'Customer Email', 'SKU', 'Product Name','Quantity', 'Price'];

        // Step 3: Loop through orders and collect item details
        foreach ($orders as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                $csvData[] = [
                    $order->getIncrementId(),                 // Order ID
                    $order->getCreatedAt(),                   // Order Created at
                    $order->getCustomerEmail(),               // Customer Email
                    $item->getSku(),                          // Product SKU
                    $item->getName(),                         // Product Name
                    $item->getQtyOrdered(),                   // Quantity Ordered
                    $item->getPrice()                         // Price per item
                ];
            }
        }
        // Step 4: Convert data to CSV format
        $fileName = 'export_order_items.csv';
        // check directory 'var/export/'
        $directory = $this->directoryList->getPath($this->directoryList::VAR_DIR) . '/export/';
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); //Create directory if not exist
        }
        $filePath = $directory . $fileName;

        $handle = fopen($filePath, 'w');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        // Step 5: Return the file as a download response
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => 'filename',
                'value' => $filePath,
                'rm'    => true  // remove the file after download
            ],
            $this->directoryList::VAR_DIR
        );
    }
}
