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
 * Class WTC_Fpc_Block_Catalog_Product_View_Ajax
 */
class WTC_Fpc_Block_Catalog_Product_View_Ajax extends Mage_Core_Block_Template
{
    /**
     * @return bool|string
     */
    public function getAjaxUrl()
    {
        $fpc = Mage::getSingleton('fpc/fpc');
        $id = $this->_getProductId();
        if ($fpc->isActive() &&
            in_array('catalog_product_view', Mage::helper('fpc')->getCacheableActions()) &&
            Mage::helper('fpc/block')->useRecentlyViewedProducts() &&
            $id
        ) {
            return $this->getUrl('fpc/catalog_product/view', array('id' => $id));
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function _getProductId()
    {
        $product = Mage::registry('current_product');
        if ($product) {
            return $product->getId();
        }
        return false;
    }

}
