<?php


namespace Metagento\NewsletterDiscountPro\Ui\Component\Listing\Column;


class DiscountType implements
    \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => __('Fixed'), 'value' => \Metagento\NewsletterDiscountPro\Model\Program::FIXED],
            ['label' => __('Percentage'), 'value' => \Metagento\NewsletterDiscountPro\Model\Program::PERCENT],
        ];
    }
}