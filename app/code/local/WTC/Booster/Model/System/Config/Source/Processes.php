<?php

class WTC_Booster_Model_System_Config_Source_Processes {

	protected function getProcesses()
	{
		return Mage::getModel('index/indexer')->getProcessesCollection();
	}

	public function toArray() {
		$dict = array();
		foreach( $this->getProcesses() as $_process ) {
			$dict[$_process->getProcessId()] = $_process->getIndexer()->getName();
		}

		return $dict;
	}

	public function toOptionArray() {
		$opt = array();
		foreach( $this->getProcesses() as $_process ) {
			$opt[] = array(
				'value' => $_process->getProcessId(),
				'label' => $_process->getIndexer()->getName()
			);
		}

		return $opt;
	}
}
