<?php  

class WTC_Booster_Block_Adminhtml_Boosterpanel extends Mage_Adminhtml_Block_Template
{
	
	public function getBoosterActionUrl()
	{
		return  Mage::getBaseUrl().'booster/adminhtml_boosterpanel/boost';
	}
	
}
