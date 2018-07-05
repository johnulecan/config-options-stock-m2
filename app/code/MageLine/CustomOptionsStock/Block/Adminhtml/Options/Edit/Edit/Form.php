<?php
	
	namespace MageLine\CustomOptionsStock\Block\Adminhtml\Options\Edit\Edit;
	
	use Magento\Config\Model\Config\Source\Yesno;
	use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductsCollection;
	use \Magento\Catalog\Api\ProductCustomOptionRepositoryInterface as productOptionRepository;
	use Magento\Framework\Json\Helper\Data as JsonHelper;
	
	class Form extends \Magento\Backend\Block\Widget\Form\Generic
	{
		protected $_systemStore;
		protected $_yesNo;
		protected $_wysiwygConfig;
		protected $rules;
		
		public function __construct(
			\Magento\Backend\Block\Template\Context $context,
			\Magento\Framework\Registry $registry,
			\Magento\Framework\Data\FormFactory $formFactory,
			\Magento\Store\Model\System\Store $systemStore,
			\Magento\Store\Model\StoreManagerInterface $storeManager,
			\Magento\SalesRule\Model\Rule $rules,
			Yesno $yesNo,
			ProductsCollection $productsCollectionFactory,
			productOptionRepository $productOptionRepository,
			JsonHelper $jsonHelper,
			\Magento\Catalog\Model\ProductFactory $productFactory,
			array $data = []
		) {
			
			$this->_systemStore                 = $systemStore;
			$this->_yesNo                       = $yesNo;
			$this->_productCollectionFactory    = $productsCollectionFactory;
			$this->_productOptions              = $productOptionRepository;
			$this->_productFactory              = $productFactory;
			$this->rules                        = $rules;
			$this->_storeManager                = $storeManager;
			$this->jsonHelper                   = $jsonHelper;
			
			parent::__construct($context, $registry, $formFactory, $data);
		}
		
		protected function _construct()
		{
			parent::_construct();
			$this->setId('customoptionsstock_form');
		}
		
		protected function _prepareForm()
		{
			$model = $this->_coreRegistry->registry('mageline_customoptionsstock_options');
			
			/** @var \Magento\Framework\Data\Form $form */
			$form = $this->_formFactory->create(
				['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype'   => 'multipart/form-data',]]
			);
			
			$form->setHtmlIdPrefix('customoptionsstock_');
			
			$fieldset = $form->addFieldset(
				'base_fieldset',
				['legend' => __('Set product custom option stock'), 'class' => 'fieldset-wide']
			);
			
			$elements['product_id'] = $fieldset->addField(
				'product_id',
				'select',
				[
					'label' => __('Product'),
					'title' => __('Product'),
					'name' => 'product_id',
					'value' => $model->getProductId(),
					'required' => true,
					'options' => $this->prepareProductsSelect()
				]
			);
			$elements['product_id']->setAfterElementHtml(
			"
			<script type='text/javascript'>
				require(['jquery','mage/template','jquery/ui','mage/translate'],
					function($, mageTemplate) {
					$(document).ready( function(){
					if($('select[name=product_id] > option').length > 0) {
							autoOptionId();   //Edit
							$('select[name=product_id]').change(function(){    //Add
								autoOptionId();
							});
					}
						 function autoOptionId(){
							if($('select[name=product_id] > option').length > 0) {
							var product_id = $('select[name=product_id] option:selected').val();
							$.ajax({
							url : '". $this->getUrl('mglcustomoptionsstock/options/options') . "',
							data: {form_key: window.FORM_KEY,id: product_id, option_id : ".($model->getOptionId() ? : 0)."},
							type: 'get',
							dataType: 'json',
							showLoader: true,
							success: function(data){
									  $('#customoptionsstock_option_id').empty();
									  $('#customoptionsstock_option_id').append(data.htmlconent);
									}
								});
							}
						}
					});
				});
			</script>
			"
			);
			
				$fieldset->addField(
					'option_id',
					'select',
					[
						'label'    => __('Option'),
						'title'    => __('Option'),
						'name'     => 'option_id',
						'value'    => $model->getOptionId(),
						'required' => FALSE,
						'options'  => $this->prepareProductOptionsSelect($model->getProductId() ? $model->getProductId() : FALSE)
					]
				);
			
			
			$fieldset->addField(
				'in_stock',
				'select',
				[
					'label' => __('Is option in stock?'),
					'title' => __('Is option in stock?'),
					'name' => 'in_stock',
					'required' => true,
					'value' => $model->getInStock(),
					'options' => ['1' => __('YES'), '0' => __('NO')]
				]
			);
			
			$fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id', 'value' => $model->getEntityId()] );
			
			
			$form->setValues($model->getData());
			$form->setUseContainer(true);
			$this->setForm($form);
			
			return parent::_prepareForm();
		}
		
		public function getProductCollection()
		{
			$collection = $this->_productCollectionFactory->create();
			$collection->addAttributeToSelect('*');
			
			return $collection;
		}
		
		public function prepareProductsSelect(){
			
			$options = [];
			
			$options[0] = '- Please select a product -';
			foreach($this->getProductCollection() as $product_item){
				$product = $this->_productFactory->create()->load($product_item->getId());
				$options[$product->getId()] = $product->getName().' - '.$product->getSku();
				
			}
			
			return $options;
		}
		
		protected function prepareProductOptionsSelect($productId)
		{
			if($productId){
				$options = [];
				
				$options[0] = '- Please select a product -';
				
				$product = $this->_productFactory->create()->load($productId);
				$product_options = $this->_productOptions->getProductOptions($product);
				
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