<?php


namespace Metagento\NewsletterDiscountPro\Ui\Component\Listing\Column;


class ProgramActions extends
    \Magento\Ui\Component\Listing\Columns\Column
{

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components,
        array $data
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl    = $data['programUrlPathEdit'];
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource( array $dataSource )
    {
        if ( isset($dataSource['data']['items']) ) {
            foreach ( $dataSource['data']['items'] as & $item ) {
                $name = $this->getData('name');
                if ( isset($item['program_id']) ) {
                    $item[$name]['edit'] = [
                        'href'  => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['program_id']]),
                        'label' => __('Edit'),
                    ];

                }
            }
        }
        return $dataSource;
    }
}