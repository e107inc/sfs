<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 content management system - Stop Forum Spam plugin. 
|
|     Copyright (C) 2008-2013 e107 Inc (e107.org)
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }


$eplug_name    		= "Stop Forum Spam";
$eplug_version 		= "1.0";
$eplug_author  		= "e107 inc";
$eplug_url 			= "https://github.com/e107inc/sfs";
$eplug_email 		= "nospam@e107.org";

$eplug_description 	= "Based on the excellent work of stopforumspam.com";
$eplug_compatible  	= "e107 v0.7+";
$eplug_readme      	= $eplug_folder."README.md";
$eplug_status 		= false;
$eplug_folder 		= "sfs";
$eplug_menu_name	= "";
$eplug_conffile 	= "admin_config.php";
$eplug_icon 		= $eplug_folder."/images/icon_32.png";
$eplug_icon_small 	= $eplug_folder."/images/icon_16.png";
$eplug_logo 		= $eplug_folder."/images/icon_32.png";
$eplug_caption 		= "Stop Forum Spam";

$eplug_prefs 		= array('sfs_enabled'=>1);
$eplug_link 		= false;
$eplug_link_url		= "";
$eplug_link_name    = "";

$eplug_done           = "Installation Successful..";
$eplug_uninstall_done = "Uninstalled Successfully..";

$eplug_tables = array(); 


?>