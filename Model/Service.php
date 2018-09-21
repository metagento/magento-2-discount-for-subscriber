<?php


namespace Metagento\NewsletterDiscountPro\Model;


class Service
{
    /**
     * @var \Magento\Newsletter\Model\SubscriberFactory
     */
    protected $subscriberFactory;
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Metagento\NewsletterDiscountPro\Helper\Config
     */
    protected $helperConfig;

    /**
     * @var ProgramFactory
     */
    protected $programFactory;

    public function __construct(
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Metagento\NewsletterDiscountPro\Helper\Config $helperConfig,
        ProgramFactory $programFactory
    ) {
        $this->subscriberFactory = $subscriberFactory;
        $this->orderFactory      = $orderFactory;
        $this->storeManager      = $storeManager;
        $this->helperConfig      = $helperConfig;
        $this->programFactory    = $programFactory;
    }

    /**
     * check if subscriber subscribed after valid date
     * @param $email
     * @return bool
     */
    public function isValidSubscriber( $email )
    {
        /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
        $subscriber = $this->subscriberFactory->create();
        $subscriber = $subscriber->getCollection()
                                 ->addFieldToFilter('subscriber_email', $email)
                                 ->addFieldToFilter('subscriber_status', \Magento\Newsletter\Model\Subscriber::STATUS_SUBSCRIBED)
                                 ->addFieldToFilter('store_id', $this->getStore()->getId())
                                 ->getFirstItem();
        if ( $subscriber->getId() ) {
            $program = $this->getProgramByEmail($email);
            if ( $program->getId() ) {
                return true;
            }
        }
        return false;
    }

    /**
     * get Program for email
     * @param $email
     * @return mixed
     */
    public function getProgramByEmail( $email )
    {
        /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
        $subscriber = $this->subscriberFactory->create();
        $subscriber = $subscriber->getCollection()
                                 ->addFieldToFilter('subscriber_email', $email)
                                 ->addFieldToFilter('subscriber_status', \Magento\Newsletter\Model\Subscriber::STATUS_SUBSCRIBED)
                                 ->addFieldToFilter('store_id', $this->getStore()->getId())
                                 ->getFirstItem();
        if ( $subscriber->getId() ) {
            $changeAt   = $subscriber->getChangeStatusAt();
            $collection = $this->programFactory->create()->getCollection()
                                               ->setOrder('priority');
            foreach ( $collection as $program ) {
                if ( $program->getData('from_date') && strtotime($changeAt) < strtotime($program->getData('from_date')) ) {
                    continue;
                }
                if ( $program->getData('to_date') && strtotime($changeAt) > strtotime($program->getData('to_date')) ) {
                    continue;
                }
                return $program;
            }
        }
        return $this->programFactory->create();
    }

    /**
     * get number of orders that subscriber get discount
     * @param $email
     * @return int
     */
    public function getDiscoutTimes( $email )
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order           = $this->orderFactory->create();
        $orderCollection = $order->getCollection()
                                 ->addFieldToFilter('customer_email', $email)
                                 ->addFieldToFilter('store_id', $this->getStore()->getId())
                                 ->addFieldToFilter('newsletter_discount', array('gt' => 0));
        return count($orderCollection);
    }

    /**
     * check if subscriber can get discount
     * @param $email
     * @return bool
     */
    public function canGetDiscount( $email )
    {
        $isValidSubscriber = $this->isValidSubscriber($email);
        $discountTimes     = $this->getDiscoutTimes($email);
        $maxTimes          = $this->getProgramByEmail($email)->getData('number_order');
        if ( $isValidSubscriber && $discountTimes < $maxTimes ) {
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @param $amount
     * @return float|int
     */
    public function calculateDiscount(
        $email,
        $amount
    ) {
        $program = $this->getProgramByEmail($email);
        if ( $program->getId() ) {
            $discountValue = $program->getData('discount_value');
            if ( $program->getData('discount_type') == Program::FIXED ) {
                return $discountValue;
            } else {
                return $amount * $discountValue / 100;
            }
        }
        return 0;
    }

    /**
     * @param $email
     * @param $code
     * @return bool
     */
    public function isNewsletterDiscountCoupon(
        $email,
        $code
    ) {
        $codes = $this->getProgramByEmail($email)->getData('coupon_code');
        $codes = explode(',', $codes);
        if ( in_array($code, $codes) ) {
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function useCoupon( $email )
    {
        $program = $this->getProgramByEmail($email);
        return $program->getData('use_coupon');
    }

    /**
     * get current Store
     * @return \Magento\Store\Api\Data\StoreInterface
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}