<?php
class Smartdata_Helloworld_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction() {
		try {
        	$productFieldName   = sprintf('e.%s', '3');
        	$orderItemTableName = Mage::getSingleton('core/resource')->getTableName('sales/order_item');

			$Products = Mage::getResourceModel('reports/product_collection');
             	//-> AddAttributeToSelect('name')
             	//-> AddOrderedQty()
             	//-> AddAttributeToSort('ordered_qty', 'desc')
             	//-> SetPageSize(5);
            //$Products->addOrdersCount();
            $Products->getSelect()
            ->joinLeft(
                array('order_items' => $orderItemTableName),
                "order_items.product_id = {$productFieldName}",
                array())
            ->columns(array('orders' => 'COUNT(order_items2.item_id)'))
            ->group($productFieldName);
            print_r($Products->getData());die;
		} catch (Exception $ex) {
			echo $ex->getMessage();die;
		}
	}

    public function indexOldAction()
    {
        //Set From & To Limit Of Price
	if(isset($_GET['from']) && isset($_GET['to'])) {
		$file = 'Products.csv';
		$csv = new Varien_File_Csv();
		$csv = '';
		$_columns = array(
			"SKU",
			"IMAGE1",
			"IMAGE2",
			"IMAGE3",
			"IMAGE4",
			"IMAGE5"
		);
		$data = array();
		// prepare CSV header…
		foreach ($_columns as $column) {
			$data[] = '"'.$column.'"';
		}
		$csv .= implode(',', $data)."\n";
		//Create Product Collection
		$_collection = Mage::getModel('catalog/product')->getCollection()
				->addAttributeToSelect('sku','entity_id')
				->addFieldToFilter('entity_id',array(array('from'=>$_GET['from'],'to'=>$_GET['to'])));
				//->addFinalPrice()
				//->addFieldToFilter('price',array(array('from'=>$_GET['from'],'to'=>$_GET['to'])));//Filter With Price
		$backendModel = $_collection->getResource()->getAttribute('media_gallery')->getBackend();
		if($_collection->count()>0) {
			foreach($_collection as $product) {
				$backendModel->afterLoad($product);
				$_images = $product->getMediaGalleryImages();
				$data = array();
				$data[] = $product->getSku();
				if($_images){ // If Product have Images
					foreach ($_images as $image) {
						print_r($image->getData());die;
						$data[] = $image->getUrl();//File, Path, URL
					}
				}
				$csv .= implode(',',$data)."\n";
			}
		$this->_prepareDownloadResponse('Products_'.$_GET['from'].'_'.$_GET['to'].'.csv', $csv, 'text/csv');
		} else {
			echo 'No Product Collection In This Range.';
		}
	}
    }
}
?>