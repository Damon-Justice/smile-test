<?php

namespace Smile\Contact\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('contact_us_table')
        )->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => false,
                'nullable' => false,
                'primary' => true
            ],
            'ID'
        )->addIndex(
            $setup->getIdxName('contact_us_table', ['entity_id']),
            ['entity_id']
        )->addColumn(
			'name',
			Table::TYPE_TEXT,
			255,
			['nullable => false'],
			'Name'
		)->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            [],
            'Email'
        )->addColumn(
			'telephone',
			Table::TYPE_TEXT,
			50,
			[],
			'Phone Number'
		)->addColumn(
            'comment',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Comment'
        )->addColumn(
            'status',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'default' => '0'
            ],
            'Status'
        )->addColumn(
            'answer',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => true,
                'default' => null
            ],
            'Answer'
        )->addColumn(
            'received',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'Received'
        )->setComment('This Is Contact Us Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
