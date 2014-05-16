<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
DROP TABLE IF EXISTS {$this->getTable('booster_settings')};
create table booster_settings(id int not null auto_increment, enable_compilation boolean, enable_cache boolean, merge_css_js_files boolean,enable_full_page_cache boolean,enable_log_cleaning boolean,enable_flat_data boolean,enable_htaccess boolean,cron_index_setting boolean,profile_run_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 
