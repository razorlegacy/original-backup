<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$originType		= new originHelper();
	$origin_id		= $this->originConfigObj->id;
	$originConfig	= json_decode($this->originConfigObj->config);
	
	//TEMP: MOBILE SUPPORT
	switch($originConfig->type) {
		case 'meridian':
			$jtext_settings_bg_expand = 'BG Mobile Image';
			break;
		default:
			$jtext_settings_bg_expand	= JText::_('SETTINGS_BG_EXPAND');
			break;
	}
?>
	<!-- TOOLBAR LINK -->
<!--
	<div id="origin_toolbar_link" class="evolve-relative">
		<?php
			$baseUrl	= 'http://'.$_SERVER["HTTP_HOST"].'/index.php?option=com_emc_origin&format=raw&id='.$this->originConfigObj->id;
			$type		= '&view='.$originConfig->type;
		?>
		<input type="text" name="origin_url" value="<?php echo $baseUrl.$type;?>" readonly="readonly"/>
		<input type="hidden" name="baseUrl" value="<?php echo $baseUrl.$type;?>"/>
		<form name="form_submit">
			
			<ul class="evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('URL_HOVER_INTENT');?></label>
					<input type="text" name="hover" placeholder="<?php echo JText::_('URL_HOVER_INTENT_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('URL_FREQUENCY');?></label>
					<input type="text" name="cap" placeholder="<?php echo JText::_('URL_FREQUENCY_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('URL_AUTO_CLOSE');?></label>
					<input type="text" name="close" placeholder="<?php echo JText::_('URL_AUTO_CLOSE_PLACEHOLDER');?>"/>
				</li>
			</ul>
		</form>
		
	</div>
-->


	<!-- CALENDAR -->
	<div id="origin_modal_calendar" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('SCHEDULE_TITLE');?></h2>
		<div class="evolve-calendar evolve-bg-primary evolve-shadow evolve-border"></div>
		<form name="form_submit">
			<input type="hidden" name="id"/>
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('SCHEDULE_START_DATE');?></label>
					<input type="text" class="evolve-required" name="start_date" readonly="readonly" placeholder="<?php echo JText::_('SCHEDULE_START_DATE_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('SCHEDULE_END_DATE');?></label>
					<input type="text" class="evolve-required" name="end_date" readonly="readonly" placeholder="<?php echo JText::_('SCHEDULE_END_DATE_PLACEHOLDER');?>"/>
				</li>
			</ul>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'schedule_save', 'evolve-bg-primary');
				?>
				<div class="evolve-hidden evolve-buttons-duplicate evolve-inline">
				<?php echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'schedule_duplicate', 'evolve-bg-primary');?>
				</div>
			</div>
			<div class="evolve-hidden evolve-buttons-delete">
			<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'schedule_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>

	<!-- EMBED -->
	<div id="origin_modal_embed" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('EMBED_TITLE');?></h2>
		<form name="form_submit">
			<textarea name="content"></textarea>
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>
	
	<!-- FLASH -->
	<div id="origin_modal_flash" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('FLASH_TITLE');?></h2>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_default" data-form="form_submit" data-input="swfObject">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_secondary" data-form="form_submit" data-input="imageBackup">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
		<form name="form_submit">
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('FLASH_UPLOAD');?></label>
					<input type="text" readonly="readonly" name="swfObject" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('IMAGE_DEFAULT');?></label>
					<input type="text" readonly="readonly" name="imageBackup" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('FLASH_WMODE');?></label>
					<select name="wmode">
						<?php
						$wmodeArray	= array('transparent'=>'Transparent', 'opaque'=>'Opaque', 'window'=>'Window');
						foreach($wmodeArray as $key=>$value) {
						?>
						<option value="<?php echo $key;?>"><?php echo $value;?></option>
						<?php
						}
						?>
					</select>
				</li>
			</ul>			
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>
	
	<!-- IMAGE -->
	<div id="origin_modal_image" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('IMAGE_TITLE');?></h2>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_default" data-form="form_submit" data-input="imageDefault">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_secondary" data-form="form_submit" data-input="imageHover">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
		<form name="form_submit">
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('IMAGE_DEFAULT');?></label>
					<input type="text" readonly="readonly" name="imageDefault" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('IMAGE_HOVER');?></label>
					<input type="text" readonly="readonly" name="imageHover" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('IMAGE_LINK');?></label>
					<input type="text" name="link" placeholder="<?php echo JText::_('IMAGE_LINK_PLACEHOLDER');?>"/>
				</li>
			</ul>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>

	<!-- LINK -->
	<div id="origin_modal_link" class="evolve-relative origin_modal">
		<script type="text/javascript">originMain.link();</script>
		<h2><?php echo JText::_('LINK_TITLE');?></h2>
		<form name="form_submit">
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('LINK_TYPE');?></label>
					<select name="content">
						<?php
						$triggerArray	= array(
											'link'=>JText::_('LINK_SELECT_LINK'), 
											'clickthru1'=>JText::_('LINK_SELECT_CLICK_1'), 
											'clickthru2'=>JText::_('LINK_SELECT_CLICK_2'), 
											'clickthru3'=>JText::_('LINK_SELECT_CLICK_3'), 
											'clickthru4'=>JText::_('LINK_SELECT_CLICK_4'), 
											'clickthru5'=>JText::_('LINK_SELECT_CLICK_5'));
						foreach($triggerArray as $key=>$value) {
						?>
						<option value="<?php echo $key;?>"><?php echo $value;?></option>
						<?php
						}
						?>
					</select>
				</li>
				<li>
					<label><?php echo JText::_('LINK_LINK');?></label>
					<input type="text" name="link" placeholder="<?php echo JText::_('LINK_PLACEHOLDER');?>"/>
				</li>
			</ul>
			<div class="evolve-buttons-confirm">
				<?php
					echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
					echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>
	
	<!-- TRIGGER -->
	<div id="origin_modal_trigger" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('TRIGGER_TITLE');?></h2>
		<form name="form_submit">
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('TRIGGER_EVENT');?></label>
					<select name="content">
						<option name="click" value="click">Click</option>
						<option name="hover" value="hover">Hover</option>
					</select>
				</li>
			</ul>			
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>
	
	<!-- REMOVE -->
	<div id="origin_modal_remove" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('REMOVE_TITLE');?></h2>
		<form name="form_submit">
			<p><?php echo JText::_('REMOVE_DESCRIPTION');?></p>
			<input type="hidden" name="id"/>
			<input type="hidden" name="oid"/>
			<input type="hidden" name="sid"/>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_content_update', 'evolve-bg-primary');
				?>
			</div>
			<div class="evolve-buttons-delete">
				<?php echo evolveUi::dialogButton('186', JText::_('BUTTON_DELETE'), 'origin_content_delete', 'evolve-bg-primary');?>
			</div>
		</form>
	</div>
	
	<!-- SETTINGS -->
	<div id="origin_modal_settings" class="evolve-relative origin_modal">
		<h2><?php echo JText::_('SETTINGS_TITLE');?></h2>
		<form name="form_submit">
			<input type="hidden" name="id" value="<?php echo $this->originConfigObj->id;?>"/>
			<ul class="evolve-form evolve-disable-list-style">
				<li>
					<label><?php echo JText::_('SETTINGS_NAME');?></label>
					<input type="text" class="evolve-required" name="name" value="<?php echo $originConfig->name;?>" placeholder="<?php echo JText::_('SETTINGS_NAME_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label>Status</label>
					<select name="status">
						<option value="active" <?php if($originConfig->status === 'active') echo 'selected="selected"';?>>Active</option>
						<option value="inactive" <?php if($originConfig->status === 'inactive') echo 'selected="selected"';?>>Inactive</option>
					</select>
				</li>
				<li>
					<label><?php echo JText::_('SETTINGS_GA');?></label>
					<input type="text" name="ga" value="<?php if(isset($originConfig->ga)) echo $originConfig->ga;?>" placeholder="<?php echo JText::_('SETTINGS_GA_PLACEHOLDER');?>"/>
				</li>
				<li>
					<label><?php echo JText::_('SETTINGS_TEMPLATE');?></label>
					<select name="type">
						<?php
						foreach($originType->originType as $key=>$value) {
						$selected	= ($key == $originConfig->type)? "selected='selected'": "";
						?>
						<option value="<?php echo $key;?>"<?php echo $selected;?>><?php echo $value;?></option>
						<?php
						}
						?>
					</select>
				</li>
				<li>
					<label><?php echo JText::_('SETTINGS_BG_DEFAULT');?></label>
					<input type="text" readonly="readonly" name="bgDefault" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>" value="<?php if(isset($originConfig->bgDefault)) echo $originConfig->bgDefault;?>"/>
				</li>
				<li>
					<label><?php echo $jtext_settings_bg_expand;?></label>
					<input type="text" readonly="readonly" name="bgExpand" class="uploadInput" placeholder="<?php echo JText::_('UPLOAD_PLACEHOLDER');?>" value="<?php if(isset($originConfig->bgExpand)) echo $originConfig->bgExpand;?>"/>
				</li>
				<li>
					<label>
						<?php echo JText::_('SETTINGS_BG_HEX');?>
					</label>
					<input type="text" name="bgHex" class="evolve-miniColors" value="<?php echo $originConfig->bgHex;?>"/>
				</li>
			</ul>
			<h4><?php echo JText::_('SETTINGS_EMBED');?></h4>
			<textarea name="embed"><?php if(isset($originConfig->embed)) echo $originConfig->embed;?></textarea>
			<div class="evolve-buttons-confirm">
				<?php
				echo evolveUi::dialogButton('56', JText::_('BUTTON_CANCEL'), 'origin_cancel', 'evolve-bg-primary');
				echo evolveUi::dialogButton('67', JText::_('BUTTON_SAVE'), 'origin_config_save', 'evolve-bg-primary');
				?>
			</div>
		</form>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_default" data-form="form_submit" data-input="bgDefault">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
		<form id="" class="evolve-ajaxFileUploader-form evolve-absolute origin_upload_secondary" data-form="form_submit" data-input="bgExpand">
			<?php echo evolveUi::uploadButton('189', '', '', 'evolve-bg-primary origin_upload_button', 'origin_upload_input');?>
			<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $origin_id;?>/"/>
		</form>
	</div>
	
	
	<!-- GENERATE EMBED -->
	<div id="origin_list_embed_modal" class="evolve-relative origin_modal">
			
			<h2><?php echo JText::_('LIST_EMBED_TITLE');?></h2>
			<form>
				<input type="hidden" name="id" value="<?php echo $origin_id;?>"/>
				<input type="hidden" name="bgHex" value="<?php echo $originConfig->bgHex;?>"/>
				<input type="hidden" name="configURL" value="<?php echo "http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&view={$originConfig->type}&format=raw&id={$origin_id}"?>"/>
				<input type="hidden" name="previewLink"/>
				<ul class="evolve-form evolve-disable-list-style">
					<li id="list_embed_input_auto">
						<input type="checkbox"/>
						<span class="list_embed_disabled">
							<label><?php echo JText::_('LIST_EMBED_AUTO_OPEN');?></label>
							<input type="text" name="auto" value="0" disabled="disabled" data-default="0"/>/24hrs
						</span>
					</li>
					<li id="list_embed_input_close">
						<input type="checkbox"/>
						<span class="list_embed_disabled">
							<label><?php echo JText::_('LIST_EMBED_AUTO_CLOSE');?></label>
							<input type="text" name="close" value="0" disabled="disabled" data-default="0"/> seconds
						</span>
					</li>
					<li id="list_embed_input_hover">
						<input type="checkbox"/>
						<span class="list_embed_disabled">
							<label><?php echo JText::_('LIST_EMBED_HOVER');?></label>
							<input type="text" name="hover" value="0" disabled="disabled" data-default="0"/> seconds
						</span>
					</li>
					<?php for($i=1; $i < 6; $i++) { ?>	
					<li id="list_embed_input_clickthru<?php echo $i;?>">
						<input type="checkbox"/>
						<span class="list_embed_disabled">
							<label><?php echo JText::_('LIST_EMBED_CLICKTHRU_'.$i);?></label>
							<input type="text" name="clickthru<?php echo $i;?>" class="list_embed_input_clickthru" disabled="disabled" data-default="" placeholder="<?php echo JText::_('LIST_EMBED_CLICKTHRU_PLACEHOLDER');?>"/>
						</span>
					</li>	
					<?php }//End loop ?>
				</ul>
				<textarea name="origin_list_embed_code" id="origin_list_embed_code" readonly="readonly"></textarea>
				<div class="evolve-buttons-confirm">
					<a id="origin_list_embed_preview" class="evolve-ui-button evolve-bg-primary" href="" target="_blank" style="display: none">
						<span class="evolve-ui-icon evolve-ui-icon198"></span>
					</a><!--
				--><?php 
					//echo evolveUi::dialogButton('44', JText::_('BUTTON_GENERATE'), 'origin_list_embed_generate', 'evolve-bg-primary');
					echo evolveUi::dialogButton('125', JText::_('BUTTON_EMAIL'), 'origin_list_embed_email', 'evolve-bg-primary');
					?>
				</div>
				<div class="evolve-buttons-delete">
					<?php echo evolveUi::dialogButton('56', JText::_('BUTTON_CLOSE'), 'origin_cancel', 'evolve-bg-primary');?>
				</div>
			</form>
		</div>