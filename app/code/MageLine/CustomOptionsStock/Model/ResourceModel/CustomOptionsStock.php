<?php
	
	namespace MageLine\CustomOptionsStock\Model\ResourceModel;
	
	use Magento\Framework\Model\AbstractModel;
	use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
	use Magento\Framework\Model\ResourceModel\Db\Context;
	
	class CustomOptionsStock extends AbstractDb
	{
		protected $_date;
		
		public function __construct(Context $context, $resourcePrefix = null)
		{
			parent::__construct($context, $resourcePrefix);
		}
		
		protected function _construct()
		{
			$this->_init('mageline_custom_options_stock', 'entity_id');
		}
		
		
		public function load(AbstractModel $object, $value, $field = null)
		{
			return parent::load($object, $value, $field);
		}
		
		
	}