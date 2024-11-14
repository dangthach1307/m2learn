<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

namespace Magenest\CustomizeAdmin\Plugin\Product;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\General;
class TimeFieldPlugin
{
        private $arrayManager;

        public function  __construct(ArrayManager $arrayManager)
        {
            $this->arrayManager = $arrayManager;
        }

        public function afterModifyMeta(General $subject, array $meta)
        {
            //find path for course start time
            $courseStartTime=$this->arrayManager->findPath(
                'course_start_time',
                $meta,
                null,
                'children'
            );
            //find path for course end time
            $courseEndTime=$this->arrayManager->findPath(
                'course_end_time',
                $meta,
                null,
                'children'
            );

            //Add time limit for course start time
            if($courseStartTime){
                $meta=$this->arrayManager->merge(
                    $courseStartTime . '/arguments/data/config',
                    $meta,
                    [
                        'component' => 'Magenest_CustomizeAdmin/js/custom-datepicker',
                        'options'=>[
                            'dateFormat'=>'yyyy-MM-dd HH:mm:ss',
                            'timeFormat'=>'HH:mm:ss',
                            'showsTime'=>true,
                        ],
                    ]
                );
            }

            //Add time limit for course end time
            if($courseEndTime){
                $meta=$this->arrayManager->merge(
                    $courseEndTime . '/arguments/data/config',
                    $meta,
                    [
                        'component' => 'Magenest_CustomizeAdmin/js/custom-datepicker',
                        'options'=>[
                            'dateFormat'=>'yyyy-MM-dd HH:mm:ss',
                            'timeFormat'=>'HH:mm:ss',
                            'showsTime'=>true,
                        ],
                    ]
                );
            }
            return $meta;
        }
}
