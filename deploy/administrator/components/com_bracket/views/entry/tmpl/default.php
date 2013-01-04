<?php 
	defined('_JEXEC') or die();
	$document = &JFactory::getDocument();
	$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
	$document->addScript("components".DS."com_bracket".DS."js".DS."jquery.tablednd_0_5.js");
	
	if ($this->bracketDetails['use_one_image'] == "1") {
		$oneImage = 'true';
	} else {
		$oneImage = 'false';
	}
?>
<style type="text/css">
tr.rowDrag td {
	background-color: #ccc !important;
	color: #000;
	font-weight: bold;
}
td.dragHandle {
	color: #000;
	background-color: #eaeaea !important;
	font-size: 14px;
	font-weight: bold;
}
.dragHandle:hover {
	cursor: move;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("#table-1").tableDnD({
    	onDragClass: "rowDrag",
    	//dragHandle: "dragHandle",
    	onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var newOrder = new Array();
            for (var i=0; i<rows.length; i++) {
                newOrder[i] = jQuery("#"+rows[i].id).find("td").eq(0).html();
                //debugStr += "Entry ID:  " + j + " = " + jQuery("#"+rows[i].id).find("td").eq(0).html() + " Position: " + rows[i].id+"<br>";
                //j++;
            }
	        //$('#debugArea').html(debugStr);
	        //alert(newOrder);
	        //jQuery.post("index.php?controller=bracket&format=raw&option=com_bracket&task=entrypositionupdate", {positions: newOrder}, function(){alert('Success');});
	        var bracket_id = <?php echo $_GET['cid'] ?>;
	        jQuery.ajax({
	        	type: 'POST',
	        	url: 'index.php?controller=bracket&format=raw&option=com_bracket&task=entrypositionupdate',
	        	data: {positions: newOrder, cid: bracket_id},
	        	success: function(){window.location.href = 'index.php?option=com_bracket&task=entry&cid=' + bracket_id;}
	        });
	    }
    });   
});
</script>
<div id="debugArea"></div>
<form method="POST" name="adminForm" id="adminForm">	
<h2>Bracket Entries for <?php echo $this->bracketDetails['name'] ?> - <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/index.php?option=com_bracket&view=bracket&Itemid=5&format=raw&cid=<?php echo $this->bracketDetails['id']; ?>" target="_blank">Preview Link</a></h2>
<p>Select an entry below to edit its details and images. To change the position of an entry, select its position under the <strong>Position</strong> column and drag then drop it to the desired position.</p>
<?php if ($oneImage == "true") { ?>
	<p><strong>Note:</strong> This bracket uses one image only per entry. <a href="<?php echo JRoute::_('index.php?option=com_bracket&task=edit&cid='.$this->bracketDetails['id']) ?>">Click here</a> to edit bracket settings to allow multiple images.</p>
<?php } ?>
<fieldset class="adminform">
	<table class="adminlist" id="table-1">
	<thead>
		<tr>
			<th width="5%">ID</th>
			<th width="5%">Position</th>
			<th width="20%">Name</th>
			<th>Description</th>
			<th width="10%">General Image</th>
			<th width="10%">Finalist Image</th>
			<th width="10%">Winner Image</th>
			<th width="10%">Hover Image</th>
			<th width="10%">Reset Entry</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$b = 1;
		for ($a = 0; $a < 16; $a++) {
			if ($this->bracketData[$a]['name'] == "") { ?>
			<tr id ="<?php echo $b ?>">
				<td align="center"><?php echo $this->bracketData[$a]['id'] ?></td>
				<td class="dragHandle" align="center"><?php echo $this->bracketData[$a]['position'] ?></td>
				<td colspan="7" align="center"><a href="<?php echo JRoute::_('index.php?option=com_bracket&task=entryedit&eid='.$this->bracketData[$a]['id']).'&oneImage='.$oneImage ?>">Not Set - Click here to enter specify entry information and upload images.</a></td>
			</tr>
			
		<?php } else { ?>
			<tr id ="<?php echo $b ?>">
				<td align="center"><?php echo $this->bracketData[$a]['id'] ?></td>
				<td class="dragHandle" align="center"><?php echo $this->bracketData[$a]['position'] ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_bracket&task=entryedit&eid='.$this->bracketData[$a]['id']).'&oneImage='.$oneImage ?>"><?php echo $this->bracketData[$a]['name'] ?></a></td>
				<td><?php echo $this->bracketData[$a]['description'] ?></td>
				<?php if ($this->bracketData[$a]['image_relpath'] != '') {?>
					<td align="center"><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->bracketData[$a]['bracket_id']."/".$this->bracketData[$a]['image_relpath'] ?>" style="max-width:25px;max-height:25px;" /></td>
				<?php } else { echo "<td align=\"center\">Not Set</td>";}?>
				<?php if ($this->bracketDetails['use_one_image'] == "1") { ?>
					<td align="center" colspan="3">N/A</td>
				<?php } else { ?>
					<?php if ($this->bracketData[$a]['finalist_relpath'] != '') {?>
						<td align="center"><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->bracketData[$a]['bracket_id']."/".$this->bracketData[$a]['finalist_relpath'] ?>" style="max-width:25px;max-height:25px;" /></td>
					<?php } else { echo "<td align=\"center\">Not Set</td>";}?>
					<?php if ($this->bracketData[$a]['winner_relpath'] != '') {?>
						<td align="center"><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->bracketData[$a]['bracket_id']."/".$this->bracketData[$a]['winner_relpath'] ?>" style="max-width:25px;max-height:25px;" /></td>
					<?php } else { echo "<td align=\"center\">Not Set</td>";}?>
					<?php if ($this->bracketData[$a]['hover_relpath'] != '') {?>
						<td align="center"><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->bracketData[$a]['bracket_id']."/".$this->bracketData[$a]['hover_relpath'] ?>" style="max-width:25px;max-height:25px;" /></td>
					<?php } else { echo "<td align=\"center\">Not Set</td>";}?>
				<?php } ?>
				<td align="center"><a href="<?php echo JRoute::_('index.php?option=com_bracket&task=resetentry&eid='.$this->bracketData[$a]['id'].'&cid='.$this->bracketData[$a]['bracket_id']) ?>">Reset Entry</a></td>
			</tr>
		<?php 
			}
			$b++;
		}	
		?>
	</tbody>
	</table>
</fieldset>
	<input type="hidden" name="boxchecked" value="" />
	<input type="hidden" name="task" value="" />
</form>

