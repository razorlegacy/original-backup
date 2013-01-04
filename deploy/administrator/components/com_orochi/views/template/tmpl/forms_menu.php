<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate			= new orochiTemplate();
	$menuId					= (isset($this->mid))?$orochiTemplate->object_search($this->mid, 'id', $this->orochiMenu):'';
	$menuObj				= (!empty($menuId))? $this->orochiMenu[$menuId[0]]: '';
	$menuContent			= (!empty($menuId))? json_decode($menuObj->content): '';
	
?>
	<form id="orochi_setup_menu" class="orochi-border orochi-bg-secondary">
		<ul class="disable-list-style orochi-form">
			<li>
				<label class="inline"><?php echo JText::_('SETUP_MENU_TITLE');?></label>
				<input type="text" name="title" class="inline websvc-required" placeholder="<?php echo JText::_('SETUP_MENU_TITLE_PLACEHOLDER');?>" value="<?php echo (isset($menuContent->title)) ? $menuContent->title:'';?>" title="<?php echo JText::_('REQUIRED');?>"/>
			</li>
			<li class="orochi-uploadify">
				<label class="inline"><?php echo JText::_('SETUP_MENU_TAB_BG');?></label>
				<?php echo $orochiTemplate->uploadify((isset($menuContent->menu_page_bg))?$menuContent->menu_page_bg:'', 'menu_page_bg');?>
			</li>
			<li class="orochi-uploadify">
				<label class="inline"><?php echo JText::_('SETUP_MENU_BG');?></label>
				<?php echo $orochiTemplate->uploadify((isset($menuContent->menu_bg))?$menuContent->menu_bg:'', 'menu_bg');?>
			</li>
			<li>
				<label class="inline"><?php echo JText::_('SETUP_MENU_LINK');?></label>
				<input type="text" name="link" class="inline" placeholder="<?php echo JText::_('SETUP_MENU_LINK_PLACEHOLDER');?>" value="<?php echo (isset($menuContent->link))?$menuContent->link:'';?>"/>
			</li>
		</ul>
		<input type="hidden" name="id" value="<?php echo (isset($menuObj->id))?$menuObj->id:'';?>"/>
<!-- 		<input type="button" name="setup_workspace_add_menu_submit" value="<?php echo JText::_('SETUP_MENU_SUBMIT');?>"/> -->
		<div class="orochi_submit_buttons">
			<a href="#" class="button orochi-button orochi-bg-primary" name="menu_reset">
				<span class="icon icon188"></span>
				<span class="label"><?php echo JText::_('FORM_RESET');?></span>
			</a>
			<a href="#" class="button orochi-button orochi-bg-primary" name="menu_add">
				<span class="icon icon44"></span>
				<span class="label"><?php echo JText::_('MENU_SUBMIT');?></span>
			</a>
		</div>			
	</form>