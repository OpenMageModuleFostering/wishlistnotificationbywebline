<?php
require_once Mage::getModuleDir('controllers', 'Mage_Customer').DS.'AccountController.php';
class Wli_Wishlistnotificationbywli_AccountController extends Mage_Customer_AccountController
{
 public function indexAction()
 {	   
 	   $this->loadLayout();
 	   $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
        $this->renderLayout();
  }  
  
  public function setwishlistAction()
  {
  	$customer = Mage::getSingleton('customer/session')->getCustomer();
	$wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customer, true);
   $wishListItemCollection = $wishlist->getItemCollection();
   $wishlistData=$wishListItemCollection->getData();
	if(!empty($wishlistData))
	{
		$block = $this->getLayout()->createBlock('wishlistnotificationbywli/notification');
	  	$block->setTemplate('wishlistnotificationbywli/wishlist.phtml');
	  	echo $block->toHtml();
	}
  }
  
  // overrinding addtocart function 
  public function addtocartAction()
  {
   // 
  	$id     = $this->getRequest()->getParam('proId');  // Id For adding product to cart.
  	$wishid = $this->getRequest()->getParam('wish_id');  // Id For Removing Item from wishlist
  	$cart   = Mage::getSingleton('checkout/cart');
  	
  	$qty=$this->getRequest()->getParam('qty');
  	$_product = Mage::getModel('catalog/product')->load($id);
	$cart = Mage::getModel('checkout/cart');
	$cart->init();
	$cart->addProduct($_product, array('qty' => $qty));
	$cart->save();
	$item = Mage::getModel('wishlist/item')->load($wishid);
	$item->delete();
	Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
	$this->_redirect('checkout/cart');
  }
}
