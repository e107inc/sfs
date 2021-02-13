<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

// Manage
define("LAN_SFS_MANAGE_JOINDATE",		"Join date");
define("LAN_SFS_MANAGE_CHECKUSERS",		"Check users against the SFS database");
define("LAN_SFS_MANAGE_REPORTUSERS",	"Report users to the SFS database");

// Prefs
define("LAN_SFS_PREFS_ACTIVE", 			"StopForumSpam Active");
define("LAN_SFS_PREFS_ACTIVE_HELP", 	"If turned off, user registrations are NOT checked against the StopForumSpam database.");

define("LAN_SFS_PREFS_DENIEDMESSAGE", 		"Custom denied message");
define("LAN_SFS_PREFS_DENIEDMESSAGE_HELP", 	"The custom message that is shown when the user is found in the StopForumSpam database.");

define("LAN_SFS_PREFS_DEBUG", 			"SFS Debug Mode");
define("LAN_SFS_PREFS_DEBUG_HELP", 		"When enabled, log files are generated which can help debug issues. This also logs all user registrations, including legitimate registrations.");

define("LAN_SFS_PREFS_APIKEY", 			"API Key");
define("LAN_SFS_PREFS_APIKEY_HELP", 	"In order to report users to the stopforumspam.com database, you need to fill in the API Key that you were given.");


// Help
//define("LAN_SFS_HELP_APIKEY", 	"When set, it is possible to report spam users to the stopforumspam.com database.");