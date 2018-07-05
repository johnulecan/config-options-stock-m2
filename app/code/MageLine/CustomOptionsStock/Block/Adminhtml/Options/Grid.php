<?php
	namespace MageLine\CustomOptionsStock\Block\Adminhtml\Options;
	
	class Grid extends \Magento\Backend\Block\Widget\Grid\Container
	{
		protected function _construct()
		{
			$this->_controller = 'adminhtml_options';
			$this->_blockGroup = 'MageLine_CustomOptionsStock';
			$this->_headerText = __('Products Custom Options Stock');
			parent::_construct();
			
		}
		
		protected function _isAllowedAction($resourceId)
		{
			return $this->_authorization->isAllowed($resourceId);
		}
	}