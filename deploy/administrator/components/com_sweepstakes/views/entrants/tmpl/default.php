<?php
	defined('_JEXEC') or die();

	JHTML::_('behavior.mootools');	
	//Grabs serialized form labels
	$sweepsModel	= $this->getModel('sweeps');
	$fields			= $sweepsModel->getFields($this->entrants[0]->sid);
	$colspan		= sizeof($fields['name']) + 3;
?>

<script type="text/javascript">
function tableOrdering( order, dir, task ) {
    var form = document.adminForm;
	    form.filter_order.value 	= order;
	    form.filter_order_Dir.value = dir;
	    document.adminForm.submit( task );
}
</script>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="POST" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th colspan="<?php echo $colspan;?>"><a href='<?php echo JRoute::_("index.php?option=com_sweepstakes&task=displayRandom&sid={$this->sid}");?>'><?php echo JText::_("MANAGER_CELL_WINNER");?></a> | <a href='<?php echo JRoute::_("index.php?option=com_sweepstakes&task=displayExcel&sid={$this->sid}&format=raw");?>'><?php echo JText::_('DOWNLOAD EXCEL');?></a></th>
			</tr>
			<tr>
				<th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->entrants); ?>)" /></th>
				<?php
				for($i=0; $i < sizeof($fields['name']); $i++) {
					echo "<th>".$fields['name'][$i]."</th>\n";
				}
				?>
				<th><?php echo JText::_('HEADER TIMESTAMP');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$k	= 0;
			$i	= 0;
			foreach($this->entrants as $row) {
				$checked	= JHTML::_('grid.id', $i, $row->uid);
			
				echo "<tr class='row{$k}'>\n";
				echo "<td>{$checked}</td>\n";
				
				$entrantData	= unserialize($row->fields);
				foreach($entrantData as $key=>$value) {
					if($value != null) {
						$value	= $value;
					} else {
						$value	= "N/A";
					}
						echo "<td align='center'>{$value}</td>";
				}
				echo "<td align='center'>".JHTML::date($row->timestamp, '%D %r', JText::_('DATE_FORMAT_LC'))."</td>\n";
				echo "</tr>\n";
				
				$k	= 1-$k;
				$i++;
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<?php echo $colspan;?>"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
	
	<input type="hidden" name="check" value="post"/>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>    
	<input type="hidden" name="task" value="displayEntrant"/> 
	<input type="hidden" name="sid" value="<?php echo $this->sid;?>"/>
	<input type="hidden" name="removeType" value="entrants"/>
	<input type="hidden" name="boxchecked" value="0"/>
</form>