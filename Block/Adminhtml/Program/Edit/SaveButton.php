<?php


namespace Metagento\NewsletterDiscountPro\Block\Adminhtml\Program\Edit;


class SaveButton extends
    \Magento\Customer\Block\Adminhtml\Edit\GenericButton implements
    \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{

    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Save Program'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
        return $data;
    }
}