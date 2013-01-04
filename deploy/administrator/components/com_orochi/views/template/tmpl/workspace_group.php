<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
    $orochiTemplate		= new orochiTemplate();
    /*
    <script type="text/javascript">
							groupObj[<?php echo $this->orochiContent[$cid]->id;?>]	= '<?php echo $this->orochiContent[$cid]->content;?>';
						</script>
    */
?>

	<?php
	if($this->groupObj) {
		$contentIds			= $orochiTemplate->object_search($this->groupObj->id, 'gid', $this->contentObj);
		$linked				= ($this->groupObj->link)? " orochi_workspace_group_linked": "";
	?>
		<div id="orochi_group_<?php echo $this->groupObj->id;?>" class="orochi_workspace_group emcOrochi_group_size_<?php echo $this->groupSize; echo $linked;?>">
			<input type="hidden" name="ordering[]" value="<?php echo $this->groupObj->id;?>"/>
			<input type="hidden" name="size" value="<?php echo $this->groupObj->size;?>"/>
			
			<div class="workspace_group_config">
				<a class="button on orochi-tips workspace_group_edit orochi-bg-secondary" title="Manage Content">
					<span class="icon icon68"></span>
				</a>
				<a class="button on orochi-tips workspace_group_delete orochi-bg-secondary" title="Delete Group">
					<span class="icon icon186"></span>
				</a>
			</div>
			<div class="emcOrochi_group orochi-pointer" id="emcOrochi_group_<?php echo $this->groupObj->id;?>">
			<?php
			if($contentIds) {
				foreach($contentIds as $cid) {
					$content		= json_decode($this->orochiContent[$cid]->content);
					?>
					<div id="" class="emcOrochi_<?php echo $content->type;?> emcOrochi_cycle">
						<script>$j('.emcOrochi_cycle').data('<?php echo $this->orochiContent[$cid]->id;?>', <?php echo $this->orochiContent[$cid]->content;?>)</script>
						<input type="hidden" name="cid" value="<?php echo $this->orochiContent[$cid]->id;?>"/>
					</div>
				<?php
				}
			} else {
					?>
				<div class="orochi_placeholder orochi_placeholder_empty"></div>
				<div class="orochi_placeholder_filler"></div>
			<?php
			}
			?>
			</div>
			<div class="workspace_group_size">
			<?php
				 switch($this->groupSize) {
			    	case 1: echo "169px";
			    			break;
			    	case 2: echo "343px";
			    			break;
			    	case 3: echo "519px";
			    			break;
			    }
			?>
			</div>
			<div class="emcOrochi_group_pager emcOrochi-hidden">
				<a href="#" class="emcOrochi_group_pager_prev emcOrochi-inline"><</a>
				<div class="emcOrochi_group_pager_index emcOrochi-inline"></div>
				<a href="#" class="emcOrochi_group_pager_next emcOrochi-inline">></a>
			</div>
		</div>
	<?php
	} else {
			?>
		<a href="#" class="workspace_group_add orochi_placeholder">new</a>
	<?php
	}
	?>