<?php

class WTC_Booster_Model_Observer 
{
	protected function getProcesses()
	{
		return Mage::getSingleton('index/indexer')->getProcessesCollection();
	}
	
	public function doRefreshIndexes() 
	{
		$data = Mage::getModel('booster/booster')->load(1);
		$CronIndexSetting = $data->getCronIndexSetting();
		if($CronIndexSetting)
		{
			$_processes = $this->getProcesses();
			foreach( $_processes as $_process )
			{
				$_process->reindexEverything();
			}
		}
	}
}
