<?php
	
	namespace MageLine\CustomOptionsStock\Ui\Component\Options\Listing\Column;
	use Magento\Framework\View\Element\UiComponentFactory;
	use Magento\Framework\View\Element\UiComponent\ContextInterface;
	use Magento\Ui\Component\Listing\Columns\Column;
	
	class InStock extends Column
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
					// $items['instock'] is column name
					if ($items['in_stock'] == 1) {
						$items['in_stock'] = 'Yes';
					} else {
						$items['in_stock'] = 'No';
					}
				}
			}
			return $dataSource;
		}
	}