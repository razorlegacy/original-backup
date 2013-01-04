<?php defined('_JEXEC') or die();?>
<form method="POST" name="adminForm" id="adminForm">	
	<table class="adminlist">
		<thead>
			<tr>
				<th width="5%">ID</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" /></th>
				<th>Bracket Name</th>
				<th>Bracket Entries</th>
				<th>Preview Link</th>
				<th align="center">Starting Date</th>
				<th align="center">Ending Date</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ($this->bracketList) {
			$numBrackets = count($this->bracketList);
			for ($i = 0; $i < $numBrackets; $i++) {
				$row = $this->bracketList[$i];
				JFilterOutput::objectHtmlSafe($row);
				$link = 'index.php?option=com_bracket&task=edit&cid=' . $row['id'];
				$entriesLink = 'index.php?option=com_bracket&task=entry&cid=' . $row['id'];
				//$link = 'index.php?option=com_tag&controller=term&task=edit&cid[]='. $row->id ;
				$checked = JHTML::_('grid.id', $i, $row['id'] );
				?>
				<tr>
					<td align="center"><?php echo $row['id']; ?></td>
					<td><?php echo $checked; ?></td>
					<td><a href="<?php echo JRoute::_( $link ); ?>"> <?php echo $row['name']?$row['name']:'(no name)'; ?></a></td>
					<td align="center"><a href="<?php echo JRoute::_( $entriesLink ); ?>">Edit Bracket Entries</a></td>
					<td align="center"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/index.php?option=com_bracket&view=bracket&Itemid=5&format=raw&cid=<?php echo $row['id']; ?>" target="_blank">Preview Link</a></td>
					<td align="center"><?php echo $row['start_date']; ?></td>
					<td align="center"><?php echo $row['end_date']; ?></td>
				</tr>
		<?php
			}
		} else { ?>
			<tr>
				<td colspan="7" align="center"><?php echo JText::_('No brackets are currently configured'); ?></td>
			</tr>
	<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="boxchecked" value="" />
	<input type="hidden" name="task" value="" />
</form>
			