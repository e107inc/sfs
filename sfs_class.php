<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

class sfs_class
{
	public $sfs_debug = false;

	public function __construct() 
	{
		// Check debug mode
		if(e107::getPlugPref('sfs', 'sfs_debug')) 
		{
			$this->sfs_debug = true;
		}
	}
	
	public function init($data, $eventname)
	{	
		// Check if SFS is active (just making sure)
		if(!e107::getPlugPref('sfs', 'sfs_enabled')) 
		{
			e107::getLog()->addDebug("SFS is not active!");
 	    	e107::getLog()->toFile('sfs', 'StopForumSpam Debug Information', true);
			return false; 
		}

		e107::getLog()->addDebug("Initialising SFS check");
 	    e107::getLog()->toFile('sfs', 'StopForumSpam Debug Information', true);

		if($eventname == "usersup_veri")
		{
			e107::getLog()->addDebug("Initialising Signup Check");
			
			$result = $this->sfsCheck($data); 
			
			e107::getLog()->addDebug("Result: ".$result);
			e107::getLog()->toFile('sfs', 'StopForumSpam Debug Information', true);
			
			return $result;
		}
	}

	function sfsCheck($val = array())
	{
		$xml = e107::getXml(); 

		$user_ip 	= varset($val['ip']) ? trim($val['ip']) : USERIP;
		$user_email = trim(varset($val['email']));
		$user_name 	= trim(varset($val['loginname']));	
		
		$deniedMessage = LAN_SFS_DENIED_MESSAGE;

		if(e107::getPlugPref('sfs', 'sfs_deniedmessage') != "") 
		{
			$deniedMessage = e107::getPlugPref('sfs', 'sfs_deniedmessage');
		}

		// Check IP
		if($user_ip != "")
		{
			if(!$data = $xml->getRemoteFile("http://api.stopforumspam.com/api?ip=".urlencode($user_ip)))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}
			
			$xm = new SimpleXMLElement($data);
			
			switch($xm->appears) 
		 	{
				case 'yes':
					$this->sfsLog($data, $val);
					return $deniedMessage; // Appears in the stopforumspam.com database, refuse signup.  
				break;
				case 'no': 
					$this->sfsLog($data, $val , false);
					//return false;  
				break;
				default:
					$this->sfsLog("Couldn't check stopforumspam.com against". $user_ip, $val);
					//return false;  
				break;
			 } 
		}
		else
		{
			$this->sfsLog("No IP address supplied");
		}
	
		// Check Email 
		if($user_email != "")
		{
			if(!$data = $xml->getRemoteFile("http://api.stopforumspam.com/api?email=" . urlencode($user_email)))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}

			$xm = new SimpleXMLElement($data);

			switch($xm->appears) 
		 	{
				case 'yes': 
					$this->sfsLog($data, $val);
					return $deniedMessage; // Appears in the stopforumspam.com database, refuse signup.  
				break;
				case 'no': 
					$this->sfsLog($data, $val, false);
					//return false;  
				break;
				default:
					$this->sfsLog("Couldn't check stopforumspam.com against".$user_email, $val);
					//return false;  
				break;
			} 
		}
		else
		{
			$this->sfsLog("No e-mail address supplied");
		}


		// Check username  
		if($user_name != "")
		{
			if(!$data = $xml->getRemoteFile("http://api.stopforumspam.org/api?username=".urlencode($user_name)))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}

			$xm = new SimpleXMLElement($data);

				switch ($xm->appears) 
		 		{
					case 'yes': 
						$this->sfsLog($data, $val);
						return $deniedMessage; // Appears in the stopforumspam.com database, refuse signup.  
					break;
					case 'no': 
						$this->sfsLog($data, $val, false);
						//return false;  
					break;
					default:
						$this->sfsLog("Couldn't check stopforumspam.com against ".$user_name, $val);
						//return false;  
					break;
			} 
		}
		else
		{
			$this->sfsLog("No username supplied");
		}

		return false; 
	}

	// Log Raw Data 
	function sfsLog($data, $val, $status = true)
	{
		$pref = e107::pref('sfs');
		
		if($status == false && ($pref['sfs_debug'] != 1))
		{
			return; 	
		}

		e107::getLog()->addDebug("Username: ".$val['loginname']." E-mail: ".$val['email']." IP: ".$val['ip']);
		e107::getLog()->addDebug($data);
        e107::getLog()->toFile('sfs', 'StopForumSpam Debug Information', true);
	}
}