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
 * Class WTC_Fpc_Core_Block_Messages
 */
class WTC_Fpc_Core_Block_Messages extends Mage_Core_Block_Messages
{
    /**
     * Retrieve messages in HTML format grouped by type
     *
     * @param   string $type
     * @return  string
     */
    public function getGroupedHtml()
    {
        $html = parent::getGroupedHtml();

        /**
         * Use single transport object instance for all blocks
         */

        $_transportObject = new Varien_Object;
        $_transportObject->setHtml($html);
        Mage::dispatchEvent('core_block_messages_get_grouped_html_after',
            array('block' => $this, 'transport' => $_transportObject));
        $html = $_transportObject->getHtml();

        return $html;
    }
}
