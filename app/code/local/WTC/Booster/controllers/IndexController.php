<?php
class WTC_Booster_IndexController extends Mage_Adminhtml_Controller_Action
{	
		
	public function getData()
	{
		$model = Mage::getModel('booster/booster');
		return $model;
	}
	protected function _getCompiler()
    {
        if ($this->_compiler === null) {
            $this->_compiler = Mage::getModel('compiler/process');
        }
        return $this->_compiler;
    }
	
	public function enableCompilationAction()
	{
		echo 'xzczxczxc';
		die;
		$this->_getCompiler()->run();
		Mage::getSingleton('adminhtml/session')->addSuccess
		(
            Mage::helper('compiler')->__('The compilation has been enabled.')
        );
	}
	
	public function disableCompilation()
	{
		$this->_getCompiler()->registerIncludePath(false);
		Mage::getSingleton('adminhtml/session')->addSuccess
		(
            Mage::helper('compiler')->__('The compilation has been disabled.')
        );
		return;
	}
	
	public function enableCache()
	{
		$model = Mage::getModel('core/cache');
		$options = $model->canUse();
		foreach($options as $option=>$value) 
		{
			$options[$option] = 1;
		}
		$model->saveOptions($options);
	}
	
	public function disableCache()
	{
		$model = Mage::getModel('core/cache');
		$options = $model->canUse();
		foreach($options as $option=>$value) 
		{
			$options[$option] = 0;
		}
		$model->saveOptions($options);
	}
	public function getConfig()
	{
		$config = new Mage_Core_Model_Config();
		return $config;
	}
	
	public function enableMerging()
	{
		$config = $this->getConfig();
		$config ->saveConfig('dev/js/merge_files', "1", 'default', 0);
		$config ->saveConfig('dev/css/merge_css_files', "1", 'default', 0);
	}
	
	public function disableMerging()
	{
		$config = $this->getConfig();
		$config ->saveConfig('dev/js/merge_files', "0", 'default', 0);
		$config ->saveConfig('dev/css/merge_css_files', "0", 'default', 0);
	}
	
	public function cleanLog()
	{	
		$config = $this->getConfig();
		$config ->saveConfig('system/log/clean_after_day', "1", 'default', 0);
		$config ->saveConfig('system/log/enabled', "1", 'default', 0);
		$config ->saveConfig('system/log/frequency', "D", 'default', 0);
		$log = Mage::getModel('log/log');
		$log->clean();
	}
	
	public function disableLogcleanup()
	{
		$config = $this->getConfig();
		$config ->saveConfig('system/log/enabled', "0", 'default', 0);
	}
	
	public function increaseMemoryLimit()
	{
		$fileLocation = getenv("DOCUMENT_ROOT") . "mywork/php.ini";
		$file = fopen($fileLocation,"w");
		$content = "extension=pdo.so\n extension=pdo_sqlite.so \n extension=sqlite.so \n extension=pdo_mysql.so \n memory_limit: 512M";
		fwrite($file,$content);
		fclose($file);
	}
	
	public function enableFlatData()
	{
		$config = $this->getConfig();
		$config ->saveConfig('catalog/frontend/flat_catalog_category', "1", 'default', 0);
		$config ->saveConfig('catalog/frontend/flat_catalog_product', "1", 'default', 0);
	}
	
	public function disableFlatData()
	{
		$config = $this->getConfig();
		$config ->saveConfig('catalog/frontend/flat_catalog_category', "0", 'default', 0);
		$config ->saveConfig('catalog/frontend/flat_catalog_product', "0", 'default', 0);
	}
	
	public function enableHtaccess()
	{
		$root = getcwd();
		rename($root."/.htaccess.sample", $root."/.htaccess");
	}
	
	public function disableHtaccess()
	{
		$root = getcwd();
		rename($root."/.htaccess", $root.".htaccess.sample");
	}
}
