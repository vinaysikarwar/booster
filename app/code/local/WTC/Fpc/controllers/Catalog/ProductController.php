<?php
/**
 * Full Page Cache
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package      WTC_Fpc
 * @copyright    Copyright (c) 2014 vinay sikarwar
 * @author       Vinay Sikarwar 
 * @license      http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

/**
 * Class WTC_Fpc_Catalog_ProductController
 */
class WTC_Fpc_Catalog_ProductController extends Mage_Core_Controller_Front_Action
{

    /**
     *
     */
    public function viewAction()
    {
        $productId = (int)Mage::app()->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($productId);
        if ($product->getId()) {
            Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));
        }
    }

}
