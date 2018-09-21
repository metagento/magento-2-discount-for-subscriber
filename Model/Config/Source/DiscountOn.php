<?php


namespace Metagento\NewsletterDiscountPro\Model\Config\Source;


class DiscountOn implements
    \Magento\Framework\Option\ArrayInterface
{
    const SUBTOTAL   = 'subtotal';
    const GRANDTOTAL = 'grandtotal';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::SUBTOTAL, 'label' => __('Subtotal')],
            ['value' => self::GRANDTOTAL, 'label' => __('Grandtotal')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [self::SUBTOTAL => __('Subtotal'), self::GRANDTOTAL => __('Grandtotal')];
    }
}