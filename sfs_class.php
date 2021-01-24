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
	
	public function init($data)
	{	 
		$result = $this->sfsCheck($data); 
		return $result; 
	}

	function sfsCheck($val = array())
	{
		$xml = e107::getXml(); 

		// Check if SFS is active (just making sure)
		if(!e107::getPlugPref('sfs', 'sfs_enabled')) 
		{
			return false; 
		}	
	
		$user_email 	= trim(varset($val['email']));
		$val['ip'] 		= varset($val['ip']) ? trim($val['ip']) : USERIP;
		$user_name 		= trim(varset($val['loginname']));	 
		
		$deniedMessage = LAN_SFS_DENIED_MESSAGE;
			
		// Check IP
		if ($val['ip']  != "")
		{
			if(!$data = $xml->getRemoteFile("http://www.stopforumspam.com/api?ip=" . urlencode($val['ip'] )))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}
		
			$xm = new SimpleXMLElement($data);
			
			switch($xm->appears) 
		 	{
				case 'yes':
					$this->sfsLog($data, $val);
					return $deniedMessage;  // Is a BOT. 
				break;

				case 'no': 
					$this->sfsLog($data, $val , false);
					return false;  
				break;
					
				default:
					$this->sfsLog("Couldn't check stopforumspam.com against ". $val['ip'] , $val);
					return false;  
				break;
			 } 
		  }
	
		// Check Email 
		if ($user_email != "")
		{
			if(!$data = $xml->getRemoteXmlFile("http://www.stopforumspam.com/api?email=" . urlencode($user_email)))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}

			$xm = new SimpleXMLElement($data);

			switch ($xm->appears) 
		 	{
				case 'yes': 
					$this->sfsLog($data,$val);
					return $deniedMessage; 	   // Is a BOT. 
				break;

				case 'no': 
					$this->sfsLog($data, $val, false);
					return false;  
				break;
				
				default:
					$this->sfsLog("Couldn't check stopforumspam.com against ".$user_email, $val);
					return false;  
				break;
			} 
		}

		// Check username  
		if($user_name != "")
		{
			if(!$data = $xml->getRemoteXmlFile("http://www.stopforumspam.com/api?username==" . urlencode($user_name)))
			{
				$this->sfsLog("Couldn't access stopforumspam.com");
				return;
			}

			$xm = new SimpleXMLElement($data);

				switch ($xm->appears) 
		 		{
					case 'yes': 
						$this->sfsLog($data,$val);
						return $deniedMessage; 	   // Is a BOT. 
					break;
					case 'no': 
						$this->sfsLog($data, $val, false);
						return false;  
					break;
					default:
						$this->sfsLog("Couldn't check stopforumspam.com against ".$user_name, $val);
						return false;  
					break;
			} 
		}
	}

	// Log Raw Data 
	function sfsLog($data, $val, $status = true)
	{
		$pref = e107::pref('sfs');
		
		if($status == false && ($pref['sfs_debug'] != 1))
		{
			return; 	
		}

		e107::getAdminLog()->addDebug("USERNAME: ".$val['loginname']." EMAIL: ".$val['email']." IP: ".$val['ip']);
        e107::getAdminLog()->toFile('sfs', 'StopForumSpam Debug Information', true);
	}
}