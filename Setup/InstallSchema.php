<?php


namespace Metagento\NewsletterDiscountPro\Setup;

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements
    \Magento\Framework\Setup\InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     */
    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Drop tables if exists
         */
        $installer->getConnection()->dropTable($installer->getTable('newsletterdiscountpro_program'));
        /**
         * Create table 'newsletterdiscountpro_program'
         */
        $table = $installer->getConnection()
                           ->newTable($installer->getTable('newsletterdiscountpro_program'))
                           ->addColumn(
                               'program_id', Table::TYPE_INTEGER, null,
                               ['identity' => true, 'nullable' => false, 'primary' => true, 'auto_increment' => true]
                           )
                           ->addColumn(
                               'from_date', Table::TYPE_DATETIME, null,
                               ['nullable' => true]
                           )
                           ->addColumn(
                               'to_date', Table::TYPE_DATETIME, null,
                               ['nullable' => true]
                           )
                           ->addColumn(
                               'number_order', Table::TYPE_INTEGER, null,
                               ['nullable' => false, 'default' => 0]
                           )
                           ->addColumn(
                               'use_coupon', Table::TYPE_INTEGER, 3,
                               ['nullable' => false, 'default' => 0]
                           )
                           ->addColumn(
                               'coupon_code', Table::TYPE_TEXT, null,
                               ['nullable' => false, 'default' => '']
                           )
                           ->addColumn(
                               'discount_type', Table::TYPE_TEXT, 100,
                               ['nullable' => false, 'default' => '']
                           )
                           ->addColumn(
                               'discount_value', Table::TYPE_DECIMAL, null,
                               ['nullable' => false, 'default' => 0]
                           )
                           ->addColumn(
                               'discount_on', Table::TYPE_TEXT, 100,
                               ['nullable' => false, 'default' => '']
                           )
                           ->addColumn(
                               'created_at', Table::TYPE_DATETIME, null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'priority', Table::TYPE_INTEGER, null,
                               ['nullable' => false]
                           );
        $installer->getConnection()->createTable($table);

        $installer->getConnection()->addColumn($setup->getTable('sales_order'), 'newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');
        $installer->getConnection()->addColumn($setup->getTable('sales_order'), 'base_newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');
        $installer->getConnection()->addColumn($setup->getTable('sales_invoice'), 'newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');
        $installer->getConnection()->addColumn($setup->getTable('sales_invoice'), 'base_newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');
        $installer->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');
        $installer->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'base_newsletter_discount', 'DECIMAL(10,2) NOT NULL DEFAULT 0');

        $installer->endSetup();
        return;
    }
}