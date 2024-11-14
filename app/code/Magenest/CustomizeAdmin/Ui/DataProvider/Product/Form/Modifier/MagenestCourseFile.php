<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class MagenestCourseFile extends AbstractModifier
{

    protected $storeManager;

    const FIELD_IS_DELETE = 'is_delete';
    const FIELD_SORT_ORDER_NAME = 'sort_order';
    const FIELD_COURSE_TITLE = 'course_title';
    const FIELD_COURSE_FILE = 'course_file';

    private $locator;
    private $courseFactory;
    protected  $arrayManager;
    protected $filesystem;
    protected $directoryList;

    public function __construct(
        LocatorInterface $locator,
        \Magenest\CustomizeAdmin\Model\MagenestCourseFactory $courseFactory,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        DirectoryList $directoryList
    ) {
        $this->locator = $locator;
        $this->courseFactory = $courseFactory;
        $this->storeManager = $storeManager;
        $this->filesystem=$filesystem;
        $this->directoryList=$directoryList;

    }
    protected function getFileUrl($file)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_MEDIA
        );
        // Adjust the path according to your file storage structure
        return $baseUrl . 'course/file/' . ltrim($file, '/');
    }
    protected function getFileSize($file)
    {
        try {
            $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
            $filePath = 'catalog/product/file/' . ltrim($file, '/');

            if ($mediaDirectory->isFile($filePath)) {
                return $mediaDirectory->stat($filePath)['size'];
            }
        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }
    public function modifyData(array $data)
    {
        //Get current product
        $product = $this->locator->getProduct()->getId();

        //Load course from this product through product_id
        /** @var \Magenest\CustomizeAdmin\Model\ResourceModel\MagenestCourse\Collection $courseCollection */
        $courseCollection = $this->courseFactory->create()->getCollection()
            ->addFieldToFilter('product_id', $product);
//
        $courseData = [];
        foreach ($courseCollection as $course) {
            $courseData[] = [
                'course_title' => $course->getCourseTitle(),
                'course_file' => [
                    [
                        'name' => basename($course->getCourseFile()),
                        'file' => $course->getCourseFile(),
                        'size' => $this->getFileSize($course->getCourseFile()),
                        'url' => $this->getFileUrl($course->getCourseFile()),
                        'type' => 'file'
                    ]
                ],
                'is_delete' => 0,
            ];
        }
//
        // Add the loaded course data to the data array
        $data[$product]['magenest_course_fieldset']['course_info'] = $courseData;

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'magenest_course_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Course Info'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.magenest_course_fieldset',
                                'collapsible' => false,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        "course_info" => $this->getSelectTypeGridConfig(10)
                    ],
                ]
            ]
        );
        return $meta;
    }

    protected function getSelectTypeGridConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'addButtonLabel' => __('Add Course'),
                        'componentType' => DynamicRows::NAME,
                        'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows',
                        'additionalClasses' => 'admin__field-wide',
                        'deleteProperty' => static::FIELD_IS_DELETE,
                        'deleteValue' => '1',
                        'renderDefaultRecord' => false,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                'record' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/dynamic-rows/record',
                                'positionProvider' => static::FIELD_SORT_ORDER_NAME,
                                'isTemplate' => true,
                                'is_collection' => true,
                            ],
                        ],
                    ],
                    'children' => [
                        static::FIELD_COURSE_TITLE => $this->getCourseTitleFieldConfig(1),
                        static::FIELD_COURSE_FILE => $this->getCourseFileFieldConfig(2),
                        static::FIELD_IS_DELETE => $this->getIsDeleteFieldConfig(3),
                    ]
                ]
            ]
        ];
    }

    protected function getCourseTitleFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Course Title'),
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'dataScope' => static::FIELD_COURSE_TITLE,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'visible' => true,
                        'disabled' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getCourseFileFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Course File'),
                        'componentType' => Field::NAME,
                        'formElement' => 'fileUploader',
                        'previewTmpl'=>'ui/form/element/uploader/preview',
                        'dataScope' => static::FIELD_COURSE_FILE,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'visible' => true,
                        'disabled' => false,
                        'uploaderConfig' => [
                            'url'=>'bai8/export/upload',
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getIsDeleteFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => ActionDelete::NAME,
                        'fit' => true,
                        'sortOrder' => $sortOrder
                    ],
                ],
            ],
        ];
    }

}
