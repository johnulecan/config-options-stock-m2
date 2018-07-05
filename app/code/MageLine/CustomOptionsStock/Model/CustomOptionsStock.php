<?php
	/**
	 * Created by PhpStorm.
	 * User: Ioan
	 * Date: 7/2/2018
	 * Time: 11:01 AM
	 */
	
	namespace MageLine\CustomOptionsStock\Model;
	
	
	class CustomOptionsStock extends \Magento\Framework\Model\AbstractModel
	{
		protected function _construct()
		{
			$this->_init('MageLine\CustomOptionsStock\Model\ResourceModel\CustomOptionsStock');
		}
	}