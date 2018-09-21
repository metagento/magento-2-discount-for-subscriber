<?php


namespace Metagento\NewsletterDiscountPro\Controller\Adminhtml\Program;


class NewAction extends
    \Metagento\NewsletterDiscountPro\Controller\Adminhtml\AbstractAction
{
    public function execute()
    {
        $resultForward = $this->forwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }

    /**
     * Is the user allowed to view the blog post grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Metagento_NewsletterDiscountPro::program');
    }

}