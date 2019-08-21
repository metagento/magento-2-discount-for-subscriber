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
                ['identity' => true, 'nullable' => false, 'primary' => true, 'auto_increment' => true],
                "Program Id"
            )
            ->addColumn(
                'from_date', Table::TYPE_DATETIME, null,
                ['nullable' => true],
                "From Date"
            )
            ->addColumn(
                'to_date', Table::TYPE_DATETIME, null,
                ['nullable' => true],
                "To Date"
            )
            ->addColumn(
                'number_order', Table::TYPE_INTEGER, null,
                ['nullable' => false, 'default' => 0],
                "Number Order"
            )
            ->addColumn(
                'use_coupon', Table::TYPE_INTEGER, 3,
                ['nullable' => false, 'default' => 0],
                "User Coupon"
            )
            ->addColumn(
                'coupon_code', Table::TYPE_TEXT, null,
                ['nullable' => false, 'default' => ''],
                "Coupon Code"
            )
            ->addColumn(
                'discount_type', Table::TYPE_TEXT, 100,
                ['nullable' => false, 'default' => ''],
                "Discount Type"
            )
            ->addColumn(
                'discount_value', Table::TYPE_DECIMAL, null,
                ['nullable' => false, 'default' => 0],
                "Discount Value"
            )
            ->addColumn(
                'discount_on', Table::TYPE_TEXT, 100,
                ['nullable' => false, 'default' => ''],
                "Discount On"
            )
            ->addColumn(
                'created_at', Table::TYPE_DATETIME, null,
                ['nullable' => false],
                "Created At"
            )
            ->addColumn(
                'priority', Table::TYPE_INTEGER, null,
                ['nullable' => false],
                "Priority"
            );
        $installer->getConnection()->createTable($table);

        $columnDefination = [
            "type"     => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
            "length"   => "12,4",
            "nullable" => false,
            "default"  => 0,
            "comment"  => "Newsletter Discount"
        ];

        $installer->getConnection()->addColumn($setup->getTable('sales_order'), 'newsletter_discount',
            $columnDefination);
        $installer->getConnection()->addColumn($setup->getTable('sales_order'), 'base_newsletter_discount',
            $columnDefination);
        $installer->getConnection()->addColumn($setup->getTable('sales_invoice'), 'newsletter_discount',
            $columnDefination);
        $installer->getConnection()->addColumn($setup->getTable('sales_invoice'), 'base_newsletter_discount',
            $columnDefination);
        $installer->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'newsletter_discount',
            $columnDefination);
        $installer->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'base_newsletter_discount',
            $columnDefination);

        $installer->endSetup();
        return;
    }
}