<?php


namespace Metagento\NewsletterDiscountPro\Controller\Adminhtml\Program;


class Edit extends \Metagento\NewsletterDiscountPro\Controller\Adminhtml\AbstractAction
{

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if($id){
            $model = $this->programFactory->create()->load($id);
        }
        if(isset($model) && $model->getId()){
        }


        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Metagento_NewsletterDiscountPro::newsletterdiscountpro');
        $resultPage->addBreadcrumb(__('Newsletter Discount'), __('Newsletter Discount'));
        $resultPage->addBreadcrumb(__('Programs'), __('Programs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Programs'));
        return $resultPage;
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