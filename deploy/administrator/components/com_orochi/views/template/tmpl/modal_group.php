<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
?>
	<!-- <form> -->
		<script type="text/javascript">
			var contentList	= new Array();
		</script>
		<input type="hidden" name="mid" value="<?php echo $this->mid;?>"/>
		<input type="hidden" name="gid" value="<?php echo $this->gid;?>"/>
		<?php
		if(!empty($this->contentObj)) {
			foreach($this->contentObj as $key=>$content) {
				$contentObj		= json_decode($content->content);
				$row			= ($key%2)? "orochi-bg-secondary": "orochi-bg-tertiary";
				$indexValue		= array_search($contentObj->type, array_keys($orochiTemplate->tabsType));
			?>
				<div class="orochi_group_item <?php echo $row;?>">
					<div class="orochi_group_item_edit icons_type_small orochi-pointer orochi-tips" style="background-position: <?php echo $indexValue*(-24);?>px 0" title="Edit Content"></div>
					<div class="orochi_group_item_handle">
						<div class="orochi_group_item_title"><?php echo $contentObj->title;?></div>
					</div>
					<div class="orochi_group_item_config">
						<form>
							<a class="button on orochi-tips orochi_group_item_delete" title="Delete Item">
								<span class="icon icon186"></span>
							</a>
							<input type="hidden" name="deleteType" value="deleteContent"/>
							<input type="hidden" name="id" value="<?php echo $content->id;?>"/>
						</form>
					</div>
					
					<input type="hidden" name="ordering[]" value="<?php echo $content->id;?>" />
					<script>$j('.orochi_group_item').data('<?php echo $content->id;?>', <?php echo json_encode($content);?>)</script>
					<!-- <div class="orochi-hidden orochi_group_item_meta"><?php echo json_encode($content);?></div> -->
				</div>
			<?php
			}//END FOREACH CONTENT
		} else {
		?>
			<div id="placeholder_content_list"></div>
		<?php
		}//END IF-ELSE
		?>
	<!-- </form> -->