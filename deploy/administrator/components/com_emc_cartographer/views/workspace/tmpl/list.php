<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	$user 			=& JFactory::getUser();
	$acl			= new evolveUserHelper();
?>
	<script type="text/javascript">
		$j(function() {
			cartographerCreate.init();
			$j('#cartographer_list table').tablesorter({
				cssHeader: 	'evolve-tablesorter-header',
                cssAsc: 	'evolve-tablesorter-headerSortUp',
                cssDesc: 	'evolve-tablesorter-headerSortDown',
				headers: {
					0: {sorter: false},
					3: {sorter: false}
				},
				sortList: [[1,1]],
				widgets: ['zebra'],
				widgetZebra: {
                    css: ['evolve-bg-secondary', 'evolve-bg-primary']
                }
			});
		});
	</script>
	
	<div id="evolve-toolbar" class="evolve-border evolve-bg-tertiary evolve-relative evolve-shadow">
		<div id="cartographer_toolbar_title" class="evolve-inline"><?php echo JText::_('TOOLBAR_TITLE');?></div>
		<div id="cartographer_toolbar_buttons" class="evolve-inline">
		<?php
			echo evolveUi::dialogButton('105', JText::_('TOOLBAR_HELP'), 'toolbar_help', 'evolve-bg-primary');
			if($acl->checkACL(1)) echo evolveUi::dialogButton('186', JText::_('TOOLBAR_DELETE'), 'toolbar_delete', 'evolve-bg-primary');
		?>
		</div>
	</div>
	
	<div id="cartographer_wrapper">
		
		<div id="cartographer_list_create" class="evolve-border evolve-shadow evolve-bg-secondary">
			<form class="evolve-form" method="post">

				<div class="evolve-absolute" id="cartographer_create_icon">
					<label class="evolve-buttons-title"><?php echo JText::_('LIST_CREATE_NEW');?></label>
				</div>

				<input type="text" id="cartographer_create_input" name="name" id="name" class="evolve-required evolve-inline" placeholder="<?php echo JText::_('LIST_CREATE_NEW_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"/>

				<div id="cartographer_create_button" class="evolve-inline">
				<?php
					echo evolveUi::dialogButton('3', JText::_('LIST_CREATE_SAVE'), 'cartographer_create', 'evolve-bg-primary');
				?>		
				</div>
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
				<input type="hidden" name="task" value="saveCartographer"/>
				<input type="hidden" name="hidemainmenu" value="1"/>
				<input type="hidden" name="manager" value="<?php echo $user->id;?>"/>
				<input type="hidden" name="modified_by" value="<?php echo $user->id;?>"/>
			</form>
		</div>
		<div id="cartographer_list" class="evolve-border evolve-shadow evolve-bg-secondary">
			<form action="index.php" method="POST" name="adminForm">
				<table class="adminlist">
					<thead>
						<tr>
							<th width="5">&nbsp;</th>
							<th width="50"><?php echo JText::_('LIST_ID');?></th>
							<th width="180"><?php echo JText::_('LIST_NAME');?></th>
							<th width="240"><?php echo JText::_('LIST_PREVIEW');?></th>
							<th width="120"><?php echo JText::_('LIST_MANAGER');?></th>
							<th width="120"><?php echo JText::_('LIST_MODIFIED_BY');?></th>
							<th width="120"><?php echo JText::_('LIST_TIMESTAMP');?></th>
							<th width="100"><?php echo JText::_('LIST_PUBLISHED');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(empty($this->cartographer)) {
					?>
						<tr>
							<td colspan="8" align="center"><?php echo JText::_('LIST_EMPTY');?></td>
						</tr>
					<?php
					} else {
						foreach($this->cartographer as $key=>$cartographer) {
							$row		= ($key%2)? "evolve-bg-secondary": "evolve-bg-primary";
							$checkbox 	= JHTML::_('grid.id', $key, $cartographer->id);
							$edit		= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=editCartographer&id='.$cartographer->id.'&hidemainmenu=1');
							
							$previewImg	= (isset($cartographer->content))?json_decode($cartographer->content)->bg_img:'';
							$previewImg	= ($previewImg)? "/assets/components/com_emc_cartographer/{$cartographer->id}/{$previewImg}": '';
							
							$previewLink= "http://{$_SERVER["HTTP_HOST"]}/index.php?option=com_emc_cartographer&view=display&format=raw&id={$cartographer->id}";
							
							$manager	=& JFactory::getUser($cartographer->manager);
							$modified_by=& JFactory::getUser($cartographer->modified_by);
							
							$timestamp	= date("m/d/y g:i A", strtotime($cartographer->timestamp));
							$published	= ($cartographer->published)? 'evolve-published': 'evolve-unpublished';
					?>
						<tr class="<?php echo $row;?>">
							<td align="center">
								<?php echo $checkbox;?>
							</td>
							<td align="center">
								<?php echo $cartographer->id;?>
							</td>
							<td>
								<a href="<?php echo $edit;?>"><?php echo $cartographer->name;?></a>
							</td>
							<td align="center">
								<?php 
								if($previewImg) {
								?>
								<a href="<?php echo $previewLink;?>" target="_blank" class="cartographer_list_preview_link">
									<img src="<?php echo $previewImg;?>" class="cartographer_list_preview_image"/>
								</a>
								<?php
								} else {
									echo JText::_('LIST_PREVIEW_NONE');
								}
								?>
							</td>
							<td align='center'>
								<?php echo $manager->name;?>
							</td>
							<td align='center'>
								<?php echo $modified_by->name;?>
							</td>
							<td align="center">
								<?php echo $timestamp;?>
							</td>
							<td align="center">
								<div class="evolve-publish-status <?php echo $published;?>" data-id="<?php echo $cartographer->id;?>" data-status="<?php echo $published;?>"><?php echo $published;?></div>
							</td>
						</tr>
					<?php
						}//end foreach
					}//end if empty
					?>
					</tbody>
				</table>
				<input type="hidden" name="boxchecked" value="0"/>
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
				<input type="hidden" name="task" value=""/>
			</form>
		</div>
	</div>