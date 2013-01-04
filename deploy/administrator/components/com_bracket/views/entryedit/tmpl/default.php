<?php 
	defined('_JEXEC') or die();
?>
	<link rel="stylesheet" href="../administrator/templates/khepri/css/template.css" type="text/css">
	<style type="text/css">
		td {
			font-size: 11px !important;
		}
	</style>
	<h2>Edit Entry - <?php echo $this->entryData[0]['name'] ?></h2>
	<form method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
		<fieldset class="adminform">
			<table class="admintable">
				<tr>
					<td class="key">Name</td>
					<td><input type="text" name="name" size="64" value="<?php echo $this->entryData[0]['name'] ?>" /></td>
				</tr>
				<tr>
					<td class="key">Description</td>
					<td><input type="text" name="description" size="64" value="<?php echo $this->entryData[0]['description'] ?>" /></td>
				</tr>
				<tr>
					<td class="key">Current General image</td>
					<?php if ($this->entryData[0]['image_relpath'] != '') {?>
						<td><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->entryData[0]['bracket_id'] ?>/<?php echo $this->entryData[0]['image_relpath']?>" style="max-width: 100px; max-height: 100px;"/></td>
					<?php } else { echo "<td>Not Set</td>";}?>
				</tr>
				<tr>
					<td class="key">Upload General image</td>
					<td><input type="file" name="image_relpath" size="64" /></td>
				</tr>
				<?php if($_GET['oneImage'] == 'false') { ?>
					<tr>
						<td class="key">Current Finalist image</td>
						<?php if ($this->entryData[0]['finalist_relpath'] != '') {?>
						<td><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->entryData[0]['bracket_id'] ?>/<?php echo $this->entryData[0]['finalist_relpath']?>" style="max-width: 100px; max-height: 100px;"/></td>
						<?php } else { echo "<td>Not Set</td>";}?>
					</tr>
					<tr>
						<td class="key">Upload Finalist image</td>
						<td><input type="file" name="finalist_relpath" size="64" /></td>
					</tr>
					<tr>
						<td class="key">Current Winner image</td>
						<?php if ($this->entryData[0]['winner_relpath'] != '') {?>
							<td><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->entryData[0]['bracket_id'] ?>/<?php echo $this->entryData[0]['winner_relpath']?>" style="max-width: 100px; max-height: 100px;"/></td>
						<?php } else { echo "<td>Not Set</td>";}?>
					</tr>
					<tr>
						<td class="key">Upload Winner image</td>
						<td><input type="file" name="winner_relpath" size="64" /></td>
					</tr>
					<tr>
						<td class="key">Current Hover image</td>
						<?php if ($this->entryData[0]['hover_relpath'] != '') {?>
							<td><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/assets/components/com_bracket/<?php echo $this->entryData[0]['bracket_id'] ?>/<?php echo $this->entryData[0]['hover_relpath']?>" style="max-width: 100px; max-height: 100px;"/></td>
						<?php } else { echo "<td>Not Set</td>";}?>
					</tr>
					<tr>
						<td class="key">Upload Hover image</td>
						<td><input type="file" name="hover_relpath" size="64" /></td>
					</tr>
				<?php } ?>
			</table>
		</fieldset>
		<input type="hidden" name="id" value="<?php echo $this->entryData[0]['id'] ?>" />
		<input type="hidden" name="posititon" value="<?php echo $this->entryData[0]['position'] ?>" />
		<input type="hidden" name="cid" value="<?php echo $this->entryData[0]['bracket_id'] ?>" />
		<input type="hidden" name="task" value="entryupdate" />
	</form>
