<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?><!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]-->
<?php if(isset($this->nav)) echo $this->nav->getNav(); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div id="sliverSettings" class="<?php echo $this->sliver->id ? 'edit' :'add' ?>">
			<fieldset class="adminform">
				<legend>Sliver Settings</legend>
				<table class="admintable">
					<tr>
						<td class="key">Sliver Name</td>
						<td>
							<input type="text" name="name" id="name" maxlength="255" value="<?php
								echo htmlspecialchars($this->sliver->name);
							?>" />
						</td>
					</tr>
					<tr>
						<td class="key">Owner</td>
						<td>
							<select name="owner" id="owner" class="validate[required]" required><?php
								foreach($this->users as $user){
									?><option value="<?php echo $user->id; ?>" <?php if($this->sliver->owner_id == $user->id) echo 'selected="selected"'?>><?php
											echo htmlspecialchars($user->name);
										?></option><?php
								}
							?></select>
						</td>
					</tr>
					<tr class="spacer"><td></td><td></td></tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Tween Site Background</td>
						<td>
							<input type="checkbox" name="tweenBG" id="tweenBG" value="1" <?php if($this->sliver->tweenBG) echo 'checked="checked"'?> />
						</td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="This is the larger part of the sliver Unit.">
						<td class="key">Sliver Height</td>
						<td>
							<input type="number" min="0" name="sliver_height" id="sliver_height" maxlength="5" class="validate[required,custom[integer],min[0]]" placeholder="pixel height excludeing actionbar" value="<?php
								echo htmlspecialchars($this->sliver->sliver_height);
							?>" />
						</td>
					</tr>
					<tr title="This is the color displayed off to the sides where there is no image.">
						<td class="key">Sliver Background Color</td>
						<td>
							<input type="color" required name="sliver_color" id="sliver_color" maxlength="127" class="validate[required,custom[hexColor]]" value="<?php
								echo htmlspecialchars($this->sliver->sliver_color);
							?>" placeholder="around image eg. '#000000'" />
						</td>
					</tr>
					<tr title="Causes the sliver start out opened on the page.">
						<td class="key">Auto open sliver</td>
						<td>
							<input type="checkbox" name="autoOpen" id="autoOpen" value="1" <?php if($this->sliver->autoOpen) echo 'checked="checked"'?> />
						</td>
					</tr>
					<tr title="How long the sliver takes to autoclose.">
						<td class="key">Auto close sliver</td>
						<td>
							<input type="number" name="autoClose" id="autoClose" maxlength="4" value="<?php echo $this->sliver->autoClose; ?>" class="milliseconds validate[required,custom[number],min[0]]" />
						</td>
						<td class="seconds"><?php echo $conv = $this->sliver->autoClose / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second';  ?></td>
					</tr>
					<tr class="spacer"><td></td><td></td></tr>
					<tr "This is the will help you find the unit's metrics in Google Analyitics.">
						<td class="key">Campaign name for GA</td>
						<td>
							<input type="text" name="prefix" id="prefix" maxlength="255" required class="validate[required]" value="<?php
								echo htmlspecialchars($this->sliver->prefix);
							?>" />
						</td>
					</tr>
					<tr class="spacer"><td></td><td></td></tr>
					<tr>
						<td class="key">Sliver Open Animation</td>
						<td>
							<select name="sliv_open_animation" id="sliv_open_animation" class="validate[required]" required><?php
								foreach($this->animations as $animation_name){
									?><option value="<?php echo $animation_name; ?>" <?php if($this->sliver->sliv_open_animation == $animation_name) echo 'selected="selected"'?>><?php
											echo htmlspecialchars($animation_name);
										?></option><?php
								}
							?></select>
						</td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="How long the animation takes to complete">
						<td class="key">open animation length</td>
						<td><input type="number" min="0" step="10" value="<?php echo $this->sliver->sliv_open_duration; ?>" name="sliv_open_duration" id="sliv_open_duration" class="milliseconds validate[required,custom[number],min[0]]" required /></td><td class="seconds"><?php echo $conv = $this->sliver->sliv_open_duration / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second';  ?></td>
					</tr>
					<tr>
						<td class="key">Sliver Close Animation</td>
						<td>
							<select name="sliv_close_animation" id="sliv_close_animation" class="validate[required]" required><?php
								foreach($this->animations as $animation_name){
									?><option value="<?php echo $animation_name; ?>" <?php if($this->sliver->sliv_close_animation == $animation_name) echo 'selected="selected"'?>><?php
											echo htmlspecialchars($animation_name);
										?></option><?php
								}
							?></select>
						</td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="How long the animation takes to complete">
						<td class="key">close animation length</td>
						<td><input type="number" min="0" step="10" value="<?php echo $this->sliver->sliv_close_duration; ?>" name="sliv_close_duration" id="sliv_close_duration" class="milliseconds validate[required,custom[number],min[0]]" required /></td><td class="seconds"><?php echo $conv = $this->sliver->sliv_close_duration / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second'; ?></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="Milliseconds between each frame of the animation.">
						<td class="key">resolution</td>
						<td><input type="number" min="15" step="1" value="<?php echo $this->sliver->animation_resolution; ?>" name="animation_resolution" id="animation_resolution" class="validate[required,custom[integer],min[15]]" required /></td><td id="frames_per_second"><?php echo 1000 / $this->sliver->animation_resolution;?> fps</td>
					</tr>
					<tr class="spacer"><td></td><td></td></tr>
					<tr title="Where the playlist will be displayed relative to the video">
						<td class="key">playlist position</td>
						<td>
							<select name="playlist_position" id="playlist_position" class="validate[required]" required><?php
								foreach($this->playlist_positions as $playlist_position){
									?><option value="<?php echo $playlist_position; ?>" <?php if($this->sliver->playlist_position == $playlist_position) echo 'selected="selected"'?>><?php
											echo htmlspecialchars($playlist_position);
										?></option><?php
								}
							?></select>
						</td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail max height</td>
						<td><input type="number" min="0" step="1" value="<?php echo $this->sliver->playlist_thumb_max_height; ?>" name="playlist_thumb_max_height" id="playlist_thumb_max_height" class="validate[required,custom[integer],min[0]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail max width</td>
						<td><input type="number" min="0" step="1" value="<?php echo $this->sliver->playlist_thumb_max_width; ?>" name="playlist_thumb_max_width" id="playlist_thumb_max_width" class="validate[required,custom[integer],min[0]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail shadow offset x</td>
						<td><input type="number" step="1" value="<?php echo $this->sliver->playlist_thumb_shadow_offset_x; ?>" name="playlist_thumb_shadow_offset_x" id="playlist_thumb_shadow_offset_x" class="validate[required,custom[integer]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail shadow offset Y</td>
						<td><input type="number" step="1" value="<?php echo $this->sliver->playlist_thumb_shadow_offset_y; ?>" name="playlist_thumb_shadow_offset_y" id="playlist_thumb_shadow_offset_y" class="validate[required,custom[integer]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail shadow blur radius</td>
						<td><input type="number" min="0" step="1" value="<?php echo $this->sliver->playlist_thumb_shadow_blur_radius; ?>" name="playlist_thumb_shadow_blur_radius" id="playlist_thumb_shadow_blur_radius" class="validate[required,custom[integer],min[0]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail shadow spread radius</td>
						<td><input type="number" step="1" value="<?php echo $this->sliver->playlist_thumb_shadow_spread_radius; ?>" name="playlist_thumb_shadow_spread_radius" id="playlist_thumb_shadow_spread_radius" class="validate[required,custom[integer]]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
						<td class="key">Thumbnail shadow color</td>
						<td><input type="color" value="<?php echo $this->sliver->playlist_thumb_shadow_color; ?>" name="playlist_thumb_shadow_color" id="playlist_thumb_shadow_color" class="validate[required]" required /></td>
					</tr>
					<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="Color to outline the thumbnail that is either currently playing or the mouse is hovering over.">
						<td class="key">Thumbnail active outline color</td>
						<td><input type="color" value="<?php echo $this->sliver->playlist_thumb_active_outline_color; ?>" name="playlist_thumb_active_outline_color" id="playlist_thumb_active_outline_color" class="validate[required]" required /></td>
					</tr>
				</table>
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>" id="option"/>
				<input type="hidden" id="id" name="id" value="<?php echo $this->sliver->id; ?>"/>
				<input type="hidden" name="cid[]" value="<?php echo $this->sliver->id; ?>"/>
				<input type="hidden" name="sliver_id" id="sliver_id" value="<?php echo $this->sliver->id; ?>"/>
				<input type="hidden" name="task" value="save"/>

		</fieldset>
	</div><div id="actionbarSettings">
		<fieldset class="adminform">
			<legend>Action Bar</legend>
			<table class="admintable">
				<tr class="advanced<?php if($this->advanced) echo ' show'; ?>">
					<td class="key">Action Bar Height</td>
					<td>
						<input type="number" min="0" required placeholder="height in pixels eg. 200" name="actionbar_height" id="actionbar_height" maxlength="5" class="validate[required,custom[integer],min[0]]" value="<?php
							echo htmlspecialchars($this->sliver->actionbar_height);
						?>" />
					</td>
				</tr>
				<tr title="Color to display when there isn't an image (on the sides).">
					<td class="key">Action Bar Background Color</td>
					<td>
						<input type="color" required placeholder="background color eg. #AAA" name="actionbar_color" id="actionbar_color" maxlength="127" class="validate[required,custom[hexColor]]" value="<?php
							echo htmlspecialchars($this->sliver->actionbar_color);
						?>" />
					</td>
				</tr>
				<tr title="Leave unchecked to have the actionbar always display. Check to hide when the sliver opens">
					<td class="key">Actionbar hides when Sliver Opens</td>
					<td>
						<input type="checkbox" name="abdisappear" id="abdisappear" value="1" <?php if($this->sliver->abdisappear) echo 'checked="checked"'?> />
					</td>
				</tr>
				<tr>
					<td class="key">Open Animation</td>
					<td>
						<select name="ab_open_animation" id="ab_open_animation" class="validate[required]" required><?php
							foreach($this->animations as $animation_name){
								?><option value="<?php echo $animation_name; ?>" <?php if($this->sliver->ab_open_animation == $animation_name) echo 'selected="selected"'?>><?php
										echo htmlspecialchars($animation_name);
									?></option><?php
							}
						?></select>
					</td>
				</tr>
				<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="How long the animation takes to complete">
					<td class="key">open animation length</td>
					<td><input type="number" min="0" step="10" value="<?php echo $this->sliver->ab_open_duration; ?>" name="ab_open_duration" id="ab_open_duration" class="milliseconds validate[required,custom[number],min[0]]" /></td><td class="seconds"><?php echo $conv = $this->sliver->ab_open_duration / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second'; ?></td>
				</tr>
				<tr>
					<td class="key">Close Animation</td>
					<td>
						<select name="ab_close_animation" id="ab_close_animation" class="validate[required]" required><?php
							foreach($this->animations as $animation_name){
								?><option value="<?php echo $animation_name; ?>" <?php if($this->sliver->ab_close_animation == $animation_name) echo 'selected="selected"'?>><?php
										echo htmlspecialchars($animation_name);
									?></option><?php
							}
						?></select>
					</td>
				</tr>
				<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="How long the animation takes to complete">
					<td class="key">close animation length</td>
					<td><input type="number" min="0" step="10" value="<?php echo $this->sliver->ab_close_duration; ?>" name="ab_close_duration" id="ab_close_duration" class="milliseconds validate[required,custom[number],min[0]]"/></td><td class="seconds"><?php echo $conv = $this->sliver->ab_close_duration / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second'; ?></td>
				</tr>
				<tr class="advanced<?php if($this->advanced) echo ' show'; ?>" title="Milliseconds to wait before beginning the open animation.">
					<td class="key">open animation delay</td>
					<td><input type="number" min="0" step="1" value="<?php echo $this->sliver->ab_open_delay; ?>" name="ab_open_delay" id="ab_open_delay" class="milliseconds validate[required,custom[integer],min[0]]"/></td><td class="seconds"><?php echo $conv = $this->sliver->ab_open_delay / 1000; echo $conv > 1 || $conv < 1 ? ' seconds':' second'; ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<a href="#" id="advanced"><?php echo $this->advanced?'Basic Options':'Advanced Options';?></a>
</form>
