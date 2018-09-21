<?php


namespace Metagento\NewsletterDiscountPro\Plugin\Quote;


class CouponManagement
{
    protected $helperConfig;
    protected $service;
    protected $cartRepository;
    protected $checkoutSession;

    public function __construct(
        \Metagento\NewsletterDiscountPro\Helper\Config $helperConfig,
        \Metagento\NewsletterDiscountPro\Model\Service $service,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->helperConfig    = $helperConfig;
        $this->service         = $service;
        $this->cartRepository  = $cartRepository;
        $this->checkoutSession = $checkoutSession;
    }

    public function aroundSet(
        \Magento\Quote\Model\CouponManagement $subject,
        callable  $proceed,
        $cartID,
        $couponCode
    ) {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->cartRepository->getActive($cartID);
        $email = $quote->getCustomerEmail();
        $program = $this->service->getProgramByEmail($email);
        if ( $this->helperConfig->isEnabled()
             && $program->getData('use_coupon')
             && $this->service->isNewsletterDiscountCoupon($email,$couponCode)
             && $this->service->canGetDiscount($email)
        ) {
            $this->checkoutSession->setData('newsletter_discount_coupon', $couponCode);
            $quote->setCouponCode($couponCode);
            $quote->setTotalsCollectedFlag(false)->collectTotals();
            $this->cartRepository->save($quote);
            return true;
        }else{
            $this->checkoutSession->setData('newsletter_discount_coupon', null);
            $proceed($cartID, $couponCode);
        }
    }

    public function aroundRemove(
        \Magento\Quote\Model\CouponManagement $subject,
        callable  $proceed,
        $cartID
    ){
        $this->checkoutSession->setData('newsletter_discount_coupon', null);
        $proceed($cartID);
    }
}