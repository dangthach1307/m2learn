<?php
/*
 *
 *  Copyright © Magento, Inc. All rights reserved.
 *  See COPYING.txt for license details.
 *
 *  Created By: Thach The Dang.
 *
 */

namespace Magenest\Movie\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\Movie\Model\ActorFactory;

class ActorOptions implements OptionSourceInterface
{
    protected $actorFactory;

    public function __construct(ActorFactory $actorFactory)
    {
        $this->actorFactory = $actorFactory;
    }

    public function toOptionArray()
    {
        $actors = $this->actorFactory->create()->getCollection()->getData();
        $options = [];

        foreach ($actors as $actor) {
            $options[] = [
                'value' => $actor['actor_id'],
                'label' => $actor['name'],
            ];
        }

        return $options;
    }
}
