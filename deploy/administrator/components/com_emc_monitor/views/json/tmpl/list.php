<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$monitor	= $this->monitor;
	$monitorTotal	= $this->monitor->totals; 
	
	$index = 0;
	$monitorList['total']->totalEvents = $monitorTotal->{"ga:totalEvents"};
	$monitorList['total']->uniqueEvents = $monitorTotal->{"ga:uniqueEvents"};
	
	foreach($monitor->data as $key=>$item) {
		$index++;
		$monitorList['data'][$index]->category = $key;
		$monitorList['data'][$index]->categoryEncode = urlencode($key);
		$monitorList['data'][$index]->totalEvents = $item->{"ga:totalEvents"};
		$monitorList['data'][$index]->uniqueEvents = $item->{"ga:uniqueEvents"};
		/*$monitorList[$index]->category = $key;
		$monitorList[$index]->totalEvents = $item->{"ga:totalEvents"};
		$monitorList[$index]->uniqueEvents = $item->{"ga:uniqueEvents"};*/
	
	}
	echo json_encode($monitorList);
	//echo json_encode($this->monitor);
?>