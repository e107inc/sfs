<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT')) { exit; }

e107::lan('sfs', false, true);

require_once(e_PLUGIN."sfs/sfs_class.php");

class sfs_event 
{

	function config()
	{
		$event = array();

		// Use "usersup_veri" to catch spambots before data is entered into database
		$event[] = array(
			'name'		=> "usersup_veri", 
			'function'	=> "init_sfs",
		);

		return $event;
	}

	
	function init_sfs($data, $eventname) 
	{
		// Check to see if SFS is active
		if(e107::getPlugPref('sfs', 'sfs_enabled'))
	    {
			$sfs = new sfs_class();
			return $sfs->init($data, $eventname);
		}
	}

} 