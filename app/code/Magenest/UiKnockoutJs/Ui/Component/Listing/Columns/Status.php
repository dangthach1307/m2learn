<?php

namespace Magenest\UiKnockoutJs\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Status extends Column
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
                $status = $item['enable'];
                $item['enable'] = ($status == 1) ? __('ENABLED'): __('UN-ENABLED');
                $cssClass = ($status == 1) ? 'grid-severity-notice' : 'grid-severity-critical';
                $item['enable'] = $this->decorateStatus($item['enable'] , $cssClass);
            }
        }

        return $dataSource;
    }
    public function decorateStatus($value, $cssClass)
    {
        return '<span style="width:100px" class="' . $cssClass . '"><span>' . $value . '</span></span>';
    }
}
