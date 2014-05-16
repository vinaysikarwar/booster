<?php

require_once 'abstract.php';

class Booster_Shell_Snapshot extends Mage_Shell_Abstract
{

    /**
     * Perform snapshot
     */
    function _snapshot()
    {
        # Check to make sure Magento is installed
        if (!Mage::isInstalled()) {
            echo "Application is not installed yet, please complete install wizard first.";
            exit;
        }
        
        # Initialize configuration values
        $connection = Mage::getConfig()->getNode('global/resources/default_setup/connection');
        $rootpath = $this->_getRootPath();
        $snapshot = $rootpath.'snapshot';

        # Create the snapshot directory if not exists
        $io = new Varien_Io_File();
        $io->mkdir($snapshot);

        # Create the media archive
        exec("tar -chz -C \"$rootpath\" -f \"{$snapshot}/media.tgz\" media");

        # Dump the database
        exec("mysqldump -h {$connection->host} -u {$connection->username} --password={$connection->password} {$connection->dbname} | gzip > \"{$snapshot}/{$connection->dbname}.sql.gz\"");
    }

    /**
     * Run script
     */
    public function run()
    {
        if ($this->getArg('snapshot')) {
            $this->_snapshot();
        } else {
            echo $this->usageHelp();
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        global $argv;
        $self = basename($argv[0]);
        return <<<USAGE

Snapshot

Saves a tarball of the media directory and a gzipped database dump
taken with mysqldump

Usage:  php -f $self -- [options]

Options:

  help              This help
  snapshot          Take snapshot
  
USAGE;
    }
}

if (basename($argv[0]) == basename(__FILE__)) {
    $shell = new Booster_Shell_Snapshot();
    $shell->run();
}
