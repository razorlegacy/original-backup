<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    
    $document 	=& JFactory::getDocument();
	$document->addStyleSheet('/libraries/evolve/assets/css/miniColors.css');
    $document->addScript('/libraries/evolve/assets/js/miniColors.js');
  
	$syndiTemplate		= new syndiTemplate();
    $syndiConfigObj		= json_decode($this->syndi->config); 
?>
		<form id="syndiConfig">
			<div id="syndi_config">
				<h3><a href="#">General</a></h3>
				<div>
					<ul class="disableListStyle">
						<li>
							<label><?php echo JText::_('CONFIG_HEADER_CLICK_1');?></label>
							<input type="text" name="header_click_1" value="<?php echo $syndiConfigObj->header_click_1;?>" placeholder="http://"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_HEADER_CLICK_2');?></label>
							<input type="text" name="header_click_2" value="<?php echo $syndiConfigObj->header_click_2;?>" placeholder="http://"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_VIDEO_AUTOPLAY');?></label>
							<select name="video_autoStart" class="videoParams">
							<?php
								$autoStartOptions	= array('true'=>'Yes', 'false'=>'No');
								echo $syndiTemplate->_createOption($autoStartOptions, $syndiConfigObj->video_autoStart);
							?>
							</select>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_VIDEO_STARTMUTE');?></label>
							<select name="video_autoMute" class="videoParams">
							<?php
								$autoMuteOptions	= array('true'=>'Yes', 'false'=>'No');
								echo $syndiTemplate->_createOption($autoMuteOptions, $syndiConfigObj->video_autoMute);
							?>
							</select>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_CYCLE_FX');?></label>
							<select name="cycle_fx">
							<?php
								$cycleOptions = array(
												'fade'=>'Fade',
												'scrollLeft'=>'Scroll Left', 
												'scrollRight'=>'Scroll Right'
												);
								echo $syndiTemplate->_createOption($cycleOptions, $syndiConfigObj->cycle_fx);
								?>
							</select>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_CYCLE_SPEED');?></label>
							<input type="text" name="cycle_speed" value="<?php echo $syndiConfigObj->cycle_speed;?>"/>
						</li>
					</ul>
				</div>
				<h3><a href="#">Colors</a></h3>
				<div>
					<ul class="disableListStyle">
						<li>
							<label><?php echo JText::_('CONFIG_ARTICLE_TTILE_HEX');?></label>
							<input type="text" name="article_title_hex" class="colorPicker" value="<?php echo $syndiConfigObj->article_title_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_ARTICLE_CONTENT_HEX');?></label>
							<input type="text" name="article_content_hex" class="colorPicker" value="<?php echo $syndiConfigObj->article_content_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_LINK_HEX');?></label>
							<input type="text" name="link_hex" class="colorPicker" value="<?php echo $syndiConfigObj->link_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_LINK_HOVER_HEX');?></label>
							<input type="text" name="link_hover_hex" class="colorPicker" value="<?php echo $syndiConfigObj->link_hover_hex;?>"/>
						</li>
					</ul>
				</div>
				<h3><a href="#">Tabs</a></h3>
				<div>
					<ul class="disableListStyle">
						<li>
							<label><?php echo JText::_('CONFIG_TAB_POSITION');?></label>
							<select name="tab_position">
							<?php
								$tabOptions = array('bottom'=>'Bottom', 'top'=>'Top');
								echo $syndiTemplate->_createOption($tabOptions, $syndiConfigObj->tab_position);
							?>
							</select>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_TAB_BG_HEX');?></label>
							<input type="text" name="tab_bg_hex" class="colorPicker" value="<?php echo $syndiConfigObj->tab_bg_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_TAB_BG_HOVER_HEX');?></label>
							<input type="text" name="tab_bg_hover_hex" class="colorPicker" value="<?php echo $syndiConfigObj->tab_bg_hover_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_TAB_TEXT_HEX');?></label>
							<input type="text" name="tab_text_hex" class="colorPicker" value="<?php echo $syndiConfigObj->tab_text_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_TAB_TEXT_HOVER_HEX');?></label>
							<input type="text" name="tab_text_hover_hex" class="colorPicker" value="<?php echo $syndiConfigObj->tab_text_hover_hex;?>"/>
						</li>
					</ul>
				</div>	
				
				<h3><a href="#">Pagination</a></h3>
				<div>
					<ul class="disableListStyle">
						<li>
							<label><?php echo JText::_('CONFIG_PAGINATION_BG');?></label>
							<input type="text" name="cycle_pagination_bg" class="colorPicker" value="<?php echo $syndiConfigObj->cycle_pagination_bg;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_PAGINATION_HEX');?></label>
							<input type="text" name="cycle_pagination_hex" class="colorPicker" value="<?php echo $syndiConfigObj->cycle_pagination_hex;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_PAGINATION_HOVER_HEX');?></label>
							<input type="text" name="cycle_pagination_hover_hex" class="colorPicker" value="<?php echo $syndiConfigObj->cycle_pagination_hover_hex;?>"/>
						</li>
					</ul>
				</div>
				<h3><a href="#">Social</a></h3>
				<div>
					<ul class="disableListStyle">
						<li>
							<label><?php echo JText::_('CONFIG_SOCIAL_SHOW');?></label>
							<select name="social_show">
							<?php
								$socialShowOptions	= array('false'=>'No', 'true'=>'Yes');
								echo $syndiTemplate->_createOption($socialShowOptions, $syndiConfigObj->social_show);
							?>
							</select>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_SOCIAL_TITLE');?></label>
							<input type="text" name="social_title" value="<?php echo $syndiConfigObj->social_title;?>"/>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_SOCIAL_DESCRIPTION');?></label>
							<textarea class="elastic" name="social_description"><?php echo $syndiConfigObj->social_description;?></textarea>
						</li>
						<li>
							<label><?php echo JText::_('CONFIG_SOCIAL_IMAGE');?></label>
							<input type="text" name="social_image" value="<?php echo $syndiConfigObj->social_image;?>"/>
						</li>
					</ul>
				</div>
			</div>
			<input type="hidden" name="sid" id="sid" value="<?php echo $this->syndi->sid; ?>"/>
			<input type="hidden" id="task" name="task" value="saveConfig"/>
			<input type="button" id="save_config" name="save_config" value="<?php echo JText::_('CONFIG_SAVE');?>"/>
		</form>