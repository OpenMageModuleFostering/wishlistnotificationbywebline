<?php
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';
class Wli_Wishlistnotificationbywli_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    public function saveAction()
    {
        $storeId        = $this->getRequest()->getParam('store');
        $redirectBack   = $this->getRequest()->getParam('back', false);
        $productId      = $this->getRequest()->getParam('id');
        $isEdit         = (int)($this->getRequest()->getParam('id') != null);
        $data = $this->getRequest()->getPost();
        if($isEdit)
        {
				$product_id=$this->getRequest()->getParam('id');
				$_product = Mage::getModel('catalog/product')->load($product_id);
	 			$new_price=$data['product']['price'];
				$old_price=$_product->getPrice();
				if($new_price<$old_price)
				{
					$notification = Mage::getModel('wishlistnotificationbywli/wishlistnotificationbywli');
					$notification_collection=$notification->getCollection()
					->addFieldToFilter('product_entity_id', array('eq' => $product_id));
 					$delete_id=$notification_collection->getData()[0]['id'];
					if(!empty($delete_id))
					{
						$notification->setId($delete_id)->delete();
					}
					$notification = Mage::getModel('wishlistnotificationbywli/wishlistnotificationbywli');	
					$notification->setData('product_entity_id', $product_id);
					$notification->setData('old_price', $old_price);
					$notification->setData('new_price', $new_price);
					$notification->setData('created_time', now());
					$notification->save();
				}	
        }
        if ($data) {
            $this->_filterStockData($data['product']['stock_data']);
            $product = $this->_initProductSave();
            try {
                $product->save();
                $productId = $product->getId();

                if (isset($data['copy_to_stores'])) {
                   $this->_copyAttributesBetweenStores($data['copy_to_stores'], $product);
                }

                $this->_getSession()->addSuccess($this->__('The product has been saved.'));
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage())
                    ->setProductData($data);
                $redirectBack = true;
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            }
        }

        if ($redirectBack) {
            $this->_redirect('*/*/edit', array(
                'id'    => $productId,
                '_current'=>true
            ));
        } elseif($this->getRequest()->getParam('popup')) {
            $this->_redirect('*/*/created', array(
                '_current'   => true,
                'id'         => $productId,
                'edit'       => $isEdit
            ));
        } else {
            $this->_redirect('*/*/', array('store'=>$storeId));
        }
    }
}
