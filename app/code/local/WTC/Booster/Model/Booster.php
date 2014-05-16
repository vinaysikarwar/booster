<?php

class WTC_Booster_Model_Booster extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('booster/booster');
    }
}
