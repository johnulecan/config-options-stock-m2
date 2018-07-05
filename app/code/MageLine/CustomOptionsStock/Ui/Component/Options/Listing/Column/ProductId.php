<?php
	
	namespace MageLine\CustomOptionsStock\Ui\Component\Options\Listing\Column;
	use Magento\Framework\View\Element\UiComponentFactory;
	use Magento\Framework\View\Element\UiComponent\ContextInterface;
	use Magento\Ui\Component\Listing\Columns\Column;
	
	class ProductId extends Column
	{
		public function __construct(
			ContextInterface $context,
			UiComponentFactory $uiComponentFactory,
			array $components = [],
			array $data = []
		) {
			parent::__construct($context, $uiComponentFactory, $components, $data);
		}
		
		public function prepareDataSource(array $dataSource)
		{
			if (isset($dataSource['data']['items'])) {
				foreach ($dataSource['data']['items'] as &$items) {
					$productId = $items['product_id'];
					$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
					$product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
					$items['product_id'] = $product->getName(). ' - '.$product->getSku();
				}
			}
			return $dataSource;
		}
	}