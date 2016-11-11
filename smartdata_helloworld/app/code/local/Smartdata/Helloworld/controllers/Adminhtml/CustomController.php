<?php
class Smartdata_Helloworld_Adminhtml_CustomController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
    	//Example-1
    	/*
	    // "Fetch" display
	    $this->loadLayout();
	 
	    // "Inject" into display
	    // THe below example will not actualy show anything since the core/template is empty
	    $this->_addContent($this->getLayout()->createBlock('core/template'));
	 
	    // echo "Hello developer...";
	 
	    // "Output" display
	    $this->renderLayout();
		*/
	    //Example-2 
	    $this->loadLayout()
        ->_addContent(
        $this->getLayout()
        ->createBlock('smartdata_helloworld/adminhtml_adminblock')
        ->setTemplate('smartdata/helloworld.phtml'))
        ->renderLayout();
    }
}
?>