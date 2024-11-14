<?php

namespace Magenest\Movie\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\Movie\Model\DirectorFactory;

class DirectorOptions implements OptionSourceInterface
{
    protected $directorFactory;

    public function __construct(DirectorFactory $directorFactory)
    {
        $this->directorFactory = $directorFactory;
    }

    public function toOptionArray()
    {
        $actors = $this->directorFactory->create()->getCollection()->getData();
        $options = [];

        foreach ($actors as $actor) {
            $options[] = [
                'value' => $actor['director_id'],
                'label' => $actor['name'],
            ];
        }

        return $options;
    }
}
