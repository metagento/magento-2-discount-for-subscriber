<?php


namespace Metagento\NewsletterDiscountPro\Controller\Adminhtml;


abstract class AbstractAction extends
    \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $forwardFactory;

    /**
     * @var \Metagento\NewsletterDiscountPro\Model\ProgramFactory
     */
    protected $programFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory,
        \Metagento\NewsletterDiscountPro\Model\ProgramFactory $programFactory
    ) {
        \Magento\Backend\App\Action::__construct($context);
        $this->pageFactory    = $pageFactory;
        $this->forwardFactory = $forwardFactory;
        $this->programFactory = $programFactory;
    }


}