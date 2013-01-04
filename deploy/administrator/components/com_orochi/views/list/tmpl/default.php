<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	$user 				=& JFactory::getUser();
	$acl				= new evolveUserHelper();
	$orochiTemplate		= new orochiTemplate();
?>
	<script type="text/javascript">
		$j(function() {
			orochiCreate.init();
			orochiHelp.init();
			
			$j('table.adminlist').tablesorter({
				cssHeader: 	'evolve-tablesorter-header',
                cssAsc: 	'evolve-tablesorter-headerSortUp',
                cssDesc: 	'evolve-tablesorter-headerSortDown',
				headers: {
					0: {sorter: false},
					4: {sorter: false}
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
		<div id="evolve-toolbar-title" class="evolve-inline"><?php echo JText::_('TOOLBAR_TITLE');?></div>
		<div id="evolve-toolbar-buttons" class="evolve-inline">
		<?php
			echo evolveUi::dialogButton('105', JText::_('TOOLBAR_HELP'), 'toolbar_help', 'evolve-bg-primary');
			if($acl->checkACL(1)) echo evolveUi::dialogButton('186', JText::_('TOOLBAR_DELETE'), 'toolbar_delete', 'evolve-bg-primary');
		?>
		</div>
	</div>
	<div id="orochi">
		
		
		<div id="orochi_list_create" class="evolve-border evolve-shadow evolve-bg-secondary">
			<form class="evolve-form orochi-form" method="post">

				<div class="evolve-absolute" id="evolve-create-icon">
					<label class="evolve-buttons-title"><?php echo JText::_('LIST_CREATE_NEW');?></label>
				</div>
				<input type="text" id="evolve-create-input" name="title" id="title" class="evolve-required evolve-inline" placeholder="<?php echo JText::_('LIST_CREATE_NEW_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>"/>

				<div id="evolve-create-button" class="evolve-inline">
				<?php
					echo evolveUi::dialogButton('3', JText::_('LIST_CREATE_SAVE'), 'orochi_create', 'evolve-bg-primary');
				?>		
				</div>
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
				<input type="hidden" name="task" value="saveOrochi"/>
				<input type="hidden" name="hidemainmenu" value="1"/>
				<input type="hidden" name="manager" value="<?php echo $user->id;?>"/>
				<input type="hidden" name="modified_by" value="<?php echo $user->id;?>"/>
			</form>
		</div>
	
	
	
<!--
		<div id="orochi_list_create" class="inline orochi-border orochi-shadow orochi-bg-secondary">
			<h2 class="orochi-title"><?php echo JText::_('LIST_CREATE_NEW');?></h2>
			<form class="orochi-form" method="post">
				<ul class="disable-list-style">
					<li>
						<label class="inline"><?php echo JText::_('CREATE_NAME');?></label>
						<input type="text" name="title" id="title" class="websvc-required" placeholder="Name of Syndi" value="<?php //echo $this->orochi->title;?>" title="<?php echo JText::_('REQUIRED');?>"/>
					</li>
				</ul>
				<div class="orochi_submit_buttons">
					<a href="#" class="button orochi-button orochi-bg-primary" name="orochi_create">
						<span class="icon icon44"></span>
						<span class="label"><?php echo JText::_('LIST_CREATE_SAVE');?></span>
					</a>
				</div>				
				<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
				<input type="hidden" name="task" value="saveOrochi"/>
				<input type="hidden" name="hidemainmenu" value="1"/>
				<input type="hidden" name="manager" value="<?php //echo $user->id;?>"/>
			</form>
		</div>
-->
		<div id="orochi_list" class="inline orochi-border orochi-shadow orochi-bg-primary">
			<form action="index.php" method="POST" name="adminForm">
				<table class="adminlist">
					<thead>
						<tr>
							<th width="5">&nbsp;</th>
							<th width="50">ID</th>
							<th><?php echo JText::_('LIST_NAME');?></th>
							<th width="100"><?php echo JText::_('LIST_MANAGER');?></th>
							<th width="250"><?php echo JText::_('LIST_PREVIEW');?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(empty($this->orochi)) {
					?>
						<tr>
							<td colspan="5" align="center"><?php echo JText::_('LIST_EMPTY');?></td>
						</tr>
					<?php
					} else {
						foreach($this->orochi as $key=>$orochi) {
							$row		= ($key%2)? "orochi-bg-secondary": "orochi-bg-primary";
							$checkbox 	= JHTML::_('grid.id', $key, $orochi->id);
							$edit		= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=editOrochi&id='.$orochi->id.'&hidemainmenu=1');
							$preview	= "http://{$_SERVER["HTTP_HOST"]}/index.php?option=com_orochi&view=display&format=raw&id={$orochi->id}";
							$user		=& JFactory::getUser($orochi->manager);
					?>
						<tr class="<?php echo $row;?>">
							<td align="center">
								<?php echo $checkbox;?>
							</td>
							<td align="center">
								<?php echo $orochi->id;?>
							</td>
							<td>
								<a href="<?php echo $edit;?>"><?php echo $orochi->title;?></a>
							</td>
							<td align='center'>
								<?php echo $user->name;?>
							</td>
							<td data-config="<?php echo $preview;?>" data-id="<?php echo $orochi->id;?>">
								<div class="orochi_list_preview">
								<?php
								$typeArray	= array('250', '600');
								foreach($typeArray as $value) {
								?>
									<div class="orochi_list_preview_<?php echo $value;?>">
										<a href="<?php echo $preview."&type=".$value."&cache=".rand();?>" class="button on orochi-tips orochi-bg-tertiary" target="_blank" title="<?php echo JText::_('PREVIEW_'.$value.'_TIP');?>">
											<span class="icon icon19"></span>
											<span class="label"><?php echo JText::_('PREVIEW_'.$value);?></span>
										</a>
										<!-- <input type="text" class="orochi-tips" readonly="readonly" value="<?php echo $preview."&type=".$value;?>" title="<?php echo JText::_('TRAFFICKING_LINK_TIP');?>"/> -->
									</div>
								<?php
								}
								echo evolveUi::dialogButton('119', 'Generate Embed', 'syndi_list_embed', 'syndi_list_embed evolve-bg-primary');
								?>
								</div>
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
		<div class="evolve-hidden">
			<div id="syndi_list_embed_modal">
				<form>
					<input type="hidden" name="link">
					<input type="hidden" name="id">
					<ul class="evolve-disable-list-style evolve-form">
						<li>
							<label>Syndi Size</label>
							<select name="syndi_height">
								<option value="250">300x250</option>
								<option value="600">300x600</option>
							</select>
						</li>
					</ul>
					<textarea name="syndi_list_embed_code" id="syndi_list_embed_code" readonly="readonly"></textarea>
					<div class="evolve-buttons-confirm">
						<?php 
						//echo evolveUi::dialogButton('44', JText::_('BUTTON_GENERATE'), 'origin_list_embed_generate', 'evolve-bg-primary');
						echo evolveUi::dialogButton('125', JText::_('EMAIL'), 'syndi_list_embed_email', 'evolve-bg-primary');
						?>
					</div>
					<div class="evolve-buttons-delete">
						<?php echo evolveUi::dialogButton('56', JText::_('CLOSE'), 'syndi_cancel', 'evolve-bg-primary');?>
					</div>
				</form>
			</div>
		</div>
	</div>
