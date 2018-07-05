<?php
	
	namespace MageLine\CustomOptionsStock\Block\Adminhtml\Options;
	
	class Edit extends \Magento\Backend\Block\Widget\Form\Container
	{
		protected $_coreRegistry = null;
		
		public function __construct(
			\Magento\Backend\Block\Widget\Context $context,
			\Magento\Framework\Registry $registry,
			array $data = []
		) {
			
			$this->_coreRegistry = $registry;
			parent::__construct($context, $data);
		}
		
		protected function _construct()
		{
			$this->_objectId = 'entity_id';
			$this->_blockGroup = 'MageLine_CustomOptionsStock';
			$this->_controller = 'adminhtml_options_edit';
			
			parent::_construct();
			
			$this->buttonList->update('save', 'label', __('Save product'));
			
			
		}
		
	}