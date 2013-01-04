<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$originConfig		= $this->originObj['config'];
	$originConfigObj	= json_decode($originConfig->config);
	$originContent		= $this->originObj['content'];
	//$bg					= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$originConfig->id}/";
/*
	
	switch($this->originWrapper) {
		case "default":
			$bg	.= $originConfigObj->bgDefault;
			break;
		case "expand":
			$bg .= $originConfigObj->bgExpand;
			break;
	}
*/
?>
	<div id="wrapper">
		<?php
		foreach($originContent as $keyS=>$schedule) {
			$startDate		= strtotime($schedule->start_date) * 1000;
			$endDate		= strtotime($schedule->end_date) * 1000;
		?>
			<div id="schedule-<?php echo $schedule->id;?>" class="schedule" data-startdate="<?php echo $startDate;?>" data-enddate="<?php echo $endDate;?>">
			<?php
			foreach($schedule->content[$this->originWrapper] as $keyC=>$content) {
				$contentObj		= json_decode($content->content);
				$configObj		= json_decode($content->config);
				$zIndex			= !empty($configObj->zIndex)? $configObj->zIndex: 0;
				
				$style			= " style='top:{$configObj->coordY}px;left:{$configObj->coordX}px;z-index:{$zIndex};width:{$configObj->width}px;height:{$configObj->height}px'";
				?>
				<div id="content-<?php echo $content->id;?>" class="content content-<?php echo $configObj->type;?>"<?php echo $style;?>>
					<?php
					$this->assignRef('contentObj', $contentObj);
					$this->setLayout('content-'.$configObj->type);
					echo $this->loadTemplate();
					?>
				</div>
			<?php
			}
			?>
			</div>
		<?php
		}
		?>	
	</div>