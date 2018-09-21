<?php


namespace Metagento\NewsletterDiscountPro\Observer;


class FieldSet implements
    \Magento\Framework\Event\ObserverInterface
{
    public function execute( \Magento\Framework\Event\Observer $observer )
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        $order->setNewsletterDiscount($quote->getNewsletterDiscount());
        $order->setBaseNewsletterDiscount($quote->getBaseNewsletterDiscount());
    }

}