<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$evolveObj		= new evolveHelper();
?>
<fieldset id="syndi_qas_list" class="syndi_list sortable">
		<?php		
		if(empty($this->syndiTab)) {
			echo JText::_('QA_FORM_NO_QAS');
		} else {
			foreach($this->syndiTab as $key=>$qa) {
				$class 	= ($key%2 == 0) ? "even" : "odd";
				$content	= $evolveObj->strMultilineContent($qa->description);
		?>
				<div id="qa_<?php echo $qa->qa_id;?>" class="syndi_data_list <?php echo $class;?>">
					<div class="syndi_right">
						<ul>
							<li>
								<label><?php echo JText::_('QA_TITLE');?></label>
								<span><?php echo $qa->title;?></span>
							</li>
							<li>
								<label><?php echo JText::_('QA_DESCRIPTION');?></label>
								<span><?php echo stripslashes($content);?></span>
							</li>
							<li>
								<label><?php echo JText::_('QA_EMAIL');?></label>
								<span><?php echo $qa->email;?></span>
							</li>
						</ul>
					</div>
					<div name="syndi_data_list_serialize" style="display: none;"><?php echo json_encode($qa);?></div>
					<input type="hidden" name="ordering[]" value="<?php echo $qa->qa_id;?>"/>
					<a href="#" class="syndi_list_edit options"><?php echo JText::_('LIST_EDIT');?></a>
					<a href="#" class="syndi_list_delete options"><?php echo JText::_('LIST_DELETE');?></a>
				</div>
		<?php
			}
		}
		?>
		<input type="hidden" name="typetab" value="qa"/>
</fieldset>