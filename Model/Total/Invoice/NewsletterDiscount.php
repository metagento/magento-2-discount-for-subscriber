<?php


namespace Metagento\NewsletterDiscountPro\Model\Total\Invoice;


class NewsletterDiscount extends
    \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */

    public function collect( \Magento\Sales\Model\Order\Invoice $invoice )
    {
        $order        = $invoice->getOrder();
        $discount     = $order->getNewsletterDiscount();
        $baseDiscount = $order->getBaseNewsletterDiscount();

        $invoice->setNewsletterDiscount($discount);
        $invoice->setBaseNewsletterDiscount($baseDiscount);

        $invoice->setGrandTotal($invoice->getGrandTotal() - $discount);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $baseDiscount);
        return $this;
    }

}