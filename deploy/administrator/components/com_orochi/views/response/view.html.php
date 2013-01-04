<?php
    // no direct access

    defined( '_JEXEC' ) or die( 'Restricted access' );

    jimport( 'joomla.application.component.view');


    class OrochiViewResponse extends JView
    {                		
		function templateResponse($template, $oid = '', $mid = '', $gid = '') {
			$model				=& $this->getModel('orochi');
			switch($template) {
				case "forms_config":	$orochi					= $model->getOrochiRow($oid);
										$userObj				= new userHelper();
										$minACL					= 1;
										$this->assignRef('orochi', $orochi);
										$this->assignRef('userObj', $userObj);
										$this->assignRef('minACL', $minACL);
										break;
				case "forms_menu":		$orochiMenu				= $model->getOrochiGM($oid, 'menu');
										$this->assignRef('orochiMenu', $orochiMenu);
										$this->assignRef('mid', $mid);
										break;
				case "modal_group": 	$contentObj				= $model->getGeneric('content', 'gid', $gid);
										$this->assignRef('contentObj', $contentObj);
										$this->assignRef('gid', $gid);
										$this->assignRef('mid', $mid);
										break;
										
				case "modal_group_list":$orochiGroups			= $model->getOrochiGM($oid, 'groups');
										$orochiMenu				= $model->getOrochiGM($oid, 'menu');
										$this->assignRef('orochiGroups', $orochiGroups);
										$this->assignRef('orochiMenu', $orochiMenu);
										$this->assignRef('gid', $gid);
										break;
										
				case "workspace":		//$orochiSetupMenu250		= $model->getMenu($oid, "250");
										//$orochiSetupMenu600		= $model->getMenu($oid, "600");
										$orochi					= $model->getOrochiRow($oid);
										$orochiMenu				= $model->getOrochiGM($oid, 'menu');
										$orochiGroups			= $model->getOrochiGM($oid, 'groups');
										$orochiContent			= $model->getOrochiGM($oid, 'content');
										//$this->assignRef('orochiSetupMenu250', $orochiSetupMenu250);
										//$this->assignRef('orochiSetupMenu600', $orochiSetupMenu600);
										$this->assignRef('orochi', $orochi);
										$this->assignRef('orochiMenu', $orochiMenu);
										$this->assignRef('orochiGroups', $orochiGroups);
										$this->assignRef('orochiContent', $orochiContent);
										break;
			}
			$this->assignRef('template', $template);
			parent::display();
		}
    }
?>	