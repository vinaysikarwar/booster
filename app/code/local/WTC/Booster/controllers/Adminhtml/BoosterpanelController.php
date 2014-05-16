<?php
class WTC_Booster_Adminhtml_BoosterpanelController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Magento Booster"));
	   $this->renderLayout();
    }
	
	public function boostAction()
	{
		$enable_compilation = $_POST['enable_compilation'];
		$enable_cache = $_POST['enable_cache'];
		$merge_css_js_files = $_POST['merge_css_js_files'];
		$enable_full_page_cache = $_POST['enable_full_page_cache'];
		$enable_log_cleaning = $_POST['enable_log_cleaning'];
		$enable_flat_data = $_POST['enable_flat_data'];
		$enable_htaccess = $_POST['enable_htaccess'];
		$cron_index_setting = $_POST['cron_index_setting'];
		$database_backup = $_POST['database_backup'];
		$current_time = $this->getCurrentTime();
		$data = $this->loadData();
		//save booster settings
		if(!$data)
		{
			$this->saveData($data);
		}
		
		//create a database backup
		if($database_backup)
		{
			$this->databaseBackup();
		}
		if(function_exists('exec'))
		{
			//flushed the magento cache
			$this->clearCache();
			// reindex the magento data
			$this->reindexData();
           	}
		else
		{
			$this->reindexAllData();
		}
		
		
		if($enable_compilation && $data->getEnableCompilation() != $enable_compilation)
		{
			
			$this->enableCompilation();
		}
		elseif(!$enable_compilation && $data->getEnableCompilation() != $enable_compilation)
		{
			
			$this->disableCompilation();
		}
		if($data->getEnableCache() != $enable_cache)
		{
			$this->enableCache($enable_cache);
		}
		
		if($data->getMergeCssJsFiles() != $merge_css_js_files)
		{
			$this->enableMerging($merge_css_js_files);
		}
		
		if($enable_log_cleaning && $data->getEnableLogCleaning() != $enable_log_cleaning)
		{
			$this->cleanLog();
		}
		elseif(!$enable_log_cleaning && $data->getEnableLogCleaning() != $enable_log_cleaning)
		{
			$this->disableLogcleanup();
		}
		
		
		if($data->getEnableFlatData() != $enable_flat_data)
		{
			$this->enableFlatData($enable_flat_data);
		}
		
		if($enable_htaccess && $data->getEnableHtaccess() != $enable_htaccess)
		{
			$this->enableHtaccess($enable_htaccess);
		}		
		
		Mage::getSingleton('adminhtml/session')->addSuccess
		(
            Mage::helper('booster')->__('Your Configuration has been Saved')
        );
		if($data)
		{
			$this->saveData($data);
		}
		
		$this->_redirect('*/*/');
		
	}
	
	public function saveData($data)
	{
		$enable_compilation = $_POST['enable_compilation'];
		$enable_cache = $_POST['enable_cache'];
		$merge_css_js_files = $_POST['merge_css_js_files'];
		$enable_full_page_cache = $_POST['enable_full_page_cache'];
		$enable_log_cleaning = $_POST['enable_log_cleaning'];
		$enable_flat_data = $_POST['enable_flat_data'];
		$enable_htaccess = $_POST['enable_htaccess'];
		$cron_index_setting = $_POST['cron_index_setting'];
		$current_time = $this->getCurrentTime();
		
		$data->setEnableCompilation($enable_compilation);
		$data->setEnableCache($enable_cache);
		$data->setMergeCssJsFiles($merge_css_js_files);
		$data->setEnableFullPageCache($enable_full_page_cache);
		$data->setEnableLogCleaning($enable_log_cleaning);
		$data->setEnableFlatData($enable_flat_data);
		$data->setEnableHtaccess($enable_htaccess);
		$data->setCronIndexSetting($cron_index_setting);
		$data->setProfileRunAt($current_time);
		$data->save();
	}
	
	
	public function getData()
	{
		$model = Mage::getModel('booster/booster');
		return $model;
	}
	
	public function loadData()
	{
		$data = $this->getData();
		$model = $data->load(1);
		if($model)
		{	
			$data = $model;
		}
		return $data;
	}
	
	public function getCurrentTime()
	{
		$current_time = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		return $current_time;
	}
	
	protected function _getCompiler()
    {
        if ($this->_compiler === null) {
            $this->_compiler = Mage::getModel('compiler/process');
        }
        return $this->_compiler;
    }
	
	public function enableCompilation()
	{
		$this->_getCompiler()->run();
	}
	
	public function disableCompilation()
	{
		$this->_getCompiler()->registerIncludePath(false);
		return;
	}
	
	public function enableCache($val)
	{
		$model = Mage::getModel('core/cache');
		$options = $model->canUse();
		$data = $this->loadData();
		if($value != $data->getEnableCache())
		{
			foreach($options as $option=>$value) 
			{
				$options[$option] = $val;
			}
			$model->saveOptions($options);
		}
	}
	
	public function getConfig()
	{
		$config = new Mage_Core_Model_Config();
		return $config;
	}
	
	public function enableMerging($value)
	{
		$config = $this->getConfig();
		$data = $this->loadData();
		if($value != $data->getMergeCssJsFiles())
		{
			$config ->saveConfig('dev/js/merge_files', $value, 'default', 0);
			$config ->saveConfig('dev/css/merge_css_files', $value, 'default', 0);
		}
	}
	
	public function enableFullPageCache($value)
	{
		$file = "app/etc/modules/OSSCube_Fpc.xml";
		$data = $this->loadData();
		$xml = simplexml_load_file($file);
		if($value)
		{
			$active = 'true';
			$this->enableFpcCache();
		}
		else
		{
			$active = 'false';
		}
		if($value != $data->getEnableFullPageCache())
		{
			$xml->modules->OSSCube_Fpc->active = $active;
		}
		$xml->asXML($file);
	}
	
	public function enableFpcCache()
	{
		$out = shell_exec("php shell/cache.php --enable fpc"); 
	}
	
	public function cleanLog()
	{	
		$config = $this->getConfig();
		$config ->saveConfig('system/log/clean_after_day', "1", 'default', 0);
		$config ->saveConfig('system/log/enabled', "1", 'default', 0);
		$config ->saveConfig('system/log/frequency', "D", 'default', 0);
	}
	
	public function disableLogcleanup()
	{
		$config = $this->getConfig();
		$config ->saveConfig('system/log/enabled', "0", 'default', 0);
	}
	
	public function htaccessContent()
	{
		$content = "##Code added by booster module\n ";
		$content .= "<IfModule mod_php5.c>\n ";
		$content .= "############################################ \n ";
		$content .= "## adjust memory limit \n ";
		$content .= "php_value memory_limit 256M \n ";
		$content .= "php_value max_execution_time 18000 \n ";
		$content .= "############################################ \n ";
		$content .= "## disable magic quotes for php request vars \n ";
		$content .= "php_flag magic_quotes_gpc off \n ";
		$content .= "############################################ \n ";
		$content .= "## disable automatic session start \n ";
		$content .= "## before autoload was initialized \n ";
		$content .= "php_flag session.auto_start off \n ";
		$content .= "############################################ \n ";
		$content .= "## enable resulting html compression \n ";
		$content .= "#php_flag zlib.output_compression on \n ";
		$content .= "########################################### \n ";
		$content .= "# disable user agent verification to not break multiple image upload \n ";
		$content .= "php_flag suhosin.session.cryptua off \n ";
		$content .= "########################################### \n ";
		$content .= "# turn off compatibility with PHP4 when dealing with objects \n ";
		$content .= "php_flag zend.ze1_compatibility_mode Off \n ";
		$content .= "</IfModule> \n ";
		$content .= " \n ";
		$content .= "<IfModule mod_deflate.c> \n ";
		$content .= "############################################ \n ";
		$content .= "## enable apache served files compression \n ";
		$content .= "## http://developer.yahoo.com/performance/rules.html#gzip \n ";
		$content .= "# Insert filter on all content \n ";
		$content .= "###SetOutputFilter DEFLATE \n ";
		$content .= "# Insert filter on selected content types only \n ";
		$content .= "AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript \n ";
		$content .= "# Netscape 4.x has some problems... \n ";
		$content .= "BrowserMatch ^Mozilla/4 gzip-only-text/html \n ";
		$content .= "# Netscape 4.06-4.08 have some more problems \n";
		$content .= "BrowserMatch ^Mozilla/4\.0[678] no-gzip \n";
		$content .= "# MSIE masquerades as Netscape, but it is fine \n ";
		$content .= "BrowserMatch \bMSIE !no-gzip !gzip-only-text/html \n";
		$content .= "# Don't compress images \n ";
		$content .= "SetEnvIfNoCase Request_URI \.(?:gif|jpe?g|png)$ no-gzip dont-vary \n";
		$content .= "# Make sure proxies don't deliver the wrong content \n ";
		$content .= "#Header append Vary User-Agent env=!dont-vary\n ";
		$content .= "</IfModule> \n ";
		$content .= "##Code added by booster module \n ";
		return $content;
	}
	
	public function createHtaccess()
	{
		$root = getcwd();
		$fileLocation = $root. "/.htaccess";
		if (file_exists($fileLocation)) 
		{
			$file = fopen($fileLocation,"a");
		}
		else
		{
			rename($root."/.htaccess.sample", $root."/.htaccess");			
			$file = fopen($fileLocation,"a");
		}
		return $file;
	}
	
	//append data in htaccess file
	public function enableHtaccess($value)
	{
		$data =  $this->loadData();
		$file = $this->createHtaccess();
		$content = $this->htaccessContent();
		if($value && $value != $data->getEnableHtaccess())
		{
			fwrite($file, $content);
		}
		
		fclose($f);
	}
	
	//enabling flat data setting for product and category
	public function enableFlatData($value)
	{
		$config = $this->getConfig();
		$data = $this->loadData();
		if($value != $data->getEnableFlatData())
		{
			$config ->saveConfig('catalog/frontend/flat_catalog_category', $value, 'default', 0);
			$config ->saveConfig('catalog/frontend/flat_catalog_product', $value, 'default', 0);
		}
	}
	
	
	public function enableCompilationAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value && $value != $data->getEnableCompilation())
		{
			$this->enableCompilation($value);	
		}
		if(!$value && $value != $data->getEnableCompilation())
		{
			$this->disableCompilation($value);	
		}
		if($value != $data->getEnableCompilation())
		{
			$data->setEnableCompilation($value);
			$data->save();
		}
		echo $this->__('Compilation settings have been updated.');
	}
	
	public function enableCacheAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value != $data->getEnableCache())
		{
			$this->enableCache($value);	
		}
		
		if($value != $data->getEnableCache())
		{
			$data->setEnableCache($value);
			$data->save();
		}
		echo $this->__('Cache  settings have been updated.');
	}
	
	public function mergeCssJsFilesAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value != $data->getMergeCssJsFiles())
		{
			$this->enableMerging($value);	
		}
		
		if($value != $data->getMergeCssJsFiles())
		{
			$data->setMergeCssJsFiles($value);
			$data->save();
		}
		echo $this->__('js and css files merging settings have been updated.');
	}
	
	public function enableFullPageCacheAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value != $data->getEnableFullPageCache())
		{
			$this->enableFullPageCache($value);
		}
		
		if($value != $data->getEnableFullPageCache())
		{
			$data->setEnableFullPageCache($value);
			$data->save();
		}
		echo $this->__('Full page cache extension setting has been updated.');
	}
	
	public function enableLogCleaningAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value && $value != $data->getEnableLogCleaning())
		{
			$this->cleanLog();	
		}
		elseif(!$value && $value != $data->getEnableLogCleaning())
		{
			$this->disableLogcleanup();
		}
		if($value != $data->getEnableLogCleaning())
		{
			$data->setEnableLogCleaning($value);
			$data->save();
		}
		echo $this->__('Log Settings have been updated.');
	}
	
	public function enableFlatDataAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value != $data->getEnableFlatData())
		{
			$this->enableFlatData($value);	
		}
		
		if($value != $data->getEnableFlatData())
		{
			$data->setEnableFlatData($value);
			$data->save();
		}
		echo $this->__('Flat data has been enabled for Category and products.');
	}
	
	public function enableHtaccessAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if($value != $data->getEnableHtaccess() && !($data->getEnableHtaccess()))
		{
			$this->enableHtaccess();
			$data->setEnableHtaccess($value);
			$data->save();			
		}
		
		echo $this->__('Htaccess settings have been updated.');
	}
	
	public function cronIndexSettingAction()
	{
		$data = $this->loadData();
		$value = $_POST['option'];
		if(value != $data->getEnableCompilation())
		{
			$data->setCronIndexSetting($value);
			$data->save();
		}
		echo $this->__('Cron Settings have been updated');
	}
	
	public function reindexData($indexer_code)
	{	
		$out = shell_exec("php shell/indexer.php --reindex $indexer_code"); 	
		return $out;
	}
	
	public function reindexDataAction()
	{
		$value = $_POST['option'];
		$indexer = Mage::getSingleton('index/indexer')->getProcessesCollection();
		foreach($indexer as $index)
		{
			$require = $index['status'];
			if($require == 'require_reindex')
			{
				$indexer_code = $index->getIndexerCode().',';	
			}
			
		}
		if($indexer_code)
		{
			$indexer_code = rtrim($indexer_code, ",");
		}
		if($value && $indexer_code && function_exists('exec'))
		{
			$out = $this->reindexData($indexer_code);
			echo $this->__($out);
		}
		elseif($value && !function_exists('exec'))
		{
			$this->reindexAllData();

		}
		elseif($value)
		{
			echo $this->__('Indexes are already updated.');
		}
	}
	
	public function reindexAllData()
	{
		$processCollection = Mage::getSingleton('index/indexer')->getProcessesCollection();
		foreach($processCollection as $process)
		{
			$process->reindexAll();
		}
	}

	public function clearCache()
	{
		if(function_exists('exec'))
		{	
			$out = shell_exec("php -f shell/cache.php -- --flush magento"); 		
			echo $out;
		}
	}
	
	public function clearCacheAction()
	{
		
		$value = $_POST['option'];
		if($value)
		{
			$this->clearCache();
		}
	}
	
	public function databaseBackup()
	{
		if(function_exists('exec'))
		{
			$out = shell_exec("php -f shell/snapshot.php -- --snapshot"); 
		}
		else
		{
			$out = 'Please Enable Shell access to take the database Backup';
		}
		return $out;
	}
	
	public function databaseBackupAction()
	{
		$value = $_POST['option'];
		$data = $this->loadData();
		if($value && $value != $data->getEnableCache())
		{
			$this->databaseBackup();
			echo 'Database and media files are backed up, please check files in the root of snapshot directory.';
		}
	}
}
