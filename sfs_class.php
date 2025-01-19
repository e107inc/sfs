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

e107::lan('sfs', true, true);

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
			
			// Run check 
			$result = $this->sfsCheck($data, 'signup'); 
			
			return $result;
		}
	}


	public function sfsCheck($data = array(), $event = '')
	{
		$stopForumSpamApi = new StopForumSpamApi();

		// Set up basic data
		$ip 		= varset($data['ip']) ? trim($data['ip']) : USERIP;
		$ip 		= e107::getIPHandler()->ipDecode($ip); 
		$data['ip'] = $ip; 
		$email 		= trim(varset($data['email']));
		$username 	= trim(varset($data['loginname']));

		// Set up (custom) denied message
		$deniedMessage = LAN_SFS_DENIED_MESSAGE;

		if(e107::getPlugPref('sfs', 'sfs_deniedmessage') != "") 
		{
			$deniedMessage = e107::getPlugPref('sfs', 'sfs_deniedmessage');
		}

		// Initialize SFS API check
		$stopForumSpamApi
		    ->checkEmail($email)
		    ->checkIp($ip)
		    ->checkUsername($username);

		// Get response
		$response = $stopForumSpamApi->getCheckResponse();

		// Create analyzer settings with default values
		$settings = new ResponseAnalyzerSettings();

		// Retrieve analyzer settings from preferences
		$MinSpamFlagsCount 			= e107::getPlugPref('sfs', 'sfs_msfc', 1); 
		$MinFlagAppearanceFrequency = e107::getPlugPref('sfs', 'sfs_mfaf', 5); 
		$FlagLastSeenDaysAgo		= e107::getPlugPref('sfs', 'sfs_flsda', 7); 
		$ConfidenceThreshold		= e107::getPlugPref('sfs', 'sfs_ct', 90);

		// Update settings
		$settings->setMinSpamFlagsCount($MinSpamFlagsCount);
		$settings->setMinFlagAppearanceFrequency($MinFlagAppearanceFrequency);
		$settings->setFlagLastSeenDaysAgo($FlagLastSeenDaysAgo);
		$settings->setConfidenceThreshold($ConfidenceThreshold);

		// Analyze response
		$analyzer = new ResponseAnalyzer($settings);

		// Interpret response results
		try 
		{
		    if($analyzer->isSpammerDetected($response)) 
		    {
		    	$this->sfsLog($data, $response);
		       	
		       	// User is signing up and appears to be a bot, so display denied message
		       	if($event == "signup")
		       	{
		       		return $deniedMessage;
		       	}
		       	// It's an admin check
		       	else
		       	{
		       		$message = str_replace("[x]", "<strong>{$username}</strong>", LAN_SFS_CHECK_BOT);
		       		e107::getMessage()->addWarning($message);
		       	}
		    }
		    else 
		    {
		    	$this->sfsLog($data, $response, false);

		    	// Admin check 
		        if(empty($event))
		        {
		        	$message = str_replace("[x]", "<strong>{$username}</strong>", LAN_SFS_CHECK_NOBOT);
					e107::getMessage()->addSuccess($message); 
				}
		    }
		} 
		catch (StopForumSpamApiException $e) 
		{
		    $message = 'Bad response: '.  $e->getMessage();
		    e107::getMessage()->addError($message);
		    exit();
		}
	}

	// Report user
	public function reportUser($data = array())
	{

		$username 	= $data['user_loginname'];
		$ip			= e107::getIPHandler()->ipDecode($data['user_ip']); 
		$email 		= $data['user_email'];
		$evidence 	= '';

		$apiKey = e107::getPlugPref('sfs', 'sfs_apikey'); 

		$stopForumSpamApi = new StopForumSpamApi($apiKey);

		//error_log("going to report now");
		// Interpret response results
		try 
		{
		    $result = $stopForumSpamApi->submitSpamReport($username, $ip, $email, $evidence);
		    $message = str_replace("[x]", "<strong>{$username}</strong>", LAN_SFS_USER_REPORTED);
		    e107::getMessage()->addSuccess($message);
		}
		catch(Exception $e) 
		{
		    $message = 'Bad response: '.  $e->getMessage();
		    e107::getMessage()->addError($message);
		}		

	}

	// Log Raw Data 
	public function sfsLog($data, $response, $status = true)
	{
		$pref = e107::pref('sfs');
		
		if($status == false && ($pref['sfs_debug'] != 1))
		{
			return; 	
		}

		$response = json_encode($response); 


		// Remove passwords from logging 
		if($data['password1'])
		{
			unset($data['password1']); 
		}
		if($data['password2'])
		{
			unset($data['password2']); 
		}

		e107::getLog()->addArray($data, null, E_MESSAGE_DEBUG); 
		e107::getLog()->addArray($response, null, E_MESSAGE_DEBUG); 
        e107::getLog()->toFile('sfs', 'StopForumSpam Debug Information', true);
	}
}