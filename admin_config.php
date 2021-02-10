<?php
/*
 * StopForumSpam (SFS)
 *
 * Copyright (C) 2021-2022 e107 Inc. (https://www.e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

require_once(__DIR__.'/../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

e107::lan('sfs', true, true);

class sfs_adminArea extends e_admin_dispatcher
{
	protected $modes = array(	
		'main'	=> array(
			'controller' 	=> 'sfs_ui',
			'path' 			=> null,
			'ui' 			=> 'sfs_form_ui',
			'uipath' 		=> null
		),
	);	
	
	
	protected $adminMenu = array(
		//'main/list'			=> array('caption'=> LAN_MANAGE, 'perm' => 'P'),
		//'main/create'		=> array('caption'=> LAN_CREATE, 'perm' => 'P'),

		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	

		// 'main/div0'      => array('divider'=> true),
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = LAN_PLUGIN_SFS_NAME;
}

	
class sfs_ui extends e_admin_ui
{
		protected $pluginTitle		= LAN_PLUGIN_SFS_NAME;
		protected $pluginName		= 'sfs';
	//	protected $eventName		= 'sfs-sfs'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'sfs';
		protected $pid				= '';
		protected $perPage			= 10; 
		protected $batchDelete		= false;
		protected $batchExport      = false;
		protected $batchCopy		= false;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent       = 'somefield_parent';
	//	protected $treePrefix       = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
		protected $listOrder		= '';
	
		protected $fields = array();		
		
		protected $fieldpref = array();
		
	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
			'sfs_enabled' => array(
				'title'			=> LAN_SFS_PREFS_ACTIVE, 
				'tab'			=> 0, 
				'type'			=> 'boolean', 
				'data' 			=> 'int', 
				'help'			=> LAN_SFS_PREFS_ACTIVE_HELP, 
				'writeParms'	=> array()
			),
			'sfs_debug' => array(
				'title'			=> LAN_SFS_PREFS_DEBUG, 
				'tab'			=> 0, 
				'type'			=> 'boolean', 
				'data' 			=> 'int', 
				'help'			=> LAN_SFS_PREFS_DEBUG_HELP, 
				'writeParms'	=> array()
			),
			/*'sfs_apikey' => array(
				'title'			=> LAN_SFS_PREFS_APIKEY, 
				'tab'			=> 0,
				'type'			=> 'text', 
				'data' 			=> 'str', 
				'help'			=> LAN_SFS_PREFS_APIKEY_HELP, 
				'writeParms' 	=> array()
			),*/
		); 

	
		public function init()
		{
			// This code may be removed once plugin development is complete. 
			if(!e107::isInstalled('sfs'))
			{
				e107::getMessage()->addWarning("This plugin is not yet installed. Saving and loading of preference or table data will fail."); // DO NOT TRANSLATE
			}

			$old_files = array(
				'index.html',
				'e_module.php',
				'plugin.php',
			);

			foreach($old_files as $old_file)
			{
				if(file_exists($old_file))
				{
					@unlink($old_file);

					if(file_exists($old_file))
					{
						e107::getMessage()->addDebug("Please remove the following outdated file: ".$old_file); // DO NOT TRANSLATE
					}
					else
					{
						e107::getMessage()->addSuccess("Outdated file removed: ".$old_file);
						e107::getPlug()->clearCache()->buildAddonPrefLists();
					}
				}
			}

		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}		
		
		// left-panel help menu area
		public function renderHelp()
		{

			if($this->getAction() == "prefs")
			{		
				$text = '';
				$caption = LAN_HELP;

				$text .= '<strong>'.LAN_SFS_PREFS_DEBUG.'</strong>'; 
				$text .= '<p>'.LAN_SFS_PREFS_DEBUG_HELP.'</p>';

				/*$text .= '<strong>'.LAN_SFS_PREFS_APIKEY.'</strong>'; 
				$text .= '<p>'.LAN_SFS_PREFS_APIKEY_HELP.'</p>';*/
			}
			

			return array('caption' => $caption,'text' => $text);
		}
			
		/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		*/			
}
				

class sfs_form_ui extends e_admin_form_ui
{
	

}				
		
new sfs_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;