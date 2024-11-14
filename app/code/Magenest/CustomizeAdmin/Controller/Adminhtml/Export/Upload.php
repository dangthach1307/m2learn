<?php

namespace Magenest\CustomizeAdmin\Controller\Adminhtml\Export;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\File\UploaderFactory;
class Upload extends \Magento\Backend\App\Action
{
    protected $_filesystem;
    protected $uploaderFactory;
    protected $resultJsonFactory;
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\Filesystem $filesystem
    ){
        $this->_filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $uploadedFiles = [];
        $result = [];
        try {
            $files = $this->getRequest()->getFiles('magenest_course_fieldset'); // Fetch all files
            if ($files && is_array($files['course_info'])) {
                foreach ($files['course_info'] as $index => $fileData) {
                    if (isset($fileData['course_file']) && $fileData['course_file']['name']) {
                        $uploader = $this->uploaderFactory->create(['fileId' => 'magenest_course_fieldset[course_info]['.$index.'][course_file]']);
                        $uploader->setFilesDispersion(false);
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setAllowedExtensions(['pdf', 'docx', 'csv', 'txt','php','xml']); // Adjust allowed types

                        // Save the uploaded file
                        $result = $uploader->save($this->_getUploadDir());

                        // Store the result for each uploaded file
                        $uploadedFiles[$index] = $result;
                    }
                }
            }


            return $resultJson->setData($result);
        } catch (\Exception $e) {
            return $resultJson->setData(['error' => $e->getMessage()]);
        }
    }
    protected function _getUploadDir()
    {
        return $this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            ->getAbsolutePath('catalog/product/file/');
    }
}
