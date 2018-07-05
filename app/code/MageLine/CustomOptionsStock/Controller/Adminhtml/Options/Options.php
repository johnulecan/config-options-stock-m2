<?php
	namespace MageLine\CustomOptionsStock\Controller\Adminhtml\Options;
	
	use Magento\Backend\App\Action;
	
	class Options extends \Magento\Backend\App\Action
	{
		protected $_coreRegistry = null;
		
		protected $resultPageFactory;
		
		public function __construct(
			Action\Context $context,
			\Magento\Framework\View\Result\PageFactory $resultPageFactory,
			\Magento\Framework\Registry $registry
		) {
			$this->resultPageFactory = $resultPageFactory;
			$this->_coreRegistry = $registry;
			parent::__construct($context);
		}
		
		public function execute()
		{
			
			$product_id = $this->getRequest()->getParam('id');
			
			if($product_id > 0) {
				
				$options = $this->prepareProductOptionsSelect($product_id);
				$selected_option = $this->getRequest()->getParam('option_id');
				
				$option_html = '';
				
				foreach ($options as $option_id => $option_title) {
					$selected_property = '';
					if ($option_id == $selected_option) {
						$selected_property = 'selected';
					}
					$option_html .= '<option value="' . $option_id . '" ' . $selected_property . '>' . $option_title . '</option>';
				}
				
				$result['htmlconent'] = $option_html;
				
				$this->getResponse()->representJson($this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result));
				
			}
		}
		
		protected function prepareProductOptionsSelect($productId)
		{
			if($productId){
				$options = [];
				
				$options[0] = '- Please select a product -';
				
				$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
				$product_options = $product->getOptions();
				
				foreach($product_options as $product_option){
					$values = $product_option->getValues();
					foreach($values as $value){
						
						$options[$value->getId()] = $value->getTitle();
					}
					
				}
				return $options;
			}
		}
	}