<?php
/*
*************************************
e107 Inc. 
*/
if (!defined('e107_INIT')) { exit; }

// Plugin info  
$eplug_name    	= "Stop Forum Spam";
$eplug_version 	= "1.0";
$eplug_author  	= "e107 inc";
$eplug_url 		= "http://e107.org";
$eplug_email 	= "nospam@e107.org";

$eplug_description = "Based on the work of stopforumspam.com";
$eplug_compatible  = "e107 v0.7+";
$eplug_readme      = "";
$eplug_status = false;

// Name of the plugin's folder
$eplug_folder = "sfs";

// Name of menu item for plugin  
$eplug_menu_name	= "";

// Name of the admin configuration file  
$eplug_conffile = "admin_config.php";

// Icon image and caption text
$eplug_icon = $eplug_folder."/images/icon_32.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
$eplug_logo = $eplug_folder."/images/icon_32.png";
$eplug_caption = "Stop Forum Spam";

$eplug_prefs = array('sfs_enabled'=>1);
// Create a link in main menu (yes=TRUE, no=FALSE) 
$eplug_link 		= false;
$eplug_link_url		= "";
$eplug_link_name    = "";

// Text to display after plugin successfully installed 
$eplug_done           = "Installation Successful..";
$eplug_uninstall_done = "Uninstalled Successfully..";

// List of sql requests to create tables 
$eplug_tables = array(); 


?>