<?php defined('_JEXEC') or die();?>

<?php
	$document = &JFactory::getDocument();
	$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
	$document->addCustomTag("<script type='text/javascript'>jQuery.noConflict();</script>");
	$document->addScript("components".DS."com_sweepstakes".DS."js".DS."jquery.domwindow.js");
?>

<script type="text/javascript">
	function tableOrdering( order, dir, task ) {
	    var form = document.adminForm;
		    form.filter_order.value 	= order;
		    form.filter_order_Dir.value = dir;
		    document.adminForm.submit( task );
	}

	jQuery(document).ready(function() {
		jQuery('.formWindow').openDOMWindow({ 
			height:600, 
			width:800, 
			eventType:'click', 
			windowSource:'iframe', 
			windowPadding:0, 
			loader:1, 
			loaderImagePath:'animationProcessing.gif', 
			loaderHeight:16, 
			loaderWidth:17 
		});
		
		//Detects showUsers dropdown change
		jQuery('#showUsers').change(function(){
			//console.log(jQuery(this).val());
			jQuery('#adminForm').submit();
		});
	});
</script>

<form action="<?php echo JRoute::_( 'index.php' );?>" method="POST" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<?php 
			if($this->user->checkACL($this->minACL)) {			
			?>
			<tr>
				<th colspan='9' align='center'><?php echo JText::_('SHOW_USERS');?> 
					<select name='showUsers' id='showUsers'>
						<option value=null>All Users</option>
					<?php 
					foreach($this->user->loadUsers(2) as $key=>$value) {
										
						if($this->showUsers == $value->id) {
							$selected	= " SELECTED";
						} else {
							$selected	= "";
						}
						echo "<option value='{$value->id}'{$selected}>{$value->name}</option>\n";
					}
					?>
					</select>
				</th>
			</tr>
			<?php
			}
			?>
			<tr>
				<th width="20px">&nbsp;</th>
				<th width="32px"><?php echo JHTML::_('grid.sort', 'ID', 'id', $this->lists['order_Dir'], $this->lists['order']);?></th>
				<th><?php echo JHTML::_('grid.sort', 'SWEEPSTAKE NAME', 'name', $this->lists['order_Dir'], $this->lists['order']);?></th>
				<th width="150px"><?php echo JText::_('ENTRANTS');?></th>
				<th><?php echo JText::_('MANAGER_TITLE_ACTIONS');?></th>
				<th><?php echo JHTML::_('grid.sort', 'DATE START', 'date_start', $this->lists['order_Dir'], $this->lists['order']);?></th>
				<th><?php echo JHTML::_('grid.sort', 'DATE END', 'date_end', $this->lists['order_Dir'], $this->lists['order']);?></th>
				<?php
				if($this->user->checkACL($this->minACL)) {
				?>
				<th><?php echo JText::_('AUTHOR');?></th>
				<?php
				}
				?>
				<th><?php echo JText::_('DEVELOPERS_TITLE');?></th>
			</tr>
		</thead>
		<tbody>
			<?php			
			$k	= 0;
			$i	= 0;
			if(empty($this->sweeps)) {
				echo "<tr>\n";
				echo "\t<td colspan='9' align='center'>No sweepstakes found for your account</td>\n";
				echo "</tr>\n";
			} else {
				foreach($this->sweeps as $row) {
				
					$checked	= JHTML::_('grid.id', $i, $row->id);
					$link		= JRoute::_('index.php?option='.JRequest::getVar("option").'&task=edit&cid[]='.$row->id.'&hidemainmenu=1');
					//$published	= JHTML::_('grid.published', $row, $i);//Publishing button
					
					//Valid?
					$entrantsModel	= $this->getModel('entrants');
					$entrantsLink	= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=displayEntrant&sid='.$row->id.'&hidemainmenu=1');
					$entrantsExcel	= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=displayExcel&sid='.$row->id.'&format=raw');
					$xmlLink		= JRoute::_('../index.php?option='.JRequest::getVar('option').'&view=xml&format=raw&sid='.$row->id);
					$formLink		= JRoute::_('../index.php?option='.JRequest::getVar('option').'&view=form&format=raw&sid='.$row->id);
					$winnerLink		= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=displayRandom&sid='.$row->id);
					
					$entrantCount	= $entrantsModel->getEntrantCount($row->id);
					if($entrantCount > 0) {
						$entrants			= "<a href='{$entrantsLink}'>{$entrantCount}</a>";
						$entrantsActions	= "<a href='{$winnerLink}'>".JText::_('MANAGER_CELL_WINNER')."</a>";
						$entrantsActions	.= " | <a href='{$entrantsExcel}'>".JText::_('DOWNLOAD EXCEL')."</a>";
					} else {
						$entrants			= JText::_('NO ENTRANTS');
						$entrantsActions	= JText::_('MANAGER_CELL_NO_ACTIONS');;
					}
					
					$user =& JFactory::getUser($row->author);
					?>
					<tr class="<?php echo "row$k";?>">
						<td><?php echo $checked;?></td>
						<td><?php echo $row->id;?></td>
						<td><a href='<?php echo $link;?>'><?php echo $row->name;?></a></td>
						<td align="center"><?php echo $entrants; ?></td>
						<td align="center"><?php echo $entrantsActions;?></td>
						<td align="center"><?php echo JHTML::date($row->date_start, '%b %e, %G', JText::_('DATE_FORMAT_LC'));?></td>
						<td align="center"><?php echo JHTML::date($row->date_end, '%b %e, %G', JText::_('DATE_FORMAT_LC'));?></td>
						<?php
						if($this->user->checkACL($this->minACL)) {
						?>
						<td align="center"><?php echo $user->name; ?></td>
						<?php
						}
						?>
						<td align="center">
							<!-- <a href="<?php echo $xmlLink; ?>" target="_blank"><?php echo JText::_('XML');?></a> |  -->
							<a href="<?php echo $formLink;?>" class="formWindow"><?php echo JText::_('FORM');?></a>
						</td>
					</tr>
				<?php
					$k	= 1-$k;
					$i++;
				}//end: foreach
			}//end: else
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>

	</table>
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="option" value="<?php echo JRequest::getVar('option');?>"/>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="hidemainmenu" value="0"/>
	<input type="hidden" name="removeType" value="sweepstakes"/>

</form>