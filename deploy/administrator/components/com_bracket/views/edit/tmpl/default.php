<?php defined('_JEXEC') or die();

JHTML::_('behavior.calendar');
$document = &JFactory::getDocument();
$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
$document->addScript("http://plugins.meta100.com/mcolorpicker/javascripts/mColorPicker_min.js");
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('input[type="color"]').bind('colorpicked', function () {});
		jQuery('#entry-boxes .admintable, #compare-screen .admintable, #winner-screen .admintable, #intro-screen .admintable').hide();
		jQuery('#entry-boxes h2').click(function(){
			jQuery('#entry-boxes .admintable').toggle();
			return false;
		});
		jQuery('#compare-screen h2').click(function(){
			jQuery('#compare-screen .admintable').toggle();
			return false;
		});
		jQuery('#winner-screen h2').click(function(){
			jQuery('#winner-screen .admintable').toggle();
			return false;
		});
		jQuery('#intro-screen h2').click(function(){
			jQuery('#intro-screen .admintable').toggle();
			return false;
		});
   	});
</script>
<style type="text/css">
form h2 {
	border-bottom: 1px solid #ccc;
	color: blue;
}
form h2 span {
	font-size: 12px;
    font-weight: normal;
    margin-left: 15px;
}
</style>
<h2>Edit Bracket</h2>
<form method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
<fieldset class="adminform">
	<h2>Bracket Settings and Styles</h2>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Bracket Information</h3></td>
		</tr>
		<tr>
			<td class="key">Bracket name</td>
			<td><input type="text" name="bracket_name"  size="40" value="<?php echo $this->name ?>"/></td>
		</tr>
		<tr>
			<td class="key">GA tracking ID</td>
			<td><input type="text" name="ga_tracking_id" size="40" value="<?php echo $this->ga_tracking_id ?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Bracket Image Backgrounds</h3></td>
		</tr>
		<tr>
			<td class="key">Background Color</td>
			<td><input type="color" value="<?php echo $this->background_color ?>" data-hex="true" name="background_color" id="background_color"/></td>
		</tr>
		<tr>
			<td class="key">Current Background Image (Thumbnail)</td>
			<?php if ($this->background_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->background_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Background Image</td>
			<td><input type="file" name="background_image" value="<?php echo $this->background_image ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Compare Screen Background Image (Thumbnail)</td>
			<?php if ($this->comparescreen_background_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->comparescreen_background_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Compare Screen Background Image</td>
			<td><input type="file" name="comparescreen_background_image" value="<?php echo $this->comparescreen_background_image ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Intro Screen Image (Thumbnail)</td>
			<?php if ($this->introscreen_background_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->introscreen_background_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>	
		<tr>
			<td class="key">Upload New Intro Screen Image</td>
			<td><input type="file" name="introscreen_image" value="<?php echo $this->introscreen_background_image ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Winner Screen Background Image (Thumbnail)</td>
			<?php if ($this->winnerscreen_background_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->winnerscreen_background_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Winner Screen Background Image</td>
			<td><input type="file" name="winnerscreen_background_image" value="<?php echo $this->winnerscreen_background_image ?>"/></td>
		</tr>
	</table>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Bracket Round Dates</h3></td>
		</tr>
		<?php
		$num_dates = 5;
		for ($i = 1; $i <= $num_dates; $i++) {
			echo "<tr>";
				echo "<td class='key'>";
				if ($i==5) {
					echo "Close";
				} else {
					echo "Round $i Start ";
				}
				echo " Date</td>";
				?>
				<td><input class="inputbox" type="text" name="startdate_<?php echo $i?>" id="startdate_<?php echo $i?>" size="25" maxlength="25"   value="<?php echo $this->periods[$i - 1]['date']; ?>" />&nbsp;<input type="reset" class="button" value="..."
			onclick="return showCalendar('startdate_<?php echo $i?>','%m-%d-%Y');" /></td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="2"><h3>Bracket Font</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color"  value="<?php echo $this->font_color ?>" data-hex="true" name="font_color" id="font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="font_family">
						<option value="Arial, Helvetica, sans-serif" <?php if ($this->font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
						<option value="Times New Roman, Times, serif" <?php if ($this->font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
						<!--
<option value="Comic Sans MS, cursive" <?php if ($this->font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
						<option value="Courier New, Courier New, monospace" <?php if ($this->font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
						<option value="Georgia, Times New Roman, serif" <?php if ($this->font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
						<option value="Impact, Charcoal, sans-serif" <?php if ($this->font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
						<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
						<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if ($this->font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
						<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
						<option value="Verdana, Geneva, sans-serif" <?php if ($this->font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
						-->
					</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="font_size">
					<option value="8" <?php if ($this->font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Background Color</td>
			<td><input type="color" value="<?php echo $this->font_back_color ?>" data-hex="true" name="font_back_color" id="font_back_color" /></td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="font_bold">
					<option value="1" <?php if ($this->font_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->font_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h3>Bracket Netline</h3></td>
		</tr>
		<tr>
			<td class="key">Color</td>
			<td><input type="color" value="<?php echo $this->netline_color ?>" data-hex="true" name="netline_color" id="netline_color" /></td>
		</tr>
		<tr>
			<td class="key">Lose Color</td>
			<td><input type="color" value="<?php echo $this->netline_losecolor ?>" data-hex="true" name="netline_lose_color" id="netline_lose_color" /></td>
		</tr>
		<tr>
			<td class="key">Netline Thickness <em>(pixels)</em></td>
			<td>
				<select name="netline_thickness">
				<?php
				for ($a = 1; $a <=10; $a++) {
					echo "<option value=\"{$a}\"";
					if ($this->netline_thickness == $a) {
						echo " selected=\"selected\"";
					}
					echo ">{$a}</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h3>Bracket Options</h3></td>
		</tr>
		<tr>
			<td class="key">Show intro screen</td>
			<td>
				<select name="show_info_screen">
					<option value="1" <?php if ($this->show_info_screen) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->show_info_screen) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Show winner screen</td>
			<td>
				<select name="show_winner_screen">
					<option value="1" <?php if ($this->show_winner_screen) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->show_winner_screen) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Use one image</td>
			<td>
				<select name="use_one_image">
					<option value="1" <?php if ($this->use_one_image) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->use_one_image) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Allow multiple votes</td>
			<td>
				<select name="allow_multiple_votes">
					<option value="1" <?php if ($this->allow_multiple_votes) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->allow_multiple_votes) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
	</table>
	<h2>Entry Boxes</h2>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Borders</h3></td>
		</tr>
		<tr>
			<td class="key">Border Color</td>
			<td><input type="color" value="<?php echo $this->box_border_color ?>" data-hex="true" name="box_border_color" id="box_border_color" /></td>
		</tr>
		<tr>
			<td class="key">MouseOver Border Color</td>
			<td><input type="color" value="<?php echo $this->box_over_border_color ?>" data-hex="true" name="box_over_border_color" id="box_over_border_color" /></td>
		</tr>
		<tr>
			<td class="key">Border Thickness <em>(pixels)</em></td>
			<td>
				<select name="box_border_thickness">
				<?php
				for ($a = 1; $a <=20; $a++) {
					echo "<option value=\"{$a}\"";
					if ($this->box_border_thickness == $a) {
						echo " selected=\"selected\"";
					}
					echo ">{$a}</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Box Roundness <em>(pixels)</em></td>
			<td>
				<select name="box_roundness">
				<?php
				for ($a = 1; $a <=20; $a++) {
					echo "<option value=\"{$a}\"";
					if ($this->box_roundness == $a) {
						echo " selected=\"selected\"";
					}
					echo ">{$a}</option>";
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h3>Gradient Fills</h3></td>
		</tr>
		<tr>
			<td class="key">Gradient Fill Color 1</td>
			<td><input type="color" value="<?php echo $this->box_gradient_color1 ?>" data-hex="true" name="box_gradient_color1" id="box_gradient_color1" /></td>
		</tr>
		<tr>
			<td class="key">Gradient Fill Color 2</td>
			<td><input type="color" value="<?php echo $this->box_gradient_color2 ?>" data-hex="true" name="box_gradient_color2" id="box_gradient_color2" /></td>
		</tr>
		<tr>
			<td class="key">Box Gradient Angle</td>
			<td><input type="text" name="box_gradient_angle" maxlength="3" size="3" value="<?php echo $this->box_gradient_angle ?>" />&#176;</td>
		</tr>
		<tr>
			<td class="key">Box Lose Fill Color</td>
			<td><input type="color" value="<?php echo $this->box_lose_fill_color ?>" data-hex="true" name="box_lose_fill_color" id="box_lose_fill_color" /></td>
		</tr>		
	</table>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Box Background Images <em>(Optional)</em></h3></td>
		</tr>
		<tr>
			<td class="key">Current Default Box Background Image (Thumbnail)</td>
			<?php if ($this->default_box_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->default_box_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload Default Box Background Image</td>
			<td><input type="file" name="default_box_image" value="<?php echo $this->default_box_image ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Default Winner Background Image (Thumbnail)</td>
			<?php if ($this->default_winner_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->default_winner_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload Default Winner Background Image</td>
			<td><input type="file" name="default_winner_image" value="<?php echo $this->default_winner_image ?>"/></td>
		</tr>
	</table>
</fieldset>
<fieldset class="adminform" id="compare-screen">
	<h2><a href="#">Compare Screen - Advanced Options</a><span>Click to edit</span></h2>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Compare Screen Dimensions</h3></td>
		</tr>
		<tr>
			<td class="key">Width <em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_width" maxlength="3" size="3" value="<?php echo $this->comparescreen_width ?>" /></td>
		</tr>
		<tr>
			<td class="key">Height <em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_height" maxlength="3" size="3" value="<?php echo $this->comparescreen_height ?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Close Button </h3><em><strong>Optional</strong> - If left blank, the entire screen will be a close button</em></td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_close_button_xpos" maxlength="3" size="3" value="<?php echo $this->comparescreen_close_button_xpos ?>" /></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_close_button_ypos" maxlength="3" size="3"  value="<?php echo $this->comparescreen_close_button_ypos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Up State Image (Thumbnail)</td>
			<?php if ($this->comparescreen_upstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->comparescreen_upstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Up State Image</td>
			<td><input type="file" name="comparescreen_upstate_image" value="<?php echo $this->comparescreen_upstate_image ?>"/></td>
		</tr>		
		<tr>
			<td class="key">Current Over State Image (Thumbnail)</td>
			<?php if ($this->comparescreen_overstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->comparescreen_overstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Over State Image</td>
			<td><input type="file" name="comparescreen_overstate_image" value="<?php echo $this->comparescreen_overstate_image ?>"/></td>
		</tr>
	</table>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
			<tr>
			<td colspan="2"><h3>Round Label Text</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color" value="<?php echo $this->comparescreen_roundlabeltext_font_color ?>" data-hex="true" name="comparescreen_roundlabeltext_font_color" id="comparescreen_roundlabeltext_font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="comparescreen_roundlabeltext_font_family">
					<option value="Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
					<option value="Times New Roman, Times, serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
					<!--
<option value="Comic Sans MS, cursive" <?php if ($this->comparescreen_roundlabeltext_font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
					<option value="Courier New, Courier New, monospace" <?php if ($this->comparescreen_roundlabeltext_font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
					<option value="Georgia, Times New Roman, serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
					<option value="Impact, Charcoal, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
					<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
					<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
					<option value="Tahoma, Geneva, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
					<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
					<option value="Verdana, Geneva, sans-serif" <?php if ($this->comparescreen_roundlabeltext_font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
					-->
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="comparescreen_roundlabeltext_font_size">
					<option value="8" <?php if ($this->comparescreen_roundlabeltext_font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->comparescreen_roundlabeltext_font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->comparescreen_roundlabeltext_font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->comparescreen_roundlabeltext_font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->comparescreen_roundlabeltext_font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->comparescreen_roundlabeltext_font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->comparescreen_roundlabeltext_font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->comparescreen_roundlabeltext_font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->comparescreen_roundlabeltext_font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->comparescreen_roundlabeltext_font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->comparescreen_roundlabeltext_font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->comparescreen_roundlabeltext_font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->comparescreen_roundlabeltext_font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->comparescreen_roundlabeltext_font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->comparescreen_roundlabeltext_font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->comparescreen_roundlabeltext_font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->comparescreen_roundlabeltext_font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="comparescreen_roundlabeltext_bold">
					<option value="1" <?php if ($this->comparescreen_roundlabeltext_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->comparescreen_roundlabeltext_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_roundlabeltext_xpos" maxlength="3" size="3" value="<?php echo $this->comparescreen_roundlabeltext_xpos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_roundlabeltext_ypos" maxlength="3" size="3" value="<?php echo $this->comparescreen_roundlabeltext_ypos ?>"/></td>
		</tr>		
		<tr>
			<td colspan="2"><h3>Name Text</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color" value="<?php echo $this->comparescreen_nametext_font_color ?>" data-hex="true" name="comparescreen_nametext_font_color" id="comparescreen_nametext_font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="comparescreen_nametext_font_family">
					<option value="Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
					<option value="Times New Roman, Times, serif" <?php if ($this->comparescreen_nametext_font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
					<!--
<option value="Comic Sans MS, cursive" <?php if ($this->comparescreen_nametext_font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
					<option value="Courier New, Courier New, monospace" <?php if ($this->comparescreen_nametext_font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
					<option value="Georgia, Times New Roman, serif" <?php if ($this->comparescreen_nametext_font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
					<option value="Impact, Charcoal, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
					<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
					<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->comparescreen_nametext_font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
					<option value="Tahoma, Geneva, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
					<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
					<option value="Verdana, Geneva, sans-serif" <?php if ($this->comparescreen_nametext_font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
					-->
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="comparescreen_nametext_font_size">
					<option value="8" <?php if ($this->comparescreen_nametext_font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->comparescreen_nametext_font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->comparescreen_nametext_font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->comparescreen_nametext_font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->comparescreen_nametext_font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->comparescreen_nametext_font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->comparescreen_nametext_font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->comparescreen_nametext_font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->comparescreen_nametext_font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->comparescreen_nametext_font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->comparescreen_nametext_font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->comparescreen_nametext_font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->comparescreen_nametext_font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->comparescreen_nametext_font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->comparescreen_nametext_font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->comparescreen_nametext_font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->comparescreen_nametext_font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="comparescreen_nametext_bold">
					<option value="1" <?php if ($this->comparescreen_nametext_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->comparescreen_nametext_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_nametext_xpos" maxlength="3" size="3" value="<?php //echo $this->comparescreen_nametext_xpos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_nametext_ypos" maxlength="3" size="3" value="<?php //echo $this->comparescreen_nametext_ypos ?>"/></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Description Text</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color" value="<?php echo $this->comparescreen_descriptiontext_font_color ?>" data-hex="true" name="comparescreen_descriptiontext_font_color" id="comparescreen_descriptiontext_font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="comparescreen_descriptiontext_font_family">
					<option value="Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
					<option value="Times New Roman, Times, serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
					<!--
<option value="Comic Sans MS, cursive" <?php if ($this->comparescreen_descriptiontext_font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
					<option value="Courier New, Courier New, monospace" <?php if ($this->comparescreen_descriptiontext_font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
					<option value="Georgia, Times New Roman, serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
					<option value="Impact, Charcoal, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
					<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
					<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
					<option value="Tahoma, Geneva, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
					<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
					<option value="Verdana, Geneva, sans-serif" <?php if ($this->comparescreen_descriptiontext_font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
					-->
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="comparescreen_descriptiontext_font_size">
					<option value="8" <?php if ($this->comparescreen_descriptiontext_font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->comparescreen_descriptiontext_font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->comparescreen_descriptiontext_font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->comparescreen_descriptiontext_font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->comparescreen_descriptiontext_font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->comparescreen_descriptiontext_font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->comparescreen_descriptiontext_font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->comparescreen_descriptiontext_font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->comparescreen_descriptiontext_font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->comparescreen_descriptiontext_font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->comparescreen_descriptiontext_font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->comparescreen_descriptiontext_font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->comparescreen_descriptiontext_font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->comparescreen_descriptiontext_font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->comparescreen_descriptiontext_font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->comparescreen_descriptiontext_font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->comparescreen_descriptiontext_font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="comparescreen_descriptiontext_bold">
					<option value="1" <?php if ($this->comparescreen_descriptiontext_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->comparescreen_descriptiontext_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_descriptiontext_xpos" maxlength="3" size="3" value="<?php echo $this->comparescreen_descriptiontext_xpos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="comparescreen_descriptiontext_ypos" maxlength="3" size="3" value="<?php echo $this->comparescreen_descriptiontext_ypos ?>"/></td>
		</tr>
	</table>
</fieldset>
<fieldset class="adminform" id="intro-screen">
	<h2><a href="#">Intro Screen - Advanced Options</a><span>Click to edit</span></h2>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Intro Screen Dimensions</h3></td>
		</tr>
		<tr>
			<td class="key">Width <em>(pixels)</em></td>
			<td><input type="text" name="introscreen_width" maxlength="3" size="3" value="<?php echo $this->introscreen_width ?>" /></td>
		</tr>
		<tr>
			<td class="key">Height <em>(pixels)</em></td>
			<td><input type="text" name="introscreen_height" maxlength="3" size="3" value="<?php echo $this->introscreen_height ?>" /></td>
		</tr>
	</table>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Intro Screen - Start Button </h3><em>Optional - If left blank, the entire screen will be a close button</em></td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="introscreen_start_button_xpos" maxlength="3" size="3" value="<?php echo $this->introscreen_start_button_xpos ?>" /></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="introscreen_start_button_ypos" maxlength="3" size="3" value="<?php echo $this->introscreen_start_button_ypos ?>" /></td>
		</tr>
		<tr>
			<td class="key">Current Up State Image (Thumbnail)</td>
			<?php if ($this->introscreen_upstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->introscreen_upstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>	
		<tr>
			<td class="key">Upload New Up State Image</td>
			<td><input type="file" name="introscreen_upstate_image" value="<?php echo $this->introscreen_upstate_image ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Over State Image (Thumbnail)</td>
			<?php if ($this->introscreen_overstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->introscreen_overstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>	
		<tr>
			<td class="key">Upload New Over State Image</td>
			<td><input type="file" name="introscreen_overstate_image" value="<?php echo $this->introscreen_overstate_image ?>"/></td>
		</tr>
	</table>
</fieldset>
<fieldset class="adminform" id="winner-screen">
	<h2><a href="#">Winner Screen - Advanced Options</a><span>Click to edit</span></h2>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Winner Screen Dimensions</h3></td>
		</tr>
		<tr>
			<td class="key">Width <em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_width" maxlength="3" size="3" value="<?php echo $this->winnerscreen_width ?>" /></td>
		</tr>
		<tr>
			<td class="key">Height <em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_height" maxlength="3" size="3" value="<?php echo $this->winnerscreen_height ?>"/></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Winner Image Size and Position </h3></td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_winner_image_xpos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_winner_image_xpos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_winner_image_ypos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_winner_image_ypos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Width <em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_winner_image_width" maxlength="3" size="3" value="<?php echo $this->winnerscreen_winner_image_width ?>"/></td>
		</tr>
		<tr>
			<td class="key">Height <em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_winner_image_height" maxlength="3" size="3"  value="<?php echo $this->winnerscreen_winner_image_height ?>"/></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Close Button</h3></td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_close_button_xpos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_close_button_xpos ?>" /></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_close_button_ypos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_close_button_ypos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Current Up State Image (Thumbnail)</td>
			<?php if ($this->winnerscreen_upstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->winnerscreen_upstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Up State Image Image</td>
			<td><input type="file" name="winnerscreen_upstate_image" value="<?php echo $this->winnerscreen_upstate_image ?>"/></td>
		</tr>		
		<tr>
			<td class="key">Current Over State Image (Thumbnail)</td>
			<?php if ($this->winnerscreen_overstate_image !== '') {?>
				<td><img src="../assets/components/com_bracket/<?php echo $this->id ?>/<?php echo $this->winnerscreen_overstate_image ?>" style="max-width: 100px; max-height: 100px;border:1px solid black;"/></td>
			<?php } else { echo "<td>Not Set</td>";}?>
		</tr>
		<tr>
			<td class="key">Upload New Over State Image</td>
			<td><input type="file" name="winnerscreen_overstate_image" value="<?php echo $this->winnerscreen_overstate_image ?>"/></td>
		</tr>	
	</table>
	<table class="admintable" style="width: 46%; display: inline-block;vertical-align:top;">
		<tr>
			<td colspan="2"><h3>Percentage Text</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color" value="<?php echo $this->winnerscreen_percentagetext_font_color ?>" data-hex="true" name="winnerscreen_percentagetext_font_color" id="winnerscreen_percentagetext_font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="winnerscreen_percentagetext_font_family">
						<option value="Arial, Helvetica, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
						<option value="Times New Roman, Times, serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
						<!--
<option value="Comic Sans MS, cursive" <?php if ($this->winnerscreen_percentagetext_font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
						<option value="Courier New, Courier New, monospace" <?php if ($this->winnerscreen_percentagetext_font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
						<option value="Georgia, Times New Roman, serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
						<option value="Impact, Charcoal, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
						<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
						<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
						<option value="Tahoma, Geneva, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
						<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
						<option value="Verdana, Geneva, sans-serif" <?php if ($this->winnerscreen_percentagetext_font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
						-->
					</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="winnerscreen_percentagetext_font_size">
					<option value="8" <?php if ($this->winnerscreen_percentagetext_font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->winnerscreen_percentagetext_font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->winnerscreen_percentagetext_font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->winnerscreen_percentagetext_font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->winnerscreen_percentagetext_font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->winnerscreen_percentagetext_font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->winnerscreen_percentagetext_font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->winnerscreen_percentagetext_font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->winnerscreen_percentagetext_font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->winnerscreen_percentagetext_font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->winnerscreen_percentagetext_font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->winnerscreen_percentagetext_font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->winnerscreen_percentagetext_font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->winnerscreen_percentagetext_font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->winnerscreen_percentagetext_font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->winnerscreen_percentagetext_font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->winnerscreen_percentagetext_font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="winnerscreen_percentagetext_bold">
					<option value="1" <?php if ($this->winnerscreen_percentagetext_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->winnerscreen_percentagetext_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_percentagetext_xpos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_percentagetext_xpos ?>" /></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_percentagetext_ypos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_percentagetext_ypos ?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><h3>Name Text</h3></td>
		</tr>
		<tr>
			<td class="key">Font Color</td>
			<td><input type="color" value="<?php echo $this->winnerscreen_nametext_font_color ?>" data-hex="true" name="winnerscreen_nametext_font_color" id="winnerscreen_nametext_font_color" /></td>
		</tr>
		<tr>
			<td class="key">Font Family</td>
			<td>
				<select name="winnerscreen_nametext_font_family">
					<option value="Arial, Helvetica, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Arial, Helvetica, sans-serif</option>
					<option value="Times New Roman, Times, serif" <?php if ($this->winnerscreen_nametext_font_family == "Times New Roman, Times, serif") echo " selected=\"selected\"" ?>>Times New Roman, Times, serif</option>
					<!--
<option value="Comic Sans MS, cursive" <?php if ($this->winnerscreen_nametext_font_family == "Comic Sans MS, cursive") echo " selected=\"selected\"" ?>>Comic Sans MS, cursive</option>
					<option value="Courier New, Courier New, monospace" <?php if ($this->winnerscreen_nametext_font_family == "Courier New, Courier New, monospace") echo " selected=\"selected\"" ?>>Courier New, Courier New, monospace</option>
					<option value="Georgia, Times New Roman, serif" <?php if ($this->winnerscreen_nametext_font_family == "Georgia, Times New Roman, serif") echo " selected=\"selected\"" ?>>Georgia, Times New Roman, serif</option>
					<option value="Impact, Charcoal, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Impact, Charcoal, sans-serif") echo " selected=\"selected\"" ?>>Impact, Charcoal, sans-serif</option>
					<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Lucida Sans Unicode, Lucida Grande, sans-serif") echo " selected=\"selected\"" ?>>Lucida Sans Unicode, Lucida Grande, sans-serif</option>
					<option value="Palatino Linotype, Book Antiqua, Palatino, serif" <?php if ($this->winnerscreen_nametext_font_family == "Palatino Linotype, Book Antiqua, Palatino, serif") echo " selected=\"selected\"" ?>>Palatino Linotype, Book Antiqua, Palatino, serif</option>
					<option value="Tahoma, Geneva, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Tahoma, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Tahoma, Geneva, sans-serif</option>
					<option value="Trebuchet MS, Arial, Helvetica, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Trebuchet MS, Arial, Helvetica, sans-serif") echo " selected=\"selected\"" ?>>Trebuchet MS, Arial, Helvetica, sans-serif</option>
					<option value="Verdana, Geneva, sans-serif" <?php if ($this->winnerscreen_nametext_font_family == "Verdana, Geneva, sans-serif") echo " selected=\"selected\"" ?>>Verdana, Geneva, sans-serif</option>
					-->
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Font Size <em>(pixels)</em></td>
			<td>
				<select name="winnerscreen_nametext_font_size">
					<option value="8" <?php if ($this->winnerscreen_nametext_font_size == "8") echo " selected=\"selected\"" ?>>8</option>
					<option value="9" <?php if ($this->winnerscreen_nametext_font_size == "9") echo " selected=\"selected\"" ?>>9</option>
					<option value="10" <?php if ($this->winnerscreen_nametext_font_size == "10") echo " selected=\"selected\"" ?>>10</option>
					<option value="11" <?php if ($this->winnerscreen_nametext_font_size == "11") echo " selected=\"selected\"" ?>>11</option>
					<option value="12" <?php if ($this->winnerscreen_nametext_font_size == "12") echo " selected=\"selected\"" ?>>12</option>
					<option value="14" <?php if ($this->winnerscreen_nametext_font_size == "14") echo " selected=\"selected\"" ?>>14</option>
					<option value="16" <?php if ($this->winnerscreen_nametext_font_size == "16") echo " selected=\"selected\"" ?>>16</option>
					<option value="18" <?php if ($this->winnerscreen_nametext_font_size == "18") echo " selected=\"selected\"" ?>>18</option>
					<option value="20" <?php if ($this->winnerscreen_nametext_font_size == "20") echo " selected=\"selected\"" ?>>20</option>
					<option value="24" <?php if ($this->winnerscreen_nametext_font_size == "24") echo " selected=\"selected\"" ?>>24</option>
					<option value="28" <?php if ($this->winnerscreen_nametext_font_size == "28") echo " selected=\"selected\"" ?>>28</option>
					<option value="30" <?php if ($this->winnerscreen_nametext_font_size == "30") echo " selected=\"selected\"" ?>>30</option>
					<option value="32" <?php if ($this->winnerscreen_nametext_font_size == "32") echo " selected=\"selected\"" ?>>32</option>
					<option value="36" <?php if ($this->winnerscreen_nametext_font_size == "36") echo " selected=\"selected\"" ?>>36</option>
					<option value="40" <?php if ($this->winnerscreen_nametext_font_size == "40") echo " selected=\"selected\"" ?>>40</option>
					<option value="48" <?php if ($this->winnerscreen_nametext_font_size == "48") echo " selected=\"selected\"" ?>>48</option>
					<option value="64" <?php if ($this->winnerscreen_nametext_font_size == "64") echo " selected=\"selected\"" ?>>64</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">Bold?</td>
			<td>
				<select name="winnerscreen_nametext_bold">
					<option value="1" <?php if ($this->winnerscreen_nametext_bold) { echo "selected"; } ?>>yes</option>
					<option value="0" <?php if (!$this->winnerscreen_nametext_bold) { echo "selected"; } ?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="key">X Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_nametext_xpos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_nametext_xpos ?>"/></td>
		</tr>
		<tr>
			<td class="key">Y Position<em>(pixels)</em></td>
			<td><input type="text" name="winnerscreen_nametext_ypos" maxlength="3" size="3" value="<?php echo $this->winnerscreen_nametext_ypos ?>"/></td>
		</tr>
	</table>
</fieldset>
	<input type="hidden" name="numEntries" value="<?php echo $this->numEntries ?>" />
	<input type="hidden" name="mode" value="edit" />
	<input type="hidden" name="id" value="<?php echo $this->id ?>" />
	<input type="hidden" name="entriesPerGroup" value="<?php echo $this->entriesPerGroup ?>" />
	<input type="hidden" name="task" value="" />
</form>
