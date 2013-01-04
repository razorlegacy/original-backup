<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
	$j(function() {
		syndiCreate.init();
	});
	
	 var timestamp	= new Date();
</script>
<form action="index.php" method="POST" name="adminForm">
       <table class="adminlist">
             <thead>
                    <tr>
                           <th width="10">ID</th>
                           <th width="10"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>)" /></th>
                           <th><?php echo JText::_('LIST_NAME');?></th>
                           <?php
                           	if($this->userObj->checkACL($this->minACL)) {
								echo "<th>".JText::_('LIST_MANAGER')."</th>";
							}
							?>
							<th><?php echo JText::_('LIST_PREVIEW');?></th>
						   <th><?php echo JText::_('LIST_DFPLINK');?></th>
                    </tr>              
             </thead>
             <tbody>
		        <?php
		        if(empty($this->syndi)) {
				?>
					<tr>
						<th colspan='6' align='center'><?php echo JText::_('LIST_EMPTY');?></th>
					</tr>
				<?php
				} else {
				
                    $k = 0;
                    $i = 0;
                    for ($i=0, $n=count( $this->syndi ); $i < $n; $i++) {
						$row = &$this->syndi[$i];
							
						$checked 	= JHTML::_('grid.id', $i, $row->sid);
                        $link 		= JRoute::_('index.php?option='.JRequest::getVar('option').'&task=createSyndi&sid='. $row->sid.'&format=raw');
                        $dfp		= JRoute::_('http://'.$_SERVER["HTTP_HOST"].'/index.php?option=com_syndi&view=display&format=raw&sid='.$row->sid.'&minified=1');
                        $preview	= JRoute::_('http://'.$_SERVER["HTTP_HOST"].'/index.php?option=com_syndi&view=display&format=raw&sid='.$row->sid.'&cache='.rand());
                        $user		=& JFactory::getUser($row->manager);
                        
                       ?>            
					   <tr class="<?php echo "row$k";?>">
                          <td><?php echo $row->sid;?></td>
                          <td><?php echo $checked; ?></td>
						  <td>
						  <span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Syndi' );?>::<?php echo $row->syndi_name; ?>">
						  <a href="<?php echo $link;?>" class="editSyndi"><?php echo $row->syndi_name;?></a>
						  </td>
						  <?php
						  	if($this->userObj->checkACL($this->minACL)) {
						  		echo "<td align='center'>{$user->name}</td>";
						  	}
						  ?>
						  <td align="center" class="ui-state-active"><a href="<?php echo $preview;?>" class="colorbox ui-icon ui-icon-newwin">LINK</a></td>
						  <td align="center"><?php echo $dfp;?></td>
						</tr>
                    <?php
                    $k = 1 - $k;
                    }
				}
				?>
             </tbody>
       </table>
      
       <input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
       <input type="hidden" name="task" value=""/>
       <input type="hidden" name="boxchecked" value="0"/>   
       <input type="hidden" name="hidemainmenu" value="0"/> 
</form>
