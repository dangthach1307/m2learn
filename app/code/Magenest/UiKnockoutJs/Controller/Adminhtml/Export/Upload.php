<?php

namespace Magenest\UiKnockoutJs\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\UrlInterface;
class Upload extends Action
{
    protected $_filesystem;
    protected $uploaderFactory;
    protected $resultJsonFactory;
    protected $_urlBuilder;
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\Filesystem $filesystem,
        UrlInterface $urlBuilder
    ){
        $this->_filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $uploadedFiles = [];
        try {
            $fileId = $this->getRequest()->getParam('param_name', 'image');
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $result = $uploader->save($this->_getUploadDir());

            $result['url'] = $this->_getUploadUrl($result['file']);
            return $resultJson->setData($result);
        } catch (\Exception $e) {
            return $resultJson->setData(['error' => $e->getMessage()]);
        }
    }
    protected function _getUploadDir()
    {
        return $this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            ->getAbsolutePath('banner/image/');
    }

    protected function _getUploadUrl($file)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . 'banner/image/' . $file;
    }
}
