<?php


namespace Metagento\NewsletterDiscountPro\Helper;


class Config extends
    \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * check if module is enabled
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get valid date
     * @return mixed
     */
    public function getValidFrom()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/general/valid_from', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get valid date
     * @return mixed
     */
    public function getValidTo()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/general/valid_to', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

//    DISCOUNT GROUP

    public function getDiscountTimes()
    {
        $discountTimes = $this->scopeConfig->getValue('newsletterdiscountpro/discount/number_order', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if(!$discountTimes){
            $discountTimes = 999999;
        }
        return $discountTimes;
    }

    public function getDiscountType()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/discount/discount_type', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDiscountValue()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/discount/discount_value', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDiscountOn()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/discount/discount_on', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getUseCoupon()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/discount/use_coupon', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getCouponCodes()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/discount/coupon_codes', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

//    MESSAGE GROUP

    public function showMessage()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/message/show_newsletter_box', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getMessage()
    {
        return $this->scopeConfig->getValue('newsletterdiscountpro/message/message_newsletter_box', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}