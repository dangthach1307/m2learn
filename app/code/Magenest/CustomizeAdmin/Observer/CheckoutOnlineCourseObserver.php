<?php

namespace Magenest\CustomizeAdmin\Observer;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magenest\CustomizeAdmin\Model\MagenestCourseFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
/**
 * Observes the `checkout_onepage_controller_success_action` event.
 */
class CheckoutOnlineCourseObserver extends AbstractHelper implements ObserverInterface
{
    protected $transportBuilder;
    protected $orderRepository;
    protected $magenestCourseFactory;
    protected $storeManager;
    protected $inlineTranslation;


    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        OrderRepositoryInterface $orderRepository,
        MagenestCourseFactory $magenestCourseFactory,
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->orderRepository = $orderRepository;
        $this->magenestCourseFactory = $magenestCourseFactory;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        return parent::__construct($context);
    }

    public function execute(Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (!empty($orderIds)) {
            $order = $this->orderRepository->get(reset($orderIds));

            // Iterate over each product in the order
            foreach ($order->getAllVisibleItems() as $item) {
                $productId = $item->getProductId();

                // Load the course information from the custom table
                $course = $this->magenestCourseFactory->create()->load($productId, 'product_id');
                if ($course->getId()) {
                    // Prepare email data
                    $emailData = [
                        'customer_name' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
                        'product_name' => $item->getName(),
                        'course_title' => $course->getCourseTitle(),
                        'course_file' => $course->getCourseFile()
                    ];

                    // Send the email
                    $this->sendEmail($order->getCustomerEmail(), $emailData);
                }
            }
        }
    }
    protected function sendEmail($recipientEmail, $emailData)
    {
        // Disable inline translation while sending email
        $this->inlineTranslation->suspend();
        $storeId = $this->storeManager->getStore()->getId();
        $from = array('email' => "dangthach1307@gmail.com", 'name' => 'Name of Sender');
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('purchased_online_course') // Template ID from admin
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId
                ]
            )
            ->setTemplateVars($emailData)
            ->setFrom($from) // Sender email identity
            ->addTo($recipientEmail)
            ->getTransport();

        $transport->sendMessage();
        $this->inlineTranslation->resume();
        echo "Email sent successfully!";
    }
}
