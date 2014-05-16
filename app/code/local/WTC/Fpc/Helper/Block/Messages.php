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
 * Class WTC_Fpc_Helper_Block_Messages
 */
class WTC_Fpc_Helper_Block_Messages extends Mage_Core_Helper_Abstract
{
    /**
     * @param $layout
     * @return mixed
     */
    public function initLayoutMessages($layout)
    {
        $messagesStorage = array('catalog/session',
            'tag/session',
            'checkout/session');
        $block = $layout->getMessagesBlock();
        if ($block) {
            foreach ($messagesStorage as $storageName) {
                $storage = Mage::getSingleton($storageName);
                if ($storage) {
                    $block->addMessages($storage->getMessages(true));
                    $block->setEscapeMessageFlag($storage->getEscapeMessages(true));
                } else {
                    Mage::throwException(
                        Mage::helper('core')->__('Invalid messages storage "%s" for layout messages initialization', (string)$storageName)
                    );
                }
            }
        }
        return $layout;
    }

}
