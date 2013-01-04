<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$orochiTemplate		= new orochiTemplate();
	$orochiConfigObj	= json_decode($this->orochi->content);
	$orochiConfigTab	= array('general', 'colors', 'advanced');
?>
<script type="text/javascript">
		$j(function() {
			orochiGeneral.upload('orochi_config_general');
		});
	</script>
<form id="orochiConfig" class="orochi-form">
	<div id="orochi_config_pager" class="orochi-bg-primary orochi-border orochi-notched-tabs">
		<ul class="list-inline"><!--
			<?php
			foreach($orochiConfigTab as $key=>$value) {
			?>
				--><li class="orochi-bg-primary"><a href="#orochi_config_<?php echo $value;?>" class="icons_config orochi-tips" title="<?php echo ucfirst($value);?>" style="background-position: <?php echo $key*(-32);?>px 0"><?php echo $value;?></a></li><!--
			<?php
			}
			?>
		--></ul>
	</div>
	<div class="orochi-border orochi-bg-primary workspace_tab_add">
		<a class="button on inline orochi-tips" title="Create a New Syndi Menu">
			<span class="icon icon3"></span>
			<span class="label">Add a Menu</span>
		</a>
	</div>
	<div id="orochi_config_general">
		<h2 class="orochi-title"><?php echo JText::_('CONFIG_TITLE_GENERAL');?></h2>
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('CREATE_NAME');?></label>
				<input type="text" name="title" id="title" class="websvc-required" placeholder="Name of Syndi" value="<?php echo $this->orochi->title;?>" title="<?php echo JText::_('REQUIRED');?>"/>
			</li>
			<li class="orochi-uploadify">
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_BG_250');?></label>
				<?php echo $orochiTemplate->uploadify($orochiConfigObj->syndi_bg_250, 'syndi_bg_250');?>
			</li>
			<li class="orochi-uploadify">
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_BG_600');?></label>
				<?php echo $orochiTemplate->uploadify($orochiConfigObj->syndi_bg_600, 'syndi_bg_600');?>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_HEADER_1');?></label>
				<input type="text" name="header_click_1" value="<?php echo $orochiConfigObj->header_click_1;?>" placeholder="http://"/>
			</li>
<!--
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_HEADER_2');?></label>
				<input type="text" name="header_click_2" value="<?php //echo $orochiConfigObj->header_click_2;?>" placeholder="http://"/>
			</li>
-->
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_SOCIAL');?></label>
				<select name="social_show">
				<?php
					$socialShowOptions	= array('false'=>'No', 'true'=>'Yes');
					echo $orochiTemplate->_createOption($socialShowOptions, $orochiConfigObj->social_show);
				?>
				</select>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_SOCIAL_TITLE');?></label>
				<input type="text" name="social_title" value="<?php echo $orochiConfigObj->social_title;?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_SOCIAL_DESCRIPTION');?></label>
				<textarea class="elastic" name="social_description"><?php echo $orochiConfigObj->social_description;?></textarea>
			</li>
			<li class="orochi-uploadify">
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_SOCIAL_ICON');?></label>
				<?php echo $orochiTemplate->uploadify($orochiConfigObj->social_image, 'social_image');?>
			</li>
			<!--
<li>
				<label class="inline"><?php echo JText::_('CONFIG_GENERAL_SOCIAL_ICON');?></label>
				<input type="file" name="image_upload" id="image_upload_social"/>
				<input type="hidden" name="social_image" class="orochi_uploadify" value="<?php echo $orochiConfigObj->social_image;?>"/>
			</li>
-->

		</ul>
	</div>
	<div id="orochi_config_colors">
		<h2 class="orochi-title"><?php echo JText::_('CONFIG_TITLE_COLORS');?></h2>
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_TITLE');?></label>
				<input type="text" name="title_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->title_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_title","type":"color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_CONTENT');?></label>
				<input type="text" name="content_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->content_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_content","type":"color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_LINK');?></label>
				<input type="text" name="link_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->link_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_link","type":"color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_LINK_HOVER');?></label>
				<input type="text" name="link_hover_hex" class="colorPicker" value="<?php echo $orochiConfigObj->link_hover_hex;?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_SCROLLBAR');?></label>
				<input type="text" name="scrollbar_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->scrollbar_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi-scrollable .jspDrag","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_PAGINATION_BG');?></label>
				<input type="text" name="pagination_bg_hex" class="" value="<?php echo $orochiConfigObj->pagination_bg_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_group_pager","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_PAGINATION_BG_OPACITY');?></label>
				<div class="inline">
					<input type="text" name="pagination_bg_opacity" class="orochi-slider-value" value="<?php echo $orochiConfigObj->pagination_bg_opacity;?>"/>%
					<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
					<div class="orochi-slider-opacity orochi-bg-tertiary"></div>
				</div>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_PAGINATION_LINK');?></label>
				<input type="text" name="pagination_link_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->pagination_link_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_group_pager_index a","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_PAGINATION_LINK_HOVER');?></label>
				<input type="text" name="pagination_link_hover_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->pagination_link_hover_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_group_pager_index a.activeSlide","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_TAB_BG');?></label>
				<input type="text" name="tab_bg_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->tab_bg_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_tab_hex","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_TAB_BG_HOVER');?></label>
				<input type="text" name="tab_bg_hover_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->tab_bg_hover_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_tab_hex.ui-tabs-selected","type":"background-color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_TAB_CONTENT');?></label>
				<input type="text" name="tab_text_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->tab_text_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_tab_hex a","type":"color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_COLOR_TAB_CONTENT_HOVER');?></label>
				<input type="text" name="tab_text_hover_hex" class="colorPicker orochi-preview-live" value="<?php echo $orochiConfigObj->tab_text_hover_hex;?>"/>
				<div class="orochi-hidden orochi-preview-selector">{"className":".emcOrochi_tab_hex.ui-tabs-selected a","type":"color"}</div>
				<label class="inline orochi-preview-message orochi-hidden"><?php echo JText::_('CONFIG_PREVIEW_SAVE');?></label>
			</li>
		</ul>
	</div>
	<div id="orochi_config_advanced">
		<h2 class="orochi-title"><?php echo JText::_('CONFIG_TITLE_ADVANCED');?></h2>
		<ul class="disable-list-style">
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_ADVANCED_TAB_250');?></label>
				<select name="tab_position_250">
				<?php
					$tabOptions = array('bottom'=>'Bottom', 'top'=>'Top');
					echo $orochiTemplate->_createOption($tabOptions, $orochiConfigObj->tab_position_250);
				?>
				</select>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_ADVANCED_TAB_600');?></label>
				<select name="tab_position_600">
				<?php
					$tabOptions = array('top'=>'Top', 'bottom'=>'Bottom');
					echo $orochiTemplate->_createOption($tabOptions, $orochiConfigObj->tab_position_600);
				?>
				</select>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_ADVANCED_CYCLE_FX');?></label>
				<select name="cycle_fx">
				<?php
					$cycleOptions = array(
									'none'=>'None',
									'fade'=>'Fade',
									'scrollLeft'=>'Scroll Left', 
									'scrollRight'=>'Scroll Right'
									);
					echo $orochiTemplate->_createOption($cycleOptions, $orochiConfigObj->cycle_fx);
					?>
				</select>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_ADVANCED_CYCLE_SPEED');?></label>
				<input type="text" name="cycle_speed" value="<?php echo $orochiConfigObj->cycle_speed;?>"/>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('CONFIG_ADVANCED_CSS');?></label>
				<input type="text" name="cssModal" readonly="readonly"/>
				<div class="orochi-hidden">
					<textarea name="css" id="orochiSetup_css"><?php echo $orochiConfigObj->css;?></textarea>
				</div>
			</li>
		</ul>
	</div>
	<div class="orochi_submit_buttons">
		<a href="#" class="button orochi-button orochi-bg-primary" name="reset_config">
			<span class="icon icon188"></span>
			<span class="label"><?php echo JText::_('CONFIG_RESET');?></span>
		</a>
		<a href="#" class="button orochi-button orochi-bg-primary" name="save_config">
			<span class="icon icon44"></span>
			<span class="label"><?php echo JText::_('CONFIG_SAVE');?></span>
		</a>
	</div>
	<!-- <input type="button" id="save_config" name="save_config" value="<?php echo JText::_('CONFIG_SAVE');?>"/> -->
</form>
	<div class="orochi-hidden orochi-confirm-message">
		<?php echo JText::_('CONFIG_APPLY_CHANGES');?>
	</div>