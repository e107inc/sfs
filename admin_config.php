<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

// TODO REWRITE TO USE ADMIN UI

require_once("../../class2.php");

if (!getperms("P"))
{
	 header("location:" . e_BASE."index.php");  
	 exit;
}

require_once(e_ADMIN."auth.php");


class sfs
{
	
	function render()
	{
		global $pref, $ns;
		
		if(varset($_POST['sfs_save']))
		{
			$pref['sfs_enabled'] = intval($_POST['sfs_enabled']);
			$pref['sfs_debug'] = intval($_POST['sfs_debug']);
			$ns->tablerender("Saved","Settings Saved");
			save_prefs();
		}
				
		$text .= $this->prefsForm();		
		return $text;
	}
	
	
	function prefsForm()
	{
		global $sql,$sql2,$tp,$pref;
		
		
		$checked = ($pref['sfs_enabled'] == 1) ? "checked='checked'" : "";
		$checkeddbg = ($pref['sfs_debug'] == 1) ? "checked='checked'" : "";
		
		$text .= "
		<form method='post' action='".e_SELF."' >
		<label style='display:block'>
			<input type='checkbox' name='sfs_enabled' value='1' {$checked} /> Enable the <em>Stop Forum Spam</em> system 
			
		</label>
		<label style='display:block'>
			<input type='checkbox' name='sfs_debug' value='1' {$checkeddbg} /> Enable logging of all results<br /><small>(those found to be spam will be logged by default)</small>. 	
		</label>
		
		<div style='padding:10px'>
			<input type='submit' class='btn btn-primary button' name='sfs_save' value='Save' />
		</div>
		</form>";
		
		return $text;
	}
	

}

$sfs = new sfs;

$ns -> tablerender("Stop Forum Spam", $sfs->render());



require_once(e_ADMIN."footer.php");



?>