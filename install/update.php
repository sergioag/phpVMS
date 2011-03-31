<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */
 
error_reporting(E_ALL);
 
define('ADMIN_PANEL', true);

include '../core/codon.config.php';
include dirname(__FILE__).'/Installer.class.php';
include SITE_ROOT.'/core/lib/mysqldiff/MySQLDiff.class.php';
 
# phpVMS Updater 
$revision = file_get_contents(dirname(dirname(__FILE__)).'/core/version');

preg_match('/^[v]?(.*)-([0-9]*)-(.*)/', $revision, $matches);
list($FULL_VERSION_STRING, $full_version, $revision_count, $hash) = $matches;

preg_match('/([0-9]*)\.([0-9]*)\.([0-9]*)/', $full_version, $matches);
list($full, $major, $minor, $revision) = $matches;

define('MAJOR_VERSION', $major.'.'.$minor);
define('INSTALLER_FULL_VERSION', $FULL_VERSION_STRING);
define('INSTALLER_VERSION', $full_version);
define('UPDATE_VERSION', $full_version);
define('REVISION', $revision);

$CURRENT_VERSION = SettingsData::getSetting('PHPVMS_VERSION');
if(!$CURRENT_VERSION) {
	$_GET['force'] = true;
} else {
    
	$CURRENT_VERSION = $CURRENT_VERSION->value;
    
    if(substr_count($CURRENT_VERSION, '-')) {
        preg_match('/^[v]?(.*)-([0-9]*)-(.*)/', $revision, $matches);
        list($CURR_FULL_VERSION_STRING, $curr_full_version, $curr_revision_count, $curr_hash) = $matches;
        
        preg_match('/([0-9]*)\.([0-9]*)\.([0-9]*)/', $full_version, $matches);
        list($CURR_FULL_VERSION, $curr_major, $curr_minor, $curr_revision) = $matches;
        
        $CURRENT_VERSION = $curr_major.'.'.$curr_minor.'.'.$curr_revision;
    }
}

$CURRENT_VERSION = str_replace('.', '', $CURRENT_VERSION);

Template::SetTemplatePath(SITE_ROOT.'/install/templates');
Template::Show('header.tpl');

# Ew
echo '<h3 align="left">phpVMS Updater</h3>';

# Check versions for mismatch, unless ?force is passed
if(!isset($_GET['force']) && !isset($_GET['test'])) {
	if($CURRENT_VERSION == UPDATE_VERSION) {
		echo '<p>You already have updated! Please delete this /install folder.<br /><br />
				To force the update to run again, click: <a href="update.php?force">update.php?force</a></p>';
		
		Template::Show('footer.tpl');
		exit;
	}
}

/** 
 * Run a sql file
 */
// Do the queries:
echo 'Starting the update...<br />';

	# Do updates based on version
	#	But cascade the updates

	$CURRENT_VERSION = intval(str_replace('.', '', $CURRENT_VERSION));
	$latestversion = intval(str_replace('.', '', UPDATE_VERSION));
	    
    $mysqlDiff = new MySQLDiff(array(
        'dbuser' => DBASE_USER,
        'dbpass' => DBASE_PASS,
        'dbname' => DBASE_NAME,
        'dbhost' => DBASE_SERVER,
        'dumpxml' => 'sql/structure.xml',
        )
    );
    
    $diffs_done = $mysqlDiff->getSQLDiffs();
    if(!is_array($diffs_done)) {
        $diffs_done = array();
    }
    
    # Run it local so it's logged
    foreach($diffs_done as $sql) {
        DB::query($sql);
    }
	
	OperationsData::updateAircraftRankLevels();
	
	/* Add them to the default group */
	$allpilots = PilotData::getAllPilots();
	foreach($allpilots as $pilot) {
		PilotGroups::addUsertoGroup($pilot->pilotid, DEFAULT_GROUP);
	}

	SettingsData::saveSetting('PHPVMS_VERSION', $FULL_VERSION_STRING);

echo '<p><strong>Update completed!</strong></p>
		<hr>
	  <p >If there were any errors, you may have to manually run the SQL update, 
		or correct the errors, and click the following to re-run the update: <br />
		<a href="update.php?force">Click here to force the update to run again</a></p>
	  <p>Click here to <a href="'.SITE_URL.'">goto your site</a>, or <a href="'.SITE_URL.'/admin">your admin panel</a></p>  ';

# Don't count forced updates
if(!isset($_GET['force'])) {
	Installer::RegisterInstall($FULL_VERSION_STRING);
}

Template::Show('footer.tpl');