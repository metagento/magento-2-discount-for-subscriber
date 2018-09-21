<?php


namespace Metagento\NewsletterDiscountPro\Block\Totals\Order;


class NewsletterDiscount extends
    \Magento\Sales\Block\Order\Totals
{
    public function initTotals()
    {
        $totalsBlock = $this->getParentBlock();
        $order       = $totalsBlock->getOrder();
        $discount    = $order->getNewsletterDiscount();
        if ( $discount ) {
            $totalsBlock->addTotal(new \Magento\Framework\DataObject(array(
                                                                         'code'        => 'newsletter_discount',
                                                                         'label'       => __('Newsletter Discount'),
                                                                         'value'       => -$discount,
                                                                         'is_formated' => false,
                                                                     )), 'subtotal');
        }
    }


}