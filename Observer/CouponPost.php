<?php


namespace Metagento\NewsletterDiscountPro\Observer;


class CouponPost implements
    \Magento\Framework\Event\ObserverInterface
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
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $cartRepository;

    public function __construct(
        \Metagento\NewsletterDiscountPro\Helper\Config $helperConfig,
        \Metagento\NewsletterDiscountPro\Model\Service $service,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository
    ) {
        $this->helperConfig          = $helperConfig;
        $this->service               = $service;
        $this->checkoutSession       = $checkoutSession;
        $this->customerSession       = $customerSession;
        $this->messageManager        = $messageManager;
        $this->resultRedirectFactory = $redirectFactory;
        $this->cartRepository        = $cartRepository;
    }


    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $request = $observer->getEvent()->getRequest();
        /** @var  \Magento\Framework\App\Action\Action $action */
        $action     = $observer->getEvent()->getControllerAction();
        $couponCode = $request->getParam('coupon_code');
        $remove     = $request->getParam('remove');
        $email      = $this->checkoutSession->getQuote()->getCustomerEmail();
        $program    = $this->service->getProgramByEmail($email);
        if ( !$this->helperConfig->isEnabled()
             || !$program->getData('use_coupon')
             || !$this->service->isNewsletterDiscountCoupon($email, $couponCode)
             || !$this->service->canGetDiscount($email)
        ) {
            return;
        }

        if ( $remove ) {
            $this->checkoutSession->setData('newsletter_discount_coupon', null);
        } else {
            $this->checkoutSession->setData('newsletter_discount_coupon', $couponCode);
            $this->checkoutSession->getQuote()->setCouponCode($couponCode);
            $this->messageManager->addSuccessMessage(__(
                                                         'You used coupon code "%1".',
                                                         htmlspecialchars($couponCode)
                                                     ));
        }
        $this->checkoutSession->getQuote()->setTotalsCollectedFlag(false)->collectTotals();
        $this->cartRepository->save($this->checkoutSession->getQuote());
        $action->getActionFlag()->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
        $action->getResponse()->setRedirect('checkout/cart')->sendResponse();
    }


}