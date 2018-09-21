<?php


namespace Metagento\NewsletterDiscountPro\Model\Config\Source;


class DiscountType implements
    \Magento\Framework\Option\ArrayInterface
{
    const TYPE_FIXED   = 1;
    const TYPE_PERCENT = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::TYPE_FIXED, 'label' => __('Fixed')],
            ['value' => self::TYPE_PERCENT, 'label' => __('Percentage')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [self::TYPE_FIXED => __('Fixed'), self::TYPE_PERCENT => __('Percentage')];
    }
}