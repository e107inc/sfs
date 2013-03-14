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

global $e_event; 

if(is_object($e_event))
{
	$e_event->register("usersup_veri", "sfsCheck", e_PLUGIN."sfs/e_module.php");
}

// Uncomment to Test. 
//$vals = array('ip'=>"70.32.38.83");
// var_dump(sfsCheck($vals));


if(!function_exists("sfsCheck"))
{
	/**
	 * Stop Forum Spam module by e107 Inc. using the stopforumspam.com API. 
	 * @param $val array of user data. 
	 */
	function sfsCheck($val=array())
	{
		
		global $pref; 
		
		if($pref['sfs_enabled'] == 1)
		{
			return false; 	
		}
		
		$error 			= false;
	
		$user_email 	= trim(varset($val['email']));
		$user_ip 		= varset($val['ip']) ? trim($val['ip']) : USERIP;
		$user_name 		= trim(varset($val['loginname']));	 
		
		$deniedMessage = "Sorry no bots allowed!";

		if(!is_object("parseXml"))
		{
			require_once(e_HANDLER."xml_class.php");	
		}
		
		$xml = new parseXml;
			
		// Check IP
		if ($user_ip != "")
		{
			$xml->setUrl("http://www.stopforumspam.com/api?ip=" . urlencode($user_ip));
			$data = $xml->getRemoteXmlFile();
			$xm = new SimpleXMLElement($data);

			switch ($xm->appears) 
		 	{
				case 'yes':
					sfsLog($data);
					return $deniedMessage;  // Is a BOT. 
				break;

				case 'no': 
					return false;  
				break;
					
				default:
					sfsLog(date('r')." : Couldn't check stopforumspam.com against ".$user_ip);
					return false;  
				break;
			 } 
		  }
	
		// Check Email 
		if ($user_email != "")
		{
			$xml->setUrl("http://www.stopforumspam.com/api?email=" . urlencode($user_email));
			$data = $xml->getRemoteXmlFile();
			$xm = new SimpleXMLElement($data);

			switch ($xm->appears) 
		 	{
				case 'yes': 
					sfsLog($data);
					return $deniedMessage; 	   // Is a BOT. 
				break;

				case 'no': 
					return false;  
				break;
				
				default:
					sfsLog(date('r')." : Couldn't check stopforumspam.com against ".$user_email);
					return false;  
				break;
			} 
		}	

		// Check username  
		if ($user_name != "")
		{
			$xml->setUrl("http://www.stopforumspam.com/api?username==" . urlencode($user_name));
			$data = $xml->getRemoteXmlFile();
			$xm = new SimpleXMLElement($data);

				switch ($xm->appears) 
		 		{
					case 'yes': 
						sfsLog($data);
						return $deniedMessage; 	   // Is a BOT. 
					break;

					case 'no': 
						return false;  
					break;
				
					default:
						sfsLog(date('r')." : Couldn't check stopforumspam.com against ".$user_name);
						return false;  
					break;
			} 
		}	
		
		
		
	}

	// Log Raw Data 
	function sfsLog($data)
	{
		$path = (defined("e_LOG")) ? e_LOG."sfs.log" : e_PLUGIN."sfs/sfs.log";	
		$data .= "\n\n";
		@file_put_contents($path, $data, FILE_APPEND | LOCK_EX);	
	}
	
}




?>