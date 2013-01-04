<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
    
    $orochiConfig	= json_decode($this->orochi->content);
    //$menuPosition	= $orochiConfig->{'tab_position_'.$this->type};
	//pagePosition	= ($this->type == '250')? :;
?>
	<div id="workspace_unit_header_<?php echo $this->type;?>" class="orochi_workspace_header"></div>
	<div id="workspace_unit_wrapper_<?php echo $this->type;?>" class="workspace_unit_wrapper orochi_tabs emcOrochi_body">
		<ul id="workspace_unit_menu_<?php echo $this->type;?>" class="list-inline orochi_workspace_menu emcOrochi_menu_<?php echo $orochiConfig->{'tab_position_'.$this->type};?>"><!--
			<?php
			$width	= (!empty($this->menu))?floor(300/count($this->menu)):0;
			
			foreach($this->menu as $menu) {
				$menuObj	= json_decode($menu->content);
				$link		= ($menuObj->link)? $menuObj->link: "#orochi_page_".$menu->id;
				$tabClass	= ($menuObj->menu_bg)? "emcOrochi_tab_bg": "emcOrochi_tab_hex";
				$tabBg		= ($menuObj->menu_bg)? "background-image: url({$menuObj->menu_bg});": "";
				?>
				--><li class="unit_menu_item emcOrochi_tab <?php echo $tabClass;?>" style="width: <?php echo $width;?>px;<?php echo $tabBg;?>" >
						<span class="icon_ui icon_edit orochi-tips orochi-border" title="Edit Menu">edit</span>
						<a href="<?php echo $link;?>" class="inline"><?php echo $menuObj->title;?></a>
						<span class="icon_ui icon_delete orochi-tips orochi-border" title="Delete Menu">delete</span>
						<input type="hidden" name="ordering[]" value="<?php echo $menu->id;?>"/>
						<!-- <div class="orochi-hidden orochi_menu_meta"><?php echo json_encode($menu);?></div> -->
					</li><!--
				<?php
			}
			?>
		--></ul>
		<?php
			foreach($this->menu as $menu) {
				$menuObj	= json_decode($menu->content);
				$groupIds	= $orochiTemplate->object_search($menu->id, 'mid', $this->orochiGroups);
				
				if(!$menuObj->link) {
					$pageBg		= ($menuObj->menu_page_bg)? "background: transparent url({$menuObj->menu_page_bg}) no-repeat 0 0; ": "";
				?>
					<div id="orochi_page_<?php echo $menu->id;?>" class="orochi_workspace_page emcOrochi_page emcOrochi_page_<?php echo $orochiConfig->{'tab_position_'.$this->type};?>" style="<?php echo $pageBg;?>">
						<?php
						$this->assignRef('contentObj', $this->orochiContent);
						$groupObj	= "";
						
						if($this->type == '250') {
							//Pull linked group
							foreach($groupIds as $gid) {
								if($this->orochiGroups[$gid]->link) {
									$groupObj	= $this->orochiGroups[$gid];
									break;
								}
							}
							$groupSize	= 1;
							$this->assignRef('groupObj', $groupObj);
							$this->assignRef('groupSize', $groupSize);
							$this->setLayout('workspace_group');
							echo $this->loadTemplate();
							
						} else if($this->type == '600') {
							for($i = 0; $i<3; $i++) {
								$groupObj	= $this->orochiGroups[$groupIds[$i]];
								$groupSize	= $groupObj->size;
								
								$this->assignRef('groupObj', $groupObj);
								$this->assignRef('groupSize', $groupSize);
								$this->setLayout('workspace_group');
								echo $this->loadTemplate();
							}
						}
						?>
					</div>
				<?php
				}//END IF MENU LINK
			}//END FOREACH MENU	
		?>
	</div>
	