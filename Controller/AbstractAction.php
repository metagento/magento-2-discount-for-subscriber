<?php


namespace Metagento\NewsletterDiscountPro\Controller;


abstract class AbstractAction extends
    \Magento\Framework\App\Action\Action
{
    /**
     * @var \Metagento\NewsletterDiscountPro\Model\ProgramFactory
     */
    protected $programFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Metagento\NewsletterDiscountPro\Model\ProgramFactory $programFactory
    ) {
        parent::__construct($context);
        $this->programFactory = $programFactory;
    }

}