<?php


namespace Metagento\NewsletterDiscountPro\Model\Total\Creditmemo;


class NewsletterDiscount extends \Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal
{

    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */

    public function collect( \Magento\Sales\Model\Order\Creditmemo $creditmemo )
    {
        $order        = $creditmemo->getOrder();
        $discount     = $order->getNewsletterDiscount();
        $baseDiscount = $order->getBaseNewsletterDiscount();

        $creditmemo->setNewsletterDiscount($discount);
        $creditmemo->setBaseNewsletterDiscount($baseDiscount);

        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() - $discount);
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() - $baseDiscount);
        return $this;
    }
}