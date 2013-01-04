<?php // no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
$nav = new sliverNav('positions',$this->sliver->id);

?><!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]--><?php

echo $nav->getNav();

?><form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>" id="option"/>
	<input type="hidden" id="sliver_id" name="sliver_id" value="<?php echo $this->sliver->id; ?>"/>
	<input type="hidden" id="cid" name="cid[]" value="<?php echo $this->sliver->id; ?>"/><?php
	if(count($this->videos) > 0){
	?><input type="hidden" id="video_height" name="video_height" value="<?php echo $this->videos[0]->height; ?>" />
	<input type="hidden" id="video_width" name="video_width" value="<?php echo $this->videos[0]->width; ?>" />
	<input type="hidden" id="posX" name="posX" value="<?php echo $this->videos[0]->posX; ?>" />
	<input type="hidden" id="posY" name="posY" value="<?php echo $this->videos[0]->posY; ?>" /><?php
	} ?><input type="hidden" id="sliver_height" name="sliver_height" value="<?php echo $this->sliver->sliver_height; ?>" />
	<input type="hidden" id="actionbar_height" name="actionbar_height" value="<?php echo $this->sliver->actionbar_height; ?>" />
	<input type="hidden" name="task" value="save"/><?php
	foreach($this->buttons as $button){
		?><span id="button_mirror_<?php echo $button->id; ?>" class="button_data">
				<input type="hidden" name="button_id[]" value="<?php echo $button->id; ?>" />
				<input type="hidden" name="button_name[]" value="<?php echo $button->name; ?>" />
				<input type="hidden" name="button_width[]" value="<?php echo $button->width; ?>" />
				<input type="hidden" name="button_height[]" value="<?php echo $button->height; ?>" />
				<input type="hidden" name="button_x_offset[]" value="<?php echo $button->x_offset; ?>" />
				<input type="hidden" name="button_y_offset[]" value="<?php echo $button->y_offset; ?>" />
				<input type="hidden" name="button_area[]" value="<?php echo $button->area; ?>" />
				<input type="hidden" name="button_action[]" value="<?php echo $button->action; ?>" />
				<input type="hidden" name="button_on[]" value="<?php echo $button->on; ?>" />
			</span><?php
	}
	if(isset($this->scheduledImages) && count($this->scheduledImages)){
		?><fieldset class="adminForm">
				<legend>Position</legend>
					<div id="preview_overlay" class="overlay">
						<label id='positioner_date_label' >See what the sliver will look like on:</label><input type="date" id="positioner_date" value="<?php echo $this->scheduledImages[0]->starts; ?>" />
						<script type="text/javascript"><?php
							echo 'var scheduled_images = '.json_encode($this->scheduledImages).';';
						?></script>
						<p class="instructions">Drag the video, close button and trigger into place.</p>
						<div class="overlaywrapper">
							<div class="flash">
								<img alt="sliver background image" id="flashimg" src="<?php $firstflash = $this->scheduledImages[0]; echo $firstflash->flash_uri; ?>" /><?php
								if(count($this->videos) > 0){ ?><div id="videoPositioner"><label>Video</label></div><?php }
								foreach($this->buttons as $button){
									if($button->area == 'sliver') { ?><div id="button_pos_<?php echo $button->id; ?>" class="button_positioner <?php echo $button->action; ?>" ><label><?php echo $button->name; ?></label></div><?php }
								}
								?>
							</div>
							<div class="actionbar">
								<img alt="sliver background image" id="abimg" src="<?php $firstab = $this->scheduledImages[0]; echo $firstab->actionbar_uri; ?>" />
								<?php
								foreach($this->buttons as $button){
									if($button->area == 'actionbar') { ?><div id="button_pos_<?php echo $button->id; ?>" class="button_positioner <?php echo $button->action; ?>" ><label><?php echo $button->name; ?></label></div><?php }
								}
							?></div>
						</div>
					</div>
		</fieldset><?php
	}else{
		?><h3>No Backgrounds have been set for the Sliver or Actionbar</h3><?php
	}
	?></form><fieldset class="adminForm" id="buttonUpdate"><legend>Buttons!</legend><div>
		<div class="headerRow">
			<span id="nameHeader">name</span><span id="areaHeader">area</span><span id="actionHeader">action</span>
			<span id="urlHeader">url (optional)</span><span id="onHeader">on</span><span id="widthHeader" class="advanced<?php if($this->advanced) echo ' show';?>">width</span>
			<span class="advanced<?php if($this->advanced) echo ' show';?>" id="heightHeader">height</span><span id="xHeader" class="advanced<?php if($this->advanced) echo ' show';?>">x offset</span>
			<span class="advanced<?php if($this->advanced) echo ' show';?>" id="yHeader">y offset</span>
		</div><?php
		foreach($this->buttons as $button){
			?><form action="index.php" method="post" name="buttonupdate" id="button_<?php echo $button->id; ?>"><div>
					<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
					<input type="hidden" name="sliver_id" value="<?php echo $this->sliver->id; ?>"/>
					<input type="hidden" name="cid[]" value="<?php echo $this->sliver->id; ?>"/>
					<input type="hidden" name="task" value="applyButton"/>
					<input type="hidden" name="id" class="date" value="<?php echo $button->id; ?>" />
					<span>
						<input type="text" name="name" required value="<?php echo $button->name; ?>" placeholder="Name of button" class="buttonName" />
					</span>
					<span>
						<select name="area">
							<option value="actionbar" <?php if($button->area == 'actionbar') echo 'selected="selected"';?>>actionbar</option>
							<option value="sliver" <?php if($button->area == 'sliver') echo 'selected="selected"';?>>sliver</option>
						</select>
					</span>
					<span>
						<select name="action" title="DFP Link: uses the url provided to trafficking as the click out. Raw Link: place click trackers here.">
							<option value="opensliver" <?php if($button->action == 'opensliver') echo 'selected="selected"';?> <?php if($button->area == 'sliver') echo 'disabled="disabled"';?> >Open Sliver</option>
							<option value="link" <?php if($button->action == 'link') echo 'selected="selected"';?>>Raw Link</option>
							<option value="dfplink" <?php if($button->action == 'dfplink') echo 'selected="selected"';?>>DFP Link</option>
							<option value="closesliver" <?php if($button->action == 'closesliver') echo 'selected="selected"';?>>Close Sliver</option>
						</select>
					</span>
					<span>
						<input name="url" type="url" value="<?php echo htmlspecialchars($button->url) ?>" <?php if($button->action != 'link') echo 'disabled="disabled"'; ?>/>
					</span>
					<span>
						<label>rollover</label><input type="radio" value="rollover" name="on" <?php if($button->on == 'rollover') echo 'checked="checked"';?> <?php if($button->area == 'sliver') echo 'disabled="disabled"';?> />
						<label>click</label><input type="radio" value="click" name="on" <?php if($button->on == 'click') echo 'checked="checked"';?> />
					</span>
					<span class="advanced<?php if($this->advanced) echo ' show';?>">
						<input type="number" required min="0" name="width" placeholder="pixel width eg. 4" class="validate[required,custom[integer],min[0]]" value="<?php echo $button->width; ?>" />
					</span>
					<span class="advanced<?php if($this->advanced) echo ' show';?>">
						<input type="number" required min="0" name="height" placeholder="pixel height eg. 4" class="validate[required,custom[integer],min[0]]" value="<?php echo $button->height; ?>"/>
					</span>
					<span class="advanced<?php if($this->advanced) echo ' show';?>">
						<input type="number" required name="x_offset" placeholder="pixel offset eg. 4" class="validate[required,custom[integer]]" value="<?php echo $button->x_offset; ?>"/>
					</span>
					<span class="advanced<?php if($this->advanced) echo ' show';?>">
						<input type="number" required name="y_offset" placeholder="pixel offset eg. 4" class="validate[required,custom[integer]]" value="<?php echo $button->y_offset; ?>" />
					</span>
					<span>
						<input type="submit" value="update" name="update" />
					</span>
					<span class="updateStatus"></span>
					<span class="nav">
					<span class="close"></span>
					<input type="button" class="delete" value="delete" />
				</span>
				</div></form><?php
		}
?></div></fieldset><form action="index.php" method="post" name="addButtonForm" id="addButtonForm">
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
	<input type="hidden" name="sliver_id" value="<?php echo $this->sliver->id; ?>"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->sliver->id; ?>"/>
	<input type="hidden" name="task" value="applyButton"/>
	<input type="hidden" name="id" value="<?php echo $this->newbutton->id;?>" />
	<fieldset class="adminForm add buttons" ><legend>Add Button</legend><table class="admintable">
		<tr>
			<th>name</th><th>area</th><th>action</th><th>url (optional)</th><th>on</th><th class="advanced<?php if($this->advanced) echo ' show';?>">width</th><th class="advanced<?php if($this->advanced) echo ' show';?>">height</th><th class="advanced<?php if($this->advanced) echo ' show';?>">x offset</th><th class="advanced<?php if($this->advanced) echo ' show';?>">y offset</th><th></th>
		</tr>
		<tr>
			<td><input type="text" required name="name" value="<?php echo $this->newbutton->name; ?>" placeholder="Name of button" class="buttonName" /></td>
			<td>
				<select name="area">
					<option value="actionbar" <?php if($this->newbutton->area == 'actionbar') echo 'selected="selected"'; ?>>actionbar</option>
					<option value="sliver" <?php if($this->newbutton->area == 'sliver') echo 'selected="selected"'; ?>>sliver</option>
				</select>
			</td>
			<td>
				<select name="action" id="action" title="DFP Link: uses the url provided to trafficking as the click out. Raw Link: place click trackers here.">
					<option value="opensliver" <?php if($this->newbutton->action == 'opensliver') echo 'selected="selected"'; ?> <?php if($button->area == 'sliver') echo 'disabled="disabled"';?>>Open Sliver</option>
					<option value="link" <?php if($this->newbutton->action == 'link') echo 'selected="selected"'; ?>>Raw Link</option>
					<option value="dfplink" <?php if($this->newbutton->action == 'dfplink') echo 'selected="selected"'; ?>>DFP Link</option>
					<option value="closesliver" <?php if($this->newbutton->action == 'closesliver') echo 'selected="selected"'; ?>>Close Sliver</option>
				</select>
			</td>
			<td>
				<input type="url" disabled="disabled" name="url" id="url" />
			</td>
			<td>
				<label>rollover</label><input type="radio" value="rollover" name="on" <?php if($this->newbutton->on == 'rollover') echo 'checked="checked"'; ?> <?php if($this->newbutton->area == 'sliver') echo 'disabled="disabled"';?> />
				<label>click</label><input type="radio" value="click" name="on" <?php if($this->newbutton->on == 'click') echo 'checked="checked"'; ?>/>
			</td>
			<td class="advanced<?php if($this->advanced) echo ' show';?>">
				<input type="number" min="0" required name="width" id="width" placeholder="pixel width eg. 4" class="validate[required,custom[integer],min[0]]" value="<?php echo $this->newbutton->width; ?>" />
			</td>
			<td class="advanced<?php if($this->advanced) echo ' show';?>">
				<input type="number" min="0" required name="height" id="height" placeholder="pixel height eg. 4" class="validate[required,custom[integer],min[0]]" value="<?php echo $this->newbutton->height; ?>" />
			</td>
			<td class="advanced<?php if($this->advanced) echo ' show';?>">
				<input type="number" required name="x_offset" id="x_offset" placeholder="pixel offset eg. 4" class="validate[required,custom[integer]]" value="<?php echo $this->newbutton->x_offset; ?>" />
			</td>
			<td class="advanced<?php if($this->advanced) echo ' show';?>">
				<input type="number" required name="y_offset" id="y_offset" placeholder="pixel offset eg. 4" class="validate[required,custom[integer]]" value="<?php echo $this->newbutton->y_offset; ?>" />
			</td>
			<td>
				<input type="submit" name="submit" value="Add" id="addButtonSubmit" />
			</td>
		</tr>
	</table></fieldset>
	<a href="#" id="advanced"><?php echo $this->advanced?'Basic Options':'Advanced Options';?></a>
</form>
