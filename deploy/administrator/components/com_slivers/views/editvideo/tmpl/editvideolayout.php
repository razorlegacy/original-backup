<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo $this->video->id? 'Edit': 'Add';?> Video</h1>
<form action="index.php" method="post" name="video" id="video" class="video">
		<table class="admintable">
		<tr>
			<td class="key">Name</td>
			<td>
			<input required type="text" name="name" class="name validate[required]" value="<?php echo $this->video->name; ?>" id="<?php echo 'name'.$this->video->id ?>"/>
			</td>
		</tr>
		<tr title="Date to first show the video on.">
			<td class="key">Live Date</td>
			<td>
				<input required type="date" name="starts" class="date" value="<?php echo $this->video->starts; ?>"/>
			</td>
		</tr>
		<tr class="spacer"><td></td><td></td></tr>
		<tr class="advanced<?php if($this->advanced) echo ' show';?>">
			<td class="key">height</td>
			<td>
				<input type="number" required min="0" placeholder="height in pixels eg. 200" name="height" id="video_height"  maxlength="5" class="validate[required,custom[integer],min[0]]" value="<?php
					echo htmlspecialchars($this->video->height);
				?>" />
			</td>
		</tr>
		<tr class="advanced<?php if($this->advanced) echo ' show';?>">
			<td class="key">width</td>
			<td>
				<input type="number" required min="0" placeholder="width in pixels eg. 200" name="width" id="video_width"  maxlength="5" class="validate[required,custom[integer],min[0]]" value="<?php
					echo htmlspecialchars($this->video->width);
				?>" />
			</td>
		</tr>
		<tr class="advanced<?php if($this->advanced) echo ' show';?>" title="position relative to the top left of the background image.">
			<td class="key">X offset</td>
			<td>
				<input type="number" required placeholder="left offset in pixels eg. 200" name="posX" id="posX"  maxlength="9" class="validate[required,custom[integer]]" value="<?php
					echo htmlspecialchars($this->video->posX);
				?>" />
			</td>
		</tr>
		<tr class="advanced<?php if($this->advanced) echo ' show';?>" title="position relative to the top left of the background image.">
			<td class="key">Y offset</td>
			<td>
				<input type="number" required placeholder="top offset in pixels eg. 200" name="posY" id="posY"  maxlength="9" class="validate[required,custom[integer]]" value="<?php
					echo htmlspecialchars($this->video->posY);
				?>" />
			</td>
		</tr>
		<tr class="spacer advanced<?php if($this->advanced) echo ' show';?>"><td></td><td></td></tr>
		<tr>
			<td class="key">Auto Play Video</td>
			<td>
				<input type="checkbox" name="autoPlay" id="autoPlay"  value="1" <?php if($this->video->autoPlay) echo 'checked="checked"'?> />
			</td>
		</tr>
		<tr>
			<td class="key">Start video Muted</td>
			<td>
				<input type="checkbox" name="startMuted" id="startMuted"  value="1" <?php if($this->video->startMuted) echo 'checked="checked"'?> />
			</td>
		</tr>
		<tr>
			<td class="key">Unmute On Rollover</td>
			<td>
				<input type="checkbox" name="unmuteOnRollover" id="unmuteOnRollover"  value="1" <?php if($this->video->unmuteOnRollover) echo 'checked="checked"'?> />
			</td>
		</tr>
		<tr>
			<td class="key">Volume</td>
			<td>
				<input type="range" required min="0" max="100" placeholder="volume level 0-100" name="volume" id="volume"  maxlength="3" class="validate[required,custom[integer],min[0],max[100]]" value="<?php
					echo htmlspecialchars($this->video->volume);
				?>" />
			</td>
		</tr>
		<tr class="spacer"><td></td><td></td></tr>
		<tr title="Log into springboard and paste the embed code of the video or playlist here.">
			<td class="key">springboard embed code</td>
			<td>
				<textarea name="embed_code" id="embed_code" placeholder="Paste springboard embed code here. Use the widget sidh015 sliver 2.0." class="validate[required]"><?php
					echo htmlspecialchars($this->video->embed_code);
			?></textarea>
			</td>
			<td><img src="/administrator/components/com_slivers/images/Springboard-CMS-Videos.png" /></td>
		</tr>
	</table><input type="hidden" name="id" value="<?php echo $this->video->id; ?>" /><input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" id="option"/>
	<input type="hidden" id="sliver_id" name="sliver_id" value="<?php echo $this->sliver_id; ?>"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->sliver_id; ?>"/>
	<input type="hidden" name="task" value="saveVideo"/>
	<a href="#" id="advanced"><?php echo $this->advanced?'Basic Options':'Advanced Options';?></a>
	<input type="submit" name="submit" value="save" />
</form>
