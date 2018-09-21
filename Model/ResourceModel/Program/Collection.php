<?php


namespace Metagento\NewsletterDiscountPro\Model\ResourceModel\Program;


class Collection extends
    \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Metagento\NewsletterDiscountPro\Model\Program', 'Metagento\NewsletterDiscountPro\Model\ResourceModel\Program');
    }
}