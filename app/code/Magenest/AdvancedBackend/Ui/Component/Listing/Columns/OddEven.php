<?php

namespace Magenest\AdvancedBackend\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class OddEven extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $orderId = $item['entity_id'];
                $item['odd_even'] = ($orderId % 2 == 0) ? 'SUCCESS' : 'ERROR';
                $cssClass = ($orderId % 2 == 0) ? 'grid-severity-notice' : 'grid-severity-critical';
                $item['odd_even'] = $this->decorateOddEven($item['odd_even'], $cssClass);
            }
        }

        return $dataSource;
    }
    public function decorateOddEven($value, $cssClass)
    {
        return '<span class="' . $cssClass . '"><span>' . $value . '</span></span>';
    }
}
