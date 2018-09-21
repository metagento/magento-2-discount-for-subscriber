<?php


namespace Metagento\NewsletterDiscountPro\Model\Total\Quote;


class NewsletterDiscount extends
    \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    /**
     * @var \Metagento\NewsletterDiscountPro\Helper\Config
     */
    protected $helperConfig;

    /**
     * @var \Metagento\NewsletterDiscountPro\Model\Service
     */
    protected $service;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Metagento\NewsletterDiscountPro\Model\Program
     */
    protected $_program;

    public function __construct(
        \Metagento\NewsletterDiscountPro\Helper\Config $helperConfig,
        \Metagento\NewsletterDiscountPro\Model\Service $service,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->helperConfig    = $helperConfig;
        $this->service         = $service;
        $this->priceCurrency   = $priceCurrency;
        $this->checkoutSession = $checkoutSession;
    }

    protected function validate(
        \Magento\Quote\Model\Quote $quote,
        $address
    ) {
        $email   = $quote->getCustomerEmail();
        $program = $this->service->getProgramByEmail($email);
        if ( !$this->helperConfig->isEnabled() ) {
            return false;
        }
        if ( !$program->getId() || !$this->service->canGetDiscount($email) ) {
            return false;
        }
        if ( $program->getData('use_coupon') && !$this->checkoutSession->getData('newsletter_discount_coupon') ) {
            return false;
        }
        if ( $quote->isVirtual() && $address->getAddressType() == 'shipping' ) {
            return false;
        }
        if ( !$quote->isVirtual() && $address->getAddressType() == 'billing' ) {
            return false;
        }
        $this->_program = $program;
        return true;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $address = $shippingAssignment->getShipping()->getAddress();
//        \Zend_Debug::dump($this->validate($quote, $address));
//        die();
        if ( !$this->validate($quote, $address) ) {
            $this->checkoutSession->setData('newsletter_discount', null);
            $this->checkoutSession->setData('base_newsletter_discount', null);
            return $this;
        }
        $discountOn = $this->_program->getData('discount_on');
        $amount     = 0;
        if ( $discountOn == \Metagento\NewsletterDiscountPro\Model\Config\Source\DiscountOn::SUBTOTAL ) {
            $amount = $total->getBaseSubtotal();
        }
        if ( $discountOn == \Metagento\NewsletterDiscountPro\Model\Config\Source\DiscountOn::GRANDTOTAL ) {
            $amount = $total->getData('base_subtotal_with_discount')
                      + $total->getData('base_shipping_amount');
        }
        $baseDiscountAmount = $this->service->calculateDiscount($quote->getCustomerEmail(), $amount);
        $discountAmount     = $this->priceCurrency->convert($baseDiscountAmount);

        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscountAmount);
        $total->setGrandTotal($total->getGrandTotal() - $discountAmount);
        $total->setBaseNewsletterDiscount($baseDiscountAmount);
        $total->setNewsletterDiscount($discountAmount);
        $total->setBaseTotalAmount($this->getCode(), -$baseDiscountAmount);
        $total->setTotalAmount($this->getCode(), -$discountAmount);
        $this->checkoutSession->setData('newsletter_discount', $discountAmount);
        $this->checkoutSession->setData('base_newsletter_discount', $baseDiscountAmount);
        $quote->setBaseNewsletterDiscount($baseDiscountAmount);
        $quote->setNewsletterDiscount($discountAmount);
        return $this;
    }

    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $discount = $this->checkoutSession->getData('newsletter_discount');
        if ( $discount ) {
            return [
                'code'  => $this->getCode(),
                'title' => __('Newsletter Discount'),
                'value' => -$discount,
            ];
        }
    }

}