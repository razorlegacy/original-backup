<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="POST" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th width="10">ID</th>
			<th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->slivers); ?>)" /></th>
			<th>Sliver</th>
			<?php if($this->displayUsers){ ?><th>Owner</th><?php } ?>
			<th>link for 47x47 DFP config</th>
			<th>Bust Cache</th>
		</tr>
	</thead>
	<tbody><?php
		$k = 0;
		$i = 0;
		$uri = JURI::getInstance();
		$embed_link_base = JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&task=display&format=raw&view=embed');
		foreach ($this->slivers as $row){
		$checked = JHTML::_('grid.id', $i, $row->id);
		$link = JRoute::_( 'index.php?option='.JRequest::getVar('option').'&task=editGeneral&cid[]='. $row->id );
		?><tr class="<?php echo "row$k";?>">
			<td><?php echo $row->id;?></td>
			<td><?php echo $checked; ?></td>
			<td><a href="<?php echo $link;?>"><?php echo $row->name;?></a></td>
			<?php if($this->displayUsers){ ?><td><?php echo htmlspecialchars($row->owner); ?></td><?php } ?>
			<td><?php echo $embed_link_base.'&id='.$row->id;?></td>
			<td><a href="http://sitebuilder.atomiconline.com/utilities/akamai_content_refresh.php?url=<?php echo urlencode($embed_link_base.'&id='.$row->id); ?>">Bust Cache</a></td>

		</tr>
		<?php
		$k = 1 - $k;
		$i++;
		}
		?>
	</tbody>
</table>

<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="hidemainmenu" value="0"/>
</form>
