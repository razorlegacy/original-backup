<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$monitor_filter	= $this->monitor->totals; 
	/*$monitorTotal[0]->totalEvents = $monitor_total->{"ga:totalEvents"};
	$monitorTotal[0]->uniqueEvents = $monitor_total->{"ga:uniqueEvents"};*/
	$monitorFilter[0]->startDate = $monitor_filter->{"start_date"};
	$monitorFilter[0]->endDate = $monitor_filter->{"end_date"};
	
	echo json_encode($monitorFilter);
?>