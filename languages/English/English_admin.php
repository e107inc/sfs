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

define("LAN_SFS_LIST_CHECK", 		"Check existing users");
define("LAN_SFS_LIST_CHECK_HELP", 	"To check exsting users against the stopforumspam.com database, click on the question mark (?) icon on the right hand side. You can also select multiple users by ticking the checkboxes and using the option at the bottom of the table.");
define("LAN_SFS_LIST_CHECK_WARNING", "Be careful with checking too many users in a short amount of time. You risk getting banned from using the stopforumspam.com database.");

define("LAN_SFS_CHECK_NOBOT", 	"User [x] is probably not a spambot.");
define("LAN_SFS_CHECK_BOT", 	"User [x] is probably a spambot.");

define("LAN_SFS_NOAPIKEY", 		"You need to enter your API Key (see preferences), in order to use this functionality!");

// Prefs
define("LAN_SFS_PREFS_ACTIVE",              "StopForumSpam Active");
define("LAN_SFS_PREFS_ACTIVE_HELP",         "If turned off, user registrations are NOT checked against the StopForumSpam database.");

define("LAN_SFS_PREFS_DENIEDMESSAGE",       "Custom denied message");
define("LAN_SFS_PREFS_DENIEDMESSAGE_HELP",  "The custom message that is shown when the user is found in the StopForumSpam database.");

define("LAN_SFS_PREFS_DEBUG",               "SFS Debug Mode");
define("LAN_SFS_PREFS_DEBUG_HELP",          "When enabled, log files are generated which can help debug issues. This also logs all user registrations, including legitimate registrations.");

define("LAN_SFS_PREFS_APIKEY",              "API Key");
define("LAN_SFS_PREFS_APIKEY_HELP",         "In order to report users to the stopforumspam.com database, you need to fill in the API Key that you were given.");

define("LAN_SFS_PREFS_MSFC",                "Min Spam Flags Count");
define("LAN_SFS_PREFS_MSFC_HELP",           "Minimum number of flags (ip, email, username) detected as spam to detect user as spammer. Default: 1");

define("LAN_SFS_PREFS_MFAF",                "Minimal Flag Appearance Frequency");
define("LAN_SFS_PREFS_MFAF_HELP",           "If flag (ip, email, username) appears in spam reports less than this value, user is NOT detected as spammer. Default: 5");

define("LAN_SFS_PREFS_FLSDA",               "Flag Last Seen Days ago");
define("LAN_SFS_PREFS_FLSDA_HELP",          "If flag (ip, email, username) was last time reported as spam more than this amount of days ago, user is NOT detected as spammer. Default: 7");

define("LAN_SFS_PREFS_CT",                  "Confidence Treshold");
define("LAN_SFS_PREFS_CT_HELP",             "If response confidence is equal or above this value, user is detected as spammer. Default: 90");

// Help
//define("LAN_SFS_HELP_APIKEY", 	"When set, it is possible to report spam users to the stopforumspam.com database.");