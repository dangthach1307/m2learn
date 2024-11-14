<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class CatchChangeConfig implements ObserverInterface
{
    protected $logger;
    protected $request;
    protected $configWriter;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        RequestInterface         $request,
        WriterInterface          $configWriter
    )
    {
        $this->logger = $logger;
        $this->request = $request;
        $this->configWriter = $configWriter;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //get the field data
        $param = $this->request->getParam('groups');
        $textFieldValue = $param['movie_general']['fields']['text_field']['value'];

        $this->logger->info('Text Field Value: ' . $textFieldValue);

        //Check if text_field value = ping ?
        if($textFieldValue == 'Ping')
        {
            $this->configWriter->save('movies/movie_general/text_field', 'Pong');
            $this->logger->info('Text Field Value: ' . $textFieldValue);
        }
    }
}
