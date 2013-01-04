<?php 
	defined('_JEXEC') or die();
?>	
	<ul id="syndi_tabs">
		<?php
		foreach($this->tabsObj as $tab) {
		?>
			<li title="<?php echo $tab->alias.'_'.$tab->tab_id;?>">
				<span class="ui-icon ui-icon-pencil ui-tab-edit" title="Edit">Edit Tab</span>
				<a href="#<?php echo $tab->alias.'_'.$tab->tab_id;?>" rel="<?php echo $tab->tab_id;?>" class='ui-tab-name'><?php echo $tab->title;?></a>
				<input type="hidden" name="tab_id[]" value="<?php echo $tab->tab_id;?>"/>
				<input type="hidden" name="typetab[]" value="<?php echo $tab->typetab;?>"/>
				<span class="ui-icon ui-icon-circle-close ui-tab-delete" title="Delete">Remove Tab</span>
			</li>
		<?php
		}
		?>
			<li class="ui-state-stationary">
				<a href="#syndi_add_tab">+Add Tab</a>
			</li>
	</ul>