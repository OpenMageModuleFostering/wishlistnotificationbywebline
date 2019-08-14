<?php
class Wli_Wishlistnotificationbywli_Block_Notification extends Mage_Catalog_Block_Product_List
{
	public function __construct()
	{
		parent::__construct();
	}
 	public function getNotificationConfig() {
			$notificationConfig = array();
			$notificationConfig['allow'] = Mage::getStoreConfig('notification/general/allow');
			$notificationConfig['content'] = Mage::getStoreConfig('notification/general/content');
			$notificationConfig['bgcolor'] = Mage::getStoreConfig('notification/general/bgcolor');
			$notificationConfig['fontcolor'] = Mage::getStoreConfig('notification/general/fontcolor');
			$notificationConfig['fonttype'] = Mage::getStoreConfig('notification/general/fonttype');
			$notificationConfig['fontsize'] = Mage::getStoreConfig('notification/general/fontsize');	
			return $notificationConfig;
		}		
}
