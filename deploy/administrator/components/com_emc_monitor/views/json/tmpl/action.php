<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$monitor	= $this->monitor;
	$monitorTotal	= $this->monitor->totals; 
	
	$index = 0;
	$monitorAction['category']->category = $this->category;
	$monitorAction['total']->totalEvents = $monitorTotal->{"ga:totalEvents"};
	$monitorAction['total']->uniqueEvents = $monitorTotal->{"ga:uniqueEvents"};

	foreach($monitor->data as $key=>$item) {
		$index++;
		$monitorAction['data'][$index]->action = $key;
		$monitorAction['data'][$index]->totalEvents = $item->{"ga:totalEvents"};
		$monitorAction['data'][$index]->uniqueEvents = $item->{"ga:uniqueEvents"};
		
	}
	echo json_encode($monitorAction);
?>