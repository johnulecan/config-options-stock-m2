<?php
	
	namespace MageLine\CustomOptionsStock\Model\ResourceModel\CustomOptionsStock;
	
	class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
	{
		protected $_idFieldName = 'entity_id';
		
		protected function _construct(
		
		)
		{
			$this->_init('MageLine\CustomOptionsStock\Model\CustomOptionsStock', 'MageLine\CustomOptionsStock\Model\ResourceModel\CustomOptionsStock');
			
		}
		
		protected function _initSelect()
		{
			parent::_initSelect();
			
			/*
			
			$this->getSelect()->joinLeft(
				['secondTable' => $this->getTable('mageline_indiegogo_perks')],
				'main_table.perk_id = secondTable.entity_id',
				['label', 'amount', 'product_id', 'send_lynx']
			)->joinLeft(
				['shippingTable' => $this->getTable('mageline_indiegogo_shipping')],
				'main_table.shipping_id = shippingTable.entity_id',
				['name', 'address', 'address2', 'city', 'state', 'zipcode', 'country']
			);
			//$this->addFilterToMap('perktable_label', 'secondTable.label');
			*/
			return $this;
		}
	}