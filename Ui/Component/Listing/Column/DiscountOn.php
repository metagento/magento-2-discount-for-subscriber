<?php


namespace Metagento\NewsletterDiscountPro\Ui\Component\Listing\Column;


class DiscountOn implements
    \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => __('Subtotal'), 'value' => \Metagento\NewsletterDiscountPro\Model\Program::SUBTOTAL],
            ['label' => __('Grand Total'), 'value' => \Metagento\NewsletterDiscountPro\Model\Program::GRANDTOTAL],
//            ['label' => __('Fixed'), 'value' => \Metagento\NewsletterDiscountPro\Model\Program::FIXED],
        ];
    }
}