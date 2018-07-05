<?php
	
	namespace MageLine\CustomOptionsStock\Ui\Component\Options\Listing\Column;
	use Magento\Framework\View\Element\UiComponentFactory;
	use Magento\Framework\View\Element\UiComponent\ContextInterface;
	use Magento\Ui\Component\Listing\Columns\Column;
	
	class OptionId extends Column
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
					
					$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
					$record = $objectManager->create('MageLine\CustomOptionsStock\Model\CustomOptionsStock')->load($items['entity_id']);
					$product = $objectManager->create('Magento\Catalog\Model\Product')->load($record->getProductId());
					$customOptions = $product->getOptions() ?: [];
					foreach($customOptions as $option)
					{
						foreach($option->getValues() as $valuesVal) {
							if($valuesVal->getId() == $items['option_id']){
								$items['option_id'] = $valuesVal->getTitle();
							}
							
						}
						
					}
					
				}
			}
			return $dataSource;
		}
	}