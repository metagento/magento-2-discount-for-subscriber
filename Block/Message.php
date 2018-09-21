<?php


namespace Metagento\NewsletterDiscountPro\Block;


class Message extends
    \Magento\Framework\View\Element\Template
{
    /**
     * @var \Metagento\NewsletterDiscountPro\Helper\Config
     */
    protected $helperConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Metagento\NewsletterDiscountPro\Helper\Config $helperConfig,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->helperConfig = $helperConfig;
    }

    /**
     * check if can show message
     * @return mixed
     */
    public function showMessage()
    {
        return $this->helperConfig->isEnabled() && $this->helperConfig->showMessage();
    }

    /**
     * get message from config
     * @return mixed
     */
    public function getMessage()
    {
        return $this->helperConfig->getMessage();
    }

}