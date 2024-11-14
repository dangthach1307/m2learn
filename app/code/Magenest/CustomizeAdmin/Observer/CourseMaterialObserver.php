<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Observer;

use Magenest\CustomizeAdmin\Model\MagenestCourseFactory;
use Magenest\CustomizeAdmin\Model\ResourceModel\MagenestCourse;
use Magenest\CustomizeAdmin\Model\ResourceModel\MagenestCourse\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Observes the `catalog_product_save_after` event.
 */
class CourseMaterialObserver implements ObserverInterface
{
    protected $courseMaterialsResource;
    protected $courseMaterialsFactory;
    protected $collectionFactory;

    protected $request;

    public function __construct(
        MagenestCourseFactory $courseMaterialsFactory,
        MagenestCourse        $courseMaterialsResource,
        CollectionFactory     $collectionFactory,
        RequestInterface      $request
    )
    {
        $this->courseMaterialsResource = $courseMaterialsResource;
        $this->courseMaterialsFactory = $courseMaterialsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
    }

//    public function execute(Observer $observer)
//    {
//        $product = $observer->getEvent()->getProduct();
//
//        $dynamicData = $this->request->getParam('magenest_course_fieldset');
//
//        if (is_array($dynamicData) && isset($dynamicData['course_info'])) {
//            foreach ($dynamicData['course_info'] as $data) {
//                $courseMaterials=$this->courseMaterialsFactory->create();
//                $courseMaterials->setData('product_id', $product->getId());
//                if (isset($data['course_title'])) {
//                    $courseMaterials->setData('course_title', $data['course_title']);
//                }
//                if (isset($data['course_file'][0]['file'])) {
//                    $courseMaterials->setData('course_file', $data['course_file'][0]['file']);
//                }
//                // Save course material data
//                try {
//                    $this->courseMaterialsResource->save($courseMaterials);
//                } catch (\Exception $e) {
//                    throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
//                }
//            }
//        }
//    }
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();

        // Xóa data cũ trước khi thêm mới
        $existingCollection = $this->collectionFactory->create()
            ->addFieldToFilter('product_id', $productId);
        foreach ($existingCollection as $item) {
            $this->courseMaterialsResource->delete($item);
        }

        $dynamicData = $this->request->getParam('magenest_course_fieldset');

        if (is_array($dynamicData) && isset($dynamicData['course_info'])) {
            foreach ($dynamicData['course_info'] as $data) {
                if (isset($data['is_delete']) && $data['is_delete']) {
                    continue; // Skip deleted items
                }

                $courseMaterials = $this->courseMaterialsFactory->create();
                $courseMaterials->setData('product_id', $productId);

                if (isset($data['course_title'])) {
                    $courseMaterials->setData('course_title', $data['course_title']);
                }

                if (isset($data['course_file'][0]['file'])) {
                    $courseMaterials->setData('course_file', $data['course_file'][0]['file']);
                }

                try {
                    $this->courseMaterialsResource->save($courseMaterials);
                } catch (\Exception $e) {
                    throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
                }
            }
        }
    }
}
