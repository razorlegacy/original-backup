<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	//Grab module config
	$footer		= $params->get('footer');
	$craveRU	= $params->get('craveRU');
	$tracking	= $params->get('tracking');
	$trackingNo	= $params->get('randTracking');

	$add_to_head 	= &JFactory::getDocument();
	$add_to_head->addStyleSheet('/modules/mod_si_footer/tmpl/css/footer_'.$footer.'.css');
	require_once(JModuleHelper::getLayoutPath('mod_si_footer', $footer));
	
	if($craveRU) {
		$output 	.= "<script type='text/javascript' src='http://cdn.assets.craveonline.com/js/rollup_include/rollup.js'></script>
";
	}
/*
		
	if($tracking) {
	
		echo "DEBUG:".$randTime;
	
		if(isset($randTime)) {
			//Creates random time for tracking pixel if not initialized yet
			$randTime 	= array_sum(explode(' ', microtime())) * 100;
		}
		
		$output 	.= str_replace($trackingNo, $randTime, $tracking);
	}
	
*/
	echo $output;
?>