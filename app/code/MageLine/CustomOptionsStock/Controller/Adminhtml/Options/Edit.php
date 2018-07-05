<?php
	namespace MageLine\CustomOptionsStock\Controller\Adminhtml\Options;
	
	use Magento\Backend\App\Action;
	
	class Edit extends \Magento\Backend\App\Action
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
		
		
		/**
		 * Init actions
		 *
		 * @return \Magento\Backend\Model\View\Result\Page
		 */
		protected function _initAction()
		{
			// load layout, set active menu and breadcrumbs
			/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
			$resultPage = $this->resultPageFactory->create();
			
			return $resultPage;
		}
		
		public function execute()
		{
			
			$id = $this->getRequest()->getParam('id');
			$model = $this->_objectManager->create('MageLine\CustomOptionsStock\Model\CustomOptionsStock');
			
			if ($id) {
				$model->load($id);
				if (!$model->getId()) {
					$this->messageManager->addError(__('This product no longer exists.'));
					/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
					$resultRedirect = $this->resultRedirectFactory->create();
					
					return $resultRedirect->setPath('*/*/');
				}
			}
			
			
			
			$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			
			$this->_coreRegistry->register('mageline_customoptionsstock_options', $model);
			
			/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
			$resultPage = $this->_initAction();
			$resultPage->addBreadcrumb(
				$id ? __('Edit Product') : __('Product'),
				$id ? __('Edit Product') : __('Product')
			);
			
			$resultPage->getConfig()->getTitle()->prepend(__('Products Custom Options Stock'));
			$resultPage->getConfig()->getTitle()
				->prepend($model->getId() ? $model->getTitle() : __('Products Custom Options Stock'));
			
			return $resultPage;
		}
		
		public function getHeaderText()
		{
			if ($this->getModel()->getId()) {
				return __("Edit Product '%1'", $this->escapeHtml($this->getModel()->getLabel()));
			}
		}
		

	}