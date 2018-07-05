<?php
	
	namespace MageLine\CustomOptionsStock\Block\Adminhtml\Options\Edit;
	
	use Magento\Config\Model\Config\Source\Yesno;
	use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductsCollection;
	
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
			\Magento\SalesRule\Model\Rule $rules,
			Yesno $yesNo,
			ProductsCollection $productsCollectionFactory,
			array $data = []
		) {
			
			$this->_systemStore                 = $systemStore;
			$this->_yesNo                       = $yesNo;
			$this->_productCollectionFactory    = $productsCollectionFactory;
			$this->rules                        = $rules;
			
			parent::__construct($context, $registry, $formFactory, $data);
		}
		
		protected function _construct()
		{
			parent::_construct();
			$this->setId('customoptionsstock_form');
		}
		
		protected function _prepareForm()
		{
			$model = $this->_coreRegistry->registry('mageline_customoptionsstock_customoptionsstock');
			
			/** @var \Magento\Framework\Data\Form $form */
			$form = $this->_formFactory->create(
				['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype'   => 'multipart/form-data',]]
			);
			
			$form->setHtmlIdPrefix('customoptionsstock_');
			
			$fieldset = $form->addFieldset(
				'base_fieldset',
				['legend' => __('General Information'), 'class' => 'fieldset-wide']
			);
			
			$fieldset->addField(
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
			
			$fieldset->addField(
				'option_id',
				'select',
				[
					'label' => __('Option'),
					'title' => __('Option'),
					'name' => 'option_id',
					'value' => $model->getOptionId(),
					'required' => true,
					'options' => $this->prepareProductsSelect()
				]
			);
			
			if ($model->getProductId()) {
				$fieldset->addField('product_id', 'hidden', ['name' => 'product_id']);
			}
			
			
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
			
			foreach($this->getProductCollection() as $product){
				$options[$product->getId()] = $product->getName();
			}
			
			return $options;
		}
		
	}