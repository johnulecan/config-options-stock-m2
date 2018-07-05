<?php
	namespace MageLine\CustomOptionsStock\Block;
	
	use Magento\Framework\Data\Collection;
	use Magento\Catalog\Model\Product;
	use Magento\Framework\Exception\LocalizedException;
	use Magento\Framework\Registry;
	
	class Options extends \Magento\Framework\View\Element\Template
	{
		
		/**
		 * @var Registry
		 */
		protected $registry;
		
		/**
		 * @var Product
		 */
		private $product;
		
		public function __construct(
			\MageLine\CustomOptionsStock\Helper\Data $helper,
			\MageLine\CustomOptionsStock\Model\CustomOptionsStockFactory $optionsStockCollection,
			\Magento\Framework\View\Element\Template\Context $context,
			Registry $registry,
			array $data
		)
		{
			$this->registry 	            = $registry;
			$this->helper 		            = $helper;
			$this->_optionsStockCollection  = $optionsStockCollection;
			
			parent::__construct($context, $data);
		}
		
		protected function _prepareLayout()
		{
			
			$this->setIsEnabled($this->helper->isEnabled());
			
			return parent::_prepareLayout();
		}
		
		public function getProduct()
		{
			if (is_null($this->product)) {
				$this->product = $this->registry->registry('product');
				
				if (!$this->product->getId()) {
					throw new LocalizedException(__('Failed to initialize product'));
				}
			}
			
			return $this->product;
		}
		
		public function getProductOptionsStock()
		{
			$product = $this->getProduct();
			$options =
				$this->_optionsStockCollection->create()
					->getCollection()
					->addFieldToFilter('product_id', ['eq' => $product->getId()])
					->addFieldToFilter('in_stock', ['eq' => 0])
			;
			
			
			return $options;
		}
	}