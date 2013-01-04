<?php

defined('_JEXEC') or die();

jimport("joomla.application.component.view");
require_once (JPATH_COMPONENT.DS."classes".DS."sweepstakesHelper.class.php");

//Name based on folder name
class SweepstakesViewSweepstakesForm extends JView {
	
	/**
	* View: Display sweepstake edit form
	* @param int $sid Sweepstake ID
	*/
	function displayEdit($sid) {
		JToolBarHelper::title("Sweepstake".":[<small>Edit</small>]");
		JToolBarHelper::cancel();
		JToolBarHelper::save();
		//JToolBarHelper::edit();
		JHTML::_('behavior.calendar');
		
		$userObj	= new userHelper();
		$minACL		= 1;
		
		$this->validateForm();
		
		$model			= $this->getModel('sweeps');
		$sweepstake		= $model->getSweepstake($sid);
		$fields			= unserialize($sweepstake->fields);
		
		$entrantsModel	= $this->getModel('entrants');
		$entrants		= $entrantsModel->getEntrantCount($sid);
		
		
		//Object reference for tmpl	
		$this->assignRef('sweepstake', $sweepstake);
		$this->assignRef('fields', $fields);
		$this->assignRef('entrants', $entrants);
		$this->assignRef('user', $userObj);
		$this->assignRef('minACL', $minACL);
		parent::display();
	}
	
	/**
	* View: Display a new sweepstake form
	* @link JS Table Drag and Drop - http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
	*/
	function displayAdd() {
		JToolBarHelper::title("Sweepstake".":[<small>Create</small>]");
		JToolBarHelper::cancel();
		JToolBarHelper::save();
		JHTML::_('behavior.calendar');
		
		$userObj	= new userHelper();
		$minACL		= 1;
		
		$this->validateForm();
		
		$model		= $this->getModel();
		//$sweepstake	= $this->getNewSweepstake();
		$this->assignRef('sweepstake', $sweepstake);
		$this->assignRef('user', $userObj);
		$this->assignRef('minACL', $minACL);
		parent::display();
	}
	
	/**
	* Javascript validator for sweepstake form
	*/
	function validateForm() {
		?>
		<script type="text/javascript">
			function submitbutton(pressbutton) {
				
				var form	= document.adminForm;
				
				if(pressbutton == 'cancel') {
					submitform(pressbutton);
					return;
				}
				
				if(pressbutton == 'save') {
					//Validation
					var fieldName	= document.getElementsByName('field_name[]');
					var flag		= true;
					
					for (var i = 0; i < fieldName.length; i++) {         
						if (fieldName[i].value == "") { 
							alert("<?php echo JText::_('Please enter an input field name');?>");
							flag = false;
						}
					}
					
					if(flag) {
						var dateStart	= new Date(form.date_start.value);
						var dateEnd		= new Date(form.date_end.value);
											
						if(form.name.value == "") {
							alert("<?php echo JText::_('Please enter a sweepstake name', true);?>");
						} else if(form.date_start.value == "") {
							alert("<?php echo JText::_('Please enter a start date', true);?>");
						} else if(form.date_end.value == "") {
							alert("<?php echo JText::_('Please enter an end date', true);?>");
						} else if(dateStart.getTime() >= dateEnd.getTime()) {
							alert("<?php echo JText::_('Invalid date range', true);?>");
						}else {
							submitform(pressbutton);
						}
					}
				}
				
			}
		</script>
		<?php
	}
}

?>