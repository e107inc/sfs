<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

// Prefs
define("LAN_SFS_PREFS_ACTIVE", 			"StopForumSpam Active");
define("LAN_SFS_PREFS_ACTIVE_HELP", 	"Either enables or disable StopForumSpam.");

define("LAN_SFS_PREFS_DEBUG", 			"SFS Debug Mode");
define("LAN_SFS_PREFS_DEBUG_HELP", 		"When enabled, log files are generated which can help debug issues. This also logs all user registrations, including legitimate registrations.");

define("LAN_SFS_PREFS_APIKEY", 			"API Key");
define("LAN_SFS_PREFS_APIKEY_HELP", 	"This key is used to connect to the stopforumspam.com database (optional)");


// Help
define("LAN_SFS_HELP_APIKEY", 	"When set, it is possible to report spam users to the stopforumspam.com database.");