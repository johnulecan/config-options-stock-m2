<?php
	/**
	 * Created by PhpStorm.
	 * User: Ioan
	 * Date: 7/2/2018
	 * Time: 8:15 AM
	 */
	
	namespace MageLine\CustomOptionsStock\Helper;
	
	use Magento\Framework\App\Helper\Context;
	use Magento\Store\Model\StoreManagerInterface;
	use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
	use Magento\Framework\App\Helper\AbstractHelper;
	
	final class Data extends AbstractHelper
	{
		
		const XML_PATH_ENABLE 		    = 'magelineCustomOptionsStockSection/general/enable';
		
		public $storeManager;
		public $resourceConfig;
		
		
		public function __construct(
			Context $context,
			StoreManagerInterface $storeManager,
			ConfigInterface $resourceConfig,
			\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
		
		) {
			parent::__construct($context);
			$this->resourceConfig = $resourceConfig;
			$this->storeManager = $storeManager;
			$this->scopeConfig = $scopeConfig;
			
		}
		
		public function isEnabled()
		{
			$status = $this->_getConfig(self::XML_PATH_ENABLE );
			return (bool)$status;
		}
		
		protected function _getConfig($config)
		{
			return $this->scopeConfig->getValue($config, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		}
		
	}