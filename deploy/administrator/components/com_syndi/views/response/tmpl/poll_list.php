<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
<fieldset id="syndi_poll_list" class="syndi_list sortable">
		<?php
		if(empty($this->syndiTab)) {
			echo JText::_('POLL_FORM_NO_POLLS');
		} else {
			foreach($this->syndiTab as $key=>$poll) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
		?>
			<div id="poll_<?php echo $poll->poll_id;?>" class="syndi_data_list poll_list <?php echo $class;?>">
				<div class="syndi_right">
					<ul>
						<li>
							<label><?php echo JText::_('POLL_TITLE');?></label>
							<span><?php echo $poll->title;?></span>
						</li>
						<li>
							<label><?php echo JText::_('POLL_ID');?></label>
							<span><?php echo $poll->polldaddy_key;?></span>
						</li>
					</ul>
				</div>
				<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($poll);?></div>
				<input type="hidden" name="ordering[]" value="<?php echo $poll->poll_id;?>"/>
				<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
			</div>
		<?php
			}//end foreach
		}//end else
		?>
		<input type="hidden" name="typetab" value="poll"/>
		<input type="hidden" name="tab_id" value="<?php echo $poll->tab_id;?>"/>
</fieldset>