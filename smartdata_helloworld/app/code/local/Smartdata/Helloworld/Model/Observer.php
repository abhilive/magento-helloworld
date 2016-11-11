<?php
/**
 * Smartdata Helloworld Model
 *
 * @category   Smartdata
 * @package    Smartdata_Helloworld
 * @author     Abhishek Srivastava <abhishek.srivastava@smartdatainc.net>
 */

class Smartdata_Helloworld_Model_Observer {
	/*Overwrite Customer Address Edit Form*/
	public function overwriteAddressForm(Varien_Event_Observer $observer) {
    	$block = $observer->getEvent()->getBlock();
    	if ($block instanceof Mage_Customer_Block_Address_Edit) {
    		$block->setTemplate('helloworld/customer/address/edit.phtml');
    	}
	}
}
?>