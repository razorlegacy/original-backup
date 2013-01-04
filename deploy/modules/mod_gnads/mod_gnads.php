<?php defined('_JEXEC') or die('Direct Access to this location is not allowed.');
	$sz				= $params->get('size');
	$extra_params	= $params->get('extra_params');
	$prefix			= $params->get('prefix');
	$sitename		= $params->get('sitename');
	$triggertags	= $params->get('triggertags');
	$extra_triggers = $params->get('extra_triggers');
	$test_mode		= $params->get('test_mode');
	$else_code		= $params->get('else');


	// Grab TemplateUtils to handle the bulk of our variable divination
	jimport('pebblebed.TemplateUtils');
	$utils = new TemplateUtils();

	$zone = (empty($utils->section)) ? 'ros' : $utils->section;
	$ct = $utils->type;
	$ci = $utils->pageid;
	$kw = '';

	// Galleries: CT can be 'photo' or 'gallery' and CI will always be the gallery's ID
	if ($ct == 'photo') {
		// Import the JoomGallery interface class
		require_once(JPATH_ROOT.DS.'components'.DS.'com_joomgallery'.DS.'classes'.DS.'interface.class.php');
		$gallery = new joominterface;
		$ct = 'gallery';

		// If we're in JoomGallery, but not on a photo detail page...
		if (!JRequest::getInt('id')) {
			// Set ct to gallery and ci to the current gallery's id
			$ci = JRequest::getInt('catid');
		} else {
			// Otherwise, look up the current photo's info, and set ct to photo, and ct to the parent gallery's id
			$current = $gallery->getPicture(JRequest::getInt('id'));
			$ci = $current->catid;
		}
	}


	// Grab tags if we're on an article or tag page
	if ($ct == "article" && $ci) {
        $query="SELECT t.name FROM jos_tag_term_real AS t LEFT JOIN jos_tag_term_content_real AS c ON c.tid=t.id WHERE c.cid=".intval($ci);
		$db =& JFactory::getDBO();
		$db ->setQuery($query);

		$results = $db->loadResultArray();
		if (count($results)) {
			$kw = 'kw='.strtr(implode(',', $results), ' ', '-').';';
		}
	} else if ($utils->view == 'tag') {
		$kw = 'kw='.JoomlaTagsHelper::urlTagName(JRequest::getString('tag')).';';
	}


	// And if our testing mode is on, change ct = testing
	if ($test_mode) $ct = "testing";


	// TriggerTag logic
	if ($triggertags) {
		$trigger_on = 'if ( ';
	
		if ($extra_triggers) $trigger_on .= "$extra_triggers && ";

		$trigger_on .= "(typeof gn_ads == 'undefined' || gn_ads.is_triggered('$sz',zone)) ) {";
	} else {
		$trigger_on = '';
	}

	if ($triggertags && $else_code) {
		$trigger_off = "} else { $else_code }";
	} else if ($triggertags) {
		$trigger_off = "}";
	} else {
		$trigger_off = '';
	}

	if($prefix != "") {
		$sect = $prefix;
	} else {
		$sect = $prefix."'+zone+'";
	}

	// And the ad tag
	echo "
		<!-- BEGIN GN Ad Tag for {$sitename} {$sz} {$zone} -->
		<div style='text-align:center; font-size:0;' class='ad'>
			<script type='text/javascript'>
				var zone = '{$zone}';
				{$trigger_on}
					if (typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if (typeof(gnm_tile) == 'undefined') gnm_tile=1; document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.{$sitename}/{$sect};sect={$sect};sz={$sz};ct={$ct};ci={$ci};{$kw}{$extra_params}tile='+(gnm_tile++)+';ord=' + gnm_ord + '?\" type=\"text/javascript\"></scr' + 'ipt>')
				{$trigger_off}
			</script>
		</div>
		<!-- END AD TAG -->
	";
?>
