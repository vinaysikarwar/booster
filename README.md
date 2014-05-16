/**
 * @package   WTC_Booster,WTC_Fpc
 * @author    Vinay Sikarwar
 * Extension Name:    WTC_Booster,WTC_Fpc
 * Description:    This extension shows all settings to one place which are used to increase the performance of the website. 
 This extension will increase the performance of the website.By using these extension magento websites will load faster.
 * Version:    1.0.1
 * Author Email id : svinay.1987@gmail.com
 * URI : www.webtechnologycodes.com
 */

 How to Install
 --------------
 Extract the booster.zip file in a directory.After extracting you will see their are 2 directories app and shell. Copy both the directories and paste it to the magento root directory, where your magento is installed. 
 
 After placing the directories,login to the admin panel their you will see a top menu named as booster.
 
 Unable to view the top menu booster?
 
 Okey fine clear the cache and do logout and login again. 
 
 Now you will see a top menu named as Booster.
 
 Go to Booster->Magento Booster.
 
 Here you will see the settings after enabling the settings you will see that you website is now really loading fast.The performance is increased as compared to the previous one.
 
 Features
 --------
 Save at Once & Save one by One: Settings can be saved one by one and also at once, if you have selected the Save all settings at once then on selecting each setting your configuration will not be saved via Ajax.
 If you have not selected the Save all setting at Once, then when ever you change the option your configuration will be saved.
 
 How to Use
 ----------
 This extension includes the following settings
	1. Backup the Database
	2. Enable the Compilation
	3. Enable Cache
	4. Merge Js and Css Files
	5. Enabling Full PAge Cache Extension
	6. Clean Log Data From the Database
	7. Enable Flat Data for Product and Category
	8. Enable Htaccess Gzip, Mod_deflate, Performance Settings 
	9. Enable Reindexing as a Cron Job
	10. Fast Reindex Data
	11. Clear Cache 
	
	1. Backup the Database : 
   When you want to backup the database, then it is required to please first disabled the cache, then select the option for backing up the database.
   
	2. Enable the Compilation
      Compilation helps the code to render from the Single Directory, By enabling the compilation your code can be picked up from the single directory.
	
	3. Enable Cache : By selecting this option you cache will be enabled.
	
	4. Merge Js and Css Files : If you have enabled this option then your css and js files will be merged into one.

	5. Enabling Full PAge Cache Extension : 
	Magento does not provide the full page caching , so I have created the extension which will include the cms page caching, cms block caching and others.
   
   You can find the Setting for this module
   
   System->COnfiguration->System->WTC FPC
   -------------------------------------------
   
	6. Clean Log Data From the Database: 
	   If you are selecting the yes for Cleaning the log data.Then please go to
   
       System->Configuration->System->Log Cleaning
       -------------------------------------------
       you can change the settings over here.
	
	7. Enable Flat Data for Product and Category :  If this setting is enabled then your product and category data will be come from a single table, if it is not enabled then your category and product data is fetched from the multiple directories.
	
	8. Enable Htaccess Gzip, Mod_deflate, Performance Settings 
	   When you enable the htaccess setting then if there is already htaccess file then some settings will be saved in the file for enabling some php modules.If there is not any htaccess file then please make sure to paste the htaccess.sample file in the root, which you will find in module zip file.Module will use this sample file to generate the htaccess file.
	   
	   This setting will compress your html code in the frontend.
	   
	9. Enable Reindexing as a Cron Job: If your database is required index all the time then you can enable the reindex the data as a cron job. This problem mostly occurs when you have large database. 
	
	10. Fast Reindex Data: If you are having a large database, then if you will reindex your data from the default by going to system->index management then it will take too long time to process and may be possible it will not succeeded.

   So for this I have provided you a setting the reindex the data, by changing this setting your data will be reindex fast as compared to the original reindexing feature.
   
    11. Clear Cache:  When you have enabled all the settings then for the first time it is required to clear the magento Cache.
   
   
   Thanks For using this Extension.For more info you can contact me at vinay.sikarwar@osscube.com
	
 
 
 
 

 
