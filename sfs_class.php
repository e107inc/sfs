<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

use Resolventa\StopForumSpamApi\ResponseAnalyzer;
use Resolventa\StopForumSpamApi\ResponseAnalyzerSettings;
use Resolventa\StopForumSpamApi\StopForumSpamApi;
use Resolventa\StopForumSpamApi\Exception\StopForumSpamApiException;

include 'vendor/autoload.php';


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


	function sfsCheck($data = array())
	{
		$stopForumSpamApi = new StopForumSpamApi();

		$ip 		= varset($data['ip']) ? trim($data['ip']) : USERIP;
		$email 		= trim(varset($data['email']));
		$username 	= trim(varset($data['loginname']));

		$stopForumSpamApi
		    ->checkEmail($email)
		    ->checkIp($ip)
		    ->checkUsername($username);

		$response = $stopForumSpamApi->getCheckResponse();

		$analyzer = new ResponseAnalyzer(new ResponseAnalyzerSettings());

		try 
		{
		    if($analyzer->isSpammerDetected($response)) 
		    {
		    	$this->sfsLog($data);
		       
		    	$message = str_replace("[x]", "<strong>{$username}</strong>", LAN_SFS_CHECK_BOT);
		       	e107::getMessage()->addWarning($message); 
		    }
		    else 
		    {
		    	$this->sfsLog($data, $val , false);

		        $message = str_replace("[x]", "<strong>{$username}</strong>", LAN_SFS_CHECK_NOBOT);
				e107::getMessage()->addSuccess($message); 
		    }
		} 
		catch (StopForumSpamApiException $e) 
		{
		    $message = 'Bad response: '.  $e->getMessage();
		    e107::getMessage()->addError($message);
		    exit();
		}

	}

	// Log Raw Data 
	function sfsLog($data, $val = '', $status = true)
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