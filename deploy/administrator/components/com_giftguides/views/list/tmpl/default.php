<?php defined('_JEXEC') or die();?>

<?php
	$document = &JFactory::getDocument();
	$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
	$document->addCustomTag("<script type='text/javascript'>jQuery.noConflict();</script>");
	//$document->addScript("components".DS."com_sweepstakes".DS."js".DS."jquery.domwindow.js");
?>

<script type="text/javascript">
	function tableOrdering( order, dir, task ) {
	    var form = document.adminForm;
		    form.filter_order.value 	= order;
		    form.filter_order_Dir.value = dir;
		    document.adminForm.submit( task );
	}
	jQuery(document).ready(function() {
		//Detects showUsers dropdown change
		jQuery('#showUsers').change(function(){
			jQuery('#adminForm').submit();
		});
	});
</script>

<?php
	$output		= "";
	$output		.= "<form action='".JRoute::_('index.php')."' method='POST' name='adminForm' id='adminForm'>";
	$output			.= "<table class='adminlist'>";
	//Table Head
	$output				.= "<thead>";
	if($this->user->checkACL($this->minACL)) {
		$output				.= "<tr>";
		$output					.= "<th colspan='9' align='center'>".JText::_('LIST_SHOW_USERS');
		$output						.= "<select name='showUsers' id='showUsers'>";
		$output							.= "<option value=null>All Users</option>";
		foreach($this->user->loadUsers(2) as $key=>$value) {
			if($this->showUsers == $value->id) {
				$selected	= " SELECTED";
			} else {
				$selected	= "";	
			}
			$output						.= "<option value='{$value->id}'{$selected}>{$value->name}</option>";
		}
		$output						.= "</select>";
		$output					.= "</th>";
		$output				.= "</tr>";
	}
	$output					.= "<tr>";
	$output						.= "<th width='10'>&nbsp;</th>";
	$output						.= "<th width='10'>".JHTML::_('grid.sort', 'ID', 'id', $this->lists['order_Dir'], $this->lists['order'])."</th>";
	$output						.= "<th>".JHTML::_('grid.sort', 'LIST_NAME', 'giftguide_name', $this->lists['order_Dir'], $this->lists['order'])."</th>";
		if($this->user->checkACL($this->minACL)) {
			$output				.= "<th>".JText::_('LIST_MANAGER')."</th>";
		}
	$output						.= "<th>".JText::_('LIST_FEED')."</th>";
	//$output						.= "<th>".JHTML::_('grid.sort', 'LIST_TIMESTAMP', 'timestamp', $this->lists['order_Dir'], $this->lists['order'])."</th>";
	$output					.= "</tr>";
	$output				.= "</thead>";
	
	//Table Body
	$output			.= "<tbody>";
		$i = $k = 0;		
		if(empty($this->giftguides)) {
			$output		.= "<tr>";
			$output			.= "<td colspan='6' align='center'>No gift guides found</td>";
			$output		.= "</tr>";
		} else {
			foreach($this->giftguides as $row) {
			$checked 	= JHTML::_('grid.id', $i, $row->id);
			$link		= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=editGiftGuide&cid[]='.$row->id.'&hidemainmenu=1');
			$user		=& JFactory::getUser($row->author);
			
			$output		.= 	"<tr class='row{$k}'>";
			$output			.= "<td>{$checked}</td>";
			$output			.= "<td>{$row->id}</td>";
			$output			.= "<td><a href='{$link}'>{$row->giftguide_name}</a></td>";
				if($this->user->checkACL($this->minACL)) {
					$output	.= "<td align='center'>{$user->name}</td>";
				}
			//$output			.= "<td align='center'>{$row->timestamp}</td>";
			$feedXML	= JRoute::_('http://'.$_SERVER["HTTP_HOST"].'/index.php?option='.JRequest::getVar('option').'&view=xml&format=raw&gid='.$row->id);
			$output			.= "<td align='center'><a href='{$feedXML}' target='_blank'>{$feedXML}</a></td>";						
			$output		.= "</tr>";
			}// end for
		}
	$output			.= "</tbody>";
	
	//Table Footer
	$output			.= "<tfoot>";
	$output				.= "<tr>";
	$output					.= "<td colspan='9'>{$this->pagination->getListFooter()}</td>";
	$output				.= "</tr>";
	$output			.= "</tfoot>";
	$output			.= "</table>";
	
	//Hidden Form Inputs
	$output		.= "<input type='hidden' name='filter_order' value='{$this->lists['order']}'/>";
	$output		.= "<input type='hidden' name='filter_order_Dir' value='{$this->lists['order_Dir']}' />";
	$output		.= "<input type='hidden' name='option' value='".JRequest::getVar('option')."'/>";
	$output		.= "<input type='hidden' name='task' value=''/>";
	$output		.= "<input type='hidden' name='boxchecked' value='0'/>";
	$output		.= "<input type='hidden' name='hidemainmenu' value='0'/>";
	$output		.= "<input type='hidden' name='removeType' value='sweepstakes'/>";
	
	$output		.= "</form>";
	echo $output;
?>