<?php
require_once("../../class2.php");if (!getperms("P")){ header("location:" . e_BASE."index.php");   exit;}
require_once(e_ADMIN."auth.php");
class sfs{		function render()	{		global $pref, $ns;				if(varset($_POST['sfs_save']))		{			$pref['sfs_enabled'] = intval($_POST['sfs_enabled']);			$ns->tablerender("Saved","Settings Saved");			save_prefs();		}						$text .= $this->prefsForm();				return $text;	}			function prefsForm()	{		global $sql,$sql2,$tp,$pref;						$checked = ($pref['sfs_enabled'] == 1) ? "checked='checked'" : "";				$text .= "		<form method='post' action='".e_SELF."' >		<div>			<input type='checkbox' name='sfs_enabled' value='1' {$checked} /> Enable 		</div>		<div style='padding:10px'>			<input type='submit' class='btn btn-primary button' name='sfs_save' value='Save' />		</div>		</form>";				return $text;	}	}
$sfs = new sfs;
$ns -> tablerender("Stop Forum Spam", $sfs->render());

require_once(e_ADMIN."footer.php");

?>