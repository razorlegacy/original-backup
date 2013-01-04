<?php // no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.mootools');

$document 	=& JFactory::getDocument();
$user 		=& JFactory::getUser();
$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
$document->addCustomTag("<script type='text/javascript'>jQuery.noConflict();</script>");
$document->addScript("components".DS."com_sweepstakes".DS."js".DS."jquery.tabledragndrop.js");

$fieldInput	= new sweepstakesHelper();
$name		= $fieldInput->outputPrivate("defaultName");
$type		= $fieldInput->outputPrivate("defaultType");
$required	= $fieldInput->outputPrivate("defaultRequired");


$editor =& JFactory::getEditor();

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#addRow").click(function() {
			rowTemplate		= "<tr>";
			rowTemplate		+= "<td>&sect;</td>";
			rowTemplate		+= "<td class='key'><input type='text' name='field[name][]'/></td>";
			rowTemplate		+= "<td><?php $fieldInput->type("field[type][]");?></td>";
			rowTemplate		+= "<td><?php $fieldInput->required("field[required][]");?></td>";
			rowTemplate		+= "<td><input type='button' value='Remove' id='removeRow'/></td>";			
			rowTemplate		+= "</tr>";
			jQuery("#table_fields").last().append(rowTemplate);
			<?php
			if(empty($this->fields)) {
				echo 'jQuery("#table_fields").tableDnD();';
			}
			?>
		});
	
		jQuery("#removeRow").live('click', function() {
			jQuery(this).parent().parent().remove();
		});
		
		<?php
		if(empty($this->fields)) {
			echo 'jQuery("#table_fields").tableDnD();';
		}
		?>	
	});
</script>

<form action="index.php" method="POST" name="adminForm" id="adminForm" class="form-validate">
	<fieldset class="adminform">
		<legend><?php echo JText::_('FIELDSET SWEEPSTAKE');?></legend>
		<table class="admintable">
			<tr>
				<td class="key"><?php echo JText::_('FIELD NAME');?></td>
				<td><input type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->name:''; ?>"/></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('FIELD START DATE');?></td>
				<td>
					<input class="inputbox" type="text" name="date_start" id="date_start" size="40" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->date_start:''; ?>" readonly="readonly" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('date_start', '%Y-%m-%d');" />
				</td>
			<tr>	
				<td class="key"><?php echo JText::_('FIELD END DATE');?></td>
				<td>
					<input class="inputbox" type="text" name="date_end" id="date_end" size="40" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->date_end:''; ?>" readonly="readonly" />
					<input type="reset" class="button" value="..." onclick="return showCalendar('date_end', '%Y-%m-%d');" />
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('FIELD DUPLICATE');?></td>
				<td>
					<?php
						//Binary choice, so only need to detect secondary option since first is default
						if($this->sweepstake && $this->sweepstake->multiple_entrants == 1) {
							$selected_entrants = " selected";
						} else {
							$selected_entrants = "";
						}
					?>
					<select name="multiple_entrants">
						<option value="0">No</option>
						<option value="1"<?php echo $selected_entrants;?>>Yes</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('FIELD AGE');?></td>
				<?php
					if(!empty($this->sweepstake->min_age)) {
						$min_age	= $this->sweepstake->min_age;
					} else {
						$min_age	= "18";
					}
				?>
				<td><input type="text" name="min_age" id="min_age" size="5" maxlength="3" value="<?php echo $min_age; ?>" /></td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('FIELD CLOSE');?></td>
				<td><input type="text" name="close" id="close" size="50" maxlength="250" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->close:'';?>"/></td>
			</tr>
			<?php
			if($this->user->checkACL($this->minACL)) {
				//if(!$this->sweepstake->author) {
				if(!$this->sweepstake) {
					$userDefault	= $user->id;
				} else {
					$userDefault	= $this->sweepstake->author;
				}
				
			?>
			<tr>
				<td class="key"><?php echo JText::_('FIELD_AUTHOR');?></td>
				<td>
				<?php 
					$userSelect	= $this->user->loadUsers(2);
					echo "<select name='author'>\n";
					foreach($userSelect as $value) {
						if($value->id == $userDefault) {
							$selected	= " SELECTED";
						} else {
							$selected	= "";
						}
						echo "<option value='{$value->id}'{$selected}>{$value->name}</option>\n";
					}
					echo "</select>\n";
				?>
				</td>
			</tr>
			<?php
			}
			?>
		</table>
	</fieldset>
	<fieldset class="adminform">
		<legend><?php echo JText::_('FIELDSET FIELDS');?></legend>
		<?php
		if(isset($this->entrants) && $this->entrants > 0) {
			JError::raiseWarning(500, 'Warning: Entrants have been entered for this sweepstake. Changing Field Data will result in entrant data not matching new fields.');
		}
		?>
		<input type="button" name="addRow" id="addRow" value="Add Field" />
		<table class="admintable" id="table_fields" style="width: auto">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th><?php echo JText::_('FIELD TITLE NAME');?></th>
					<th><?php echo JText::_('FIELD TITLE TYPE');?></th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
		<?php
			if(!empty($this->fields)) {				
				for($i=0; $i<sizeof($this->fields['name']); $i++) {
						echo "<tr>\n";
						echo "\t<td>&nbsp;</td>\n";
						echo "\t<td class='key'><input type='text' name='field[name][]' value='{$this->fields['name'][$i]}'/></td>\n";
						echo "\t<td>";
							$fieldInput->type("field[type][]",  $this->fields['type'][$i]);
						echo "</td>\n";
						echo "\t<td>";
							$fieldInput->required("field[required][]", $this->fields['required'][$i]);
						echo "</td>\n";
					if($i == 0) {
						$remove	= "&nbsp;";
					} else {
						$remove	= "<input type='button' value='Remove' id='removeRow'/>";
					}
						echo "\t<td>{$remove}</td>\n";
						echo "</tr>\n";
				}
			} else {
				for($i=0; $i<sizeof($name); $i++) {
					if($i == 0) {
						$remove	= "&nbsp;";
					} else {
						$remove	= "<input type='button' value='Remove' id='removeRow'/>";
					}
					
					echo "<tr>\n";
					echo "\t<td>&sect;</td>\n";
					echo "\t<td class='key'><input type='text' name='field[name][]' value='{$name[$i]}'/></td>\n";
					echo "\t<td>";
						$fieldInput->type("field[type][]", $type[$i]);
					echo "</td>\n";
					echo "\t<td>";
						$fieldInput->required("field[required][]", $required[$i]);
					echo "</td>\n";
					echo "\t<td>{$remove}</td>\n";
					echo "</tr>\n";
				}
			}
		?>
			</tbody>
		</table>
		<?php
		if(empty($this->fields)) {
		?>
		<p>
			<?php echo JText::_('FIELDSET_INSTRUCTIONS');?>
		</p>
		<?php
		}
		?>
	</fieldset>
	
	<fieldset class="adminform">
		<legend><?php echo JText::_('FIELDSET_LEGAL');?></legend>
		<table class="admintable" id="table_legal" style="width: auto">
			<tr>
				<td class="key">Privacy Policy Link</td>
				<td><input type="text" name="privacy" id="privacy" size="75" maxlength="250" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->privacy:''; ?>"/></td>
			</tr>
			<tr>
				<td class="key">Terms &amp; Conditions Link</td>
				<td><input type="text" name="terms" id="terms" size="75" maxlength="250" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->terms:''; ?>"/></td>
			</tr>
			<tr>
				<td class="key" valign="top">Rules</td>
				<td>
					<div id="rules_text" style="width: 600px; height: 200px;"><?php if($this->sweepstake) {echo $editor->display('rules', $this->sweepstake->rules, '20%', '20%', '10', '20', true);} else {echo $editor->display('rules', '', '20%', '20%', '10', '20', true);}?></div>
				</td>
			</tr>
		</table>
	</fieldset>
	<?php
	if(!$this->user->checkACL($this->minACL)) {
	?>
	<input type="hidden" name="author" value="<?php echo $user->id;?>"/>
	<?php
	}
	?>
	<input type="hidden" name="published" value="1"/>
	<input type="hidden" name="check" value="post"/>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
	<input type="hidden" name="id" value="<?php echo (isset($this->sweepstake)) ? $this->sweepstake->id:''; ?>"/>     
	<input type="hidden" name="task" value=""/>   
</form>