<?php
	defined('_JEXEC') or die();
	JHTML::_('behavior.mootools');
	
	$entrants	= new entrantList($this->fields);
	$colspan	= $entrants->getColspan();
?>

<fieldset class="adminform">
	<legend><?php echo JText::_('RANDOM_SELECT_SETTINGS');?></legend>
	<form action="<?php echo JRoute::_('index.php');?>" method="POST" name="adminForm">
		<table class="admintable">
			<tr>
				<td class="key"><?php echo JText::_('RANDOM_SELECT');?></td>
				<td><input type="text" name="random_value" id="random_value" size="5" maxlength="10" value="<?php echo $this->random_value;?>"/></td>
			</tr>
		</table>
		<input type="hidden" name="check" value="post"/>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
		<input type="hidden" name="sid" value="<?php echo JRequest::getVar('sid'); ?>"/>     
		<input type="hidden" name="task" value="<?php echo JRequest::getVar('task');?>"/>
		<input type="submit" value="Select Entrant(s)"/>
	</form>
</fieldset>
	<?php
	if(!empty($this->entrants)) {
	?>
	<table class="adminlist">
		<thead>
			<tr>
				<?php
					$downloadExcel	= JRoute::_('index.php?format=raw&option=com_sweepstakes&task=displayRandomExcel&sid='.JRequest::getVar('sid').'&uid='.serialize($this->entrantIds));
				?>
				<th colspan="<?php echo $colspan;?>">
					<a href='<?php echo $downloadExcel;?>'><?php echo JText::_('DOWNLOAD EXCEL');?></a>
				</th>
			</tr>
			<tr>
				<th width="10"><?php echo JText::_('HEADER ID');?></th>
				<?php
				for($i=0; $i < sizeof($this->fields['name']); $i++) {
					echo "<th>".$this->fields['name'][$i]."</th>\n";
				}
				?>
				<th><?php echo JText::_('HEADER TIMESTAMP');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$entrants->entrantList($this->entrants);
			?>
		</tbody>
	</table>
	<?php
	}
	?>