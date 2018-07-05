<?php
	
	namespace MageLine\CustomOptionsStock\Controller\Adminhtml\Options;
	
	use Magento\Framework\App\Action\Action;
	use Magento\Framework\App\Action\Context;
	use Magento\Framework\View\Result\PageFactory;
	
	class Index extends Action
	{
		protected $resultPageFactory;
		
		public function __construct(Context $context, PageFactory $resultPageFactory)
		{
			$this->resultPageFactory = $resultPageFactory;
			parent::__construct($context);
		}
		
		public function execute()
		{
			$resultPage = $this->_initAction();
			$resultPage->addBreadcrumb(
				 __('Products Custom Options Stock'),
				 __('Products Custom Options Stock')
			);
			
			$resultPage->getConfig()->getTitle()->prepend(__('Products Custom Options Stock Management'));
			$resultPage->getConfig()->getTitle()
				->prepend(__('Products Custom Options Stock Management'));
			return $this->resultPageFactory->create();
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
	}