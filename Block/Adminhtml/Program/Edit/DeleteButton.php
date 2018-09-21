<?php


namespace Metagento\NewsletterDiscountPro\Block\Adminhtml\Program\Edit;


class DeleteButton extends
    \Magento\Customer\Block\Adminhtml\Edit\GenericButton implements
    \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context, $registry);
        $this->request = $context->getRequest();
    }


    /**
     * @return array
     */
    public function getButtonData()
    {
        if ( $this->request->getParam('id') ) {
            $data = [
                'label'          => __('Delete'),
                'class'          => 'delete',
                'id'             => 'program-delete-button',
                'data_attribute' => [
                    'url' => $this->getDeleteUrl(),
                ],
                'on_click'       => '',
                'sort_order'     => 20,
            ];
            return $data;
        }
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->request->getParam('id')]);
    }
}