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
		/*if($this->sfs_debug)
		{
			e107::getAdminLog()->addDebug(__LINE__." ".__METHOD__.": SFS is NOT activated for User ID ".$user_id);
			e107::getAdminLog()->toFile('twofactorauth', 'TwoFactorAuth Debug Information', true);
		}*/
			 
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
				$this->sfsLog(date('r')." : Couldn't access stopforumspam.com");
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
					$this->sfsLog(date('r')." : Couldn't check stopforumspam.com against ". $val['ip'] , $val);
					return false;  
				break;
			 } 
		  }
	
		// Check Email 
		if ($user_email != "")
		{
			if(!$data = $xml->getRemoteXmlFile("http://www.stopforumspam.com/api?email=" . urlencode($user_email)))
			{
				$this->sfsLog(date('r')." : Couldn't access stopforumspam.com");
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
					$this->sfsLog(date('r')." : Couldn't check stopforumspam.com against ".$user_email, $val);
					return false;  
				break;
			} 
		}

		// Check username  
		if($user_name != "")
		{
			if(!$data = $xml->getRemoteXmlFile("http://www.stopforumspam.com/api?username==" . urlencode($user_name)))
			{
				$this->sfsLog(date('r')." : Couldn't access stopforumspam.com");
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
						$this->sfsLog(date('r')." : Couldn't check stopforumspam.com against ".$user_name, $val);
						return false;  
					break;
			} 
		}
	}

	// TODO Rewrite sfsCheck() to use e107::getAdminLog()->addDebug() and toFile(). 
	// Log Raw Data 
	function sfsLog($data, $val, $status=true)
	{
		global $pref; 
		
		if($status == false && ($pref['sfs_debug'] != 1))
		{
			return; 	
		}
		
		$path = (defined("e_LOG")) ? e_LOG."sfs.log" : e_PLUGIN."sfs/sfs.log";	
		
		$save = date('r')."\nUSERNAME: ".$val['loginname']." EMAIL: ".$val['email']." IP: ".$val['ip'];
		$save .= "\n".$data;
		$save .= "\n\n";
		
		@file_put_contents($path, $save, FILE_APPEND | LOCK_EX);
		@chmod($path,0640);	
	}
}