<?php
	namespace MageLine\CustomOptionsStock\Controller\Adminhtml\Options;
	
	use Magento\Backend\App\Action;
	
	class Save extends \Magento\Backend\App\Action
	{
		protected $filesystem;
		protected $fileUploaderFactory;
		
		public function __construct(
			Action\Context $context
		)
		{
			parent::__construct($context);
		}
		public function execute()
		{
			$data = $this->getRequest()->getPostValue();
			
			$resultRedirect = $this->resultRedirectFactory->create();
			if ($data) {
				
				$model = $this->_objectManager->create('MageLine\CustomOptionsStock\Model\CustomOptionsStock');
				
				$id = $data['entity_id'];
				if ($id) {
					$model->load($id);
				}else{
					unset($data['entity_id']);
				}
				
				$model->setData($data);
				
				//\Zend_Debug::dump($model->getData());die;
				
				try {
					$model->save();
					
					$this->messageManager->addSuccessMessage(__('Product saved successfully!'));
					$this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
					if ($this->getRequest()->getParam('back')) {
						return $resultRedirect->setPath('mglcustomoptionsstock/options/edit', ['id' => $model->getId(), '_current' => true]);
					}
					return $resultRedirect->setPath('*/*/');
				} catch (\Magento\Framework\Exception\LocalizedException $e) {
					$this->messageManager->addErrorMessage($e->getMessage());
				} catch (\RuntimeException $e) {
					$this->messageManager->addErrorMessage($e->getMessage());
				} catch (\Exception $e) {
					$this->messageManager->addErrorMessage($e->getMessage());
				}
				
				$this->_getSession()->setFormData($data);
				return $resultRedirect->setPath('mglcustomoptionsstock/options/edit', ['id' => $this->getRequest()->getParam('id')]);
			}
			return $resultRedirect->setPath('*/*/');
		}
	}