<?php
	namespace MageLine\CustomOptionsStock\Setup;
	
	use Magento\Framework\Setup\InstallSchemaInterface;
	use Magento\Framework\Setup\ModuleContextInterface;
	use Magento\Framework\Setup\SchemaSetupInterface;
	use Magento\Framework\DB\Ddl\Table;
	
	class InstallSchema implements InstallSchemaInterface
	{
		
		public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
		{
			$installer = $setup;
			
			$installer->startSetup();
			
			$table = $installer->getConnection()
				->newTable($installer->getTable('mageline_custom_options_stock'))
				->addColumn('entity_id', Table::TYPE_INTEGER, 11, ['identity' => true, 'nullable' => false, 'primary' => true], 'Entity ID')
				->addColumn('product_id', Table::TYPE_INTEGER, 11, ['nullable' => false], 'Product ID')
				->addColumn('option_id', Table::TYPE_INTEGER, 11, ['nullable' => false], 'Product Option ID')
				->addColumn('in_stock', Table::TYPE_INTEGER, 11, ['nullable' => false], 'Stock Status (bool) 1 - In stock')
			;
			
			$installer->getConnection()->createTable($table);
			
			$installer->endSetup();
		}
		
	}