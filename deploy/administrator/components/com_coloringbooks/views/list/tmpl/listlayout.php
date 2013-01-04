<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="POST" name="adminForm">
<table class="adminlist">
	<thead>
		<tr>
			<th width="10">ID</th>
			<th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->coloringBooks); ?>)" /></th>
			<th>Coloring Book</th>
			<?php if($this->displayUsers){ ?><th>Owner</th><?php } ?>
			<th>Feed/Embed</th>
		</tr>               
	</thead>
	<tbody>
		<?php
		$k = 0;
		$i = 0;
		foreach ($this->coloringBooks as $row){
		$checked = JHTML::_('grid.id', $i, $row->id);
		$link = JRoute::_( 'index.php?option='.JRequest::getVar('option').'&task=edit&cid[]='. $row->id.'&hidemainmenu=1' );
		$uri = JURI::getInstance();
		$feed = JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&view=api&format=raw&cid='.$row->id);?>
		<tr class="<?php echo "row$k";?>">
			<td><?php echo $row->id;?></td>
			<td><?php echo $checked; ?></td>
			<td><a href="<?php echo $link;?>"><?php echo $row->name;?></a></td>
			<?php if($this->displayUsers){ ?><td><?php echo htmlspecialchars($row->owner); ?></td><?php } ?>
			<td><a href="<?php echo htmlspecialchars($feed); ?>">API</a>|<a href="#" class="embed_link" rel="#embed_<?php echo htmlspecialchars($row->id)?>">Embed</a></td>
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
<?php foreach ($this->coloringBooks as $row){
	$uri = JURI::getInstance();
	$feed = JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&view=embed&format=raw&cid='.$row->id); ?>
<div id="embed_<?php echo $row->id ?>" class="embed_code">
<div class="caption">Copy the text below and insert it into any webpage</div><textarea class="code">
<?php echo htmlspecialchars('<iframe src="'.$feed.'" width="'.$row->embed_width.'" height="'.$row->embed_width.'" >Your browser does not support iframes</iframe>', ENT_QUOTES);  ?>
</textarea></div>
<?php }