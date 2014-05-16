<?php

class WTC_Booster_Model_Mysql4_Booster_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('booster/booster');
    }
}
