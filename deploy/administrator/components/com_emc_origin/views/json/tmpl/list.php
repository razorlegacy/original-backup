<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$originList		= $this->origin;
	
	foreach($originList as $key=>$item) {
		$originList[$key]->config		= json_decode($item->config);
		$originList[$key]->content		= json_decode($item->content);
		$originList[$key]->type			= $originList[$key]->config->type;
		$originList[$key]->manager		= JFactory::getUser($item->manager)->name;
		$originList[$key]->modified_by	= JFactory::getUser($item->modified_by)->name;
		$originList[$key]->create_date	= date('n.j.y \a\t\ G:i T', strtotime($item->create_date));
		$originList[$key]->modify_date	= date('n.j.y \a\t\ G:i T', strtotime($item->modify_date));
		//$originList[$key]->bgDefault	= "/assets/components/com_emc_origin/{$item->id}/{$originList[$key]->config->bgDefault}";
		//$originList[$key]->bgExpand		= "/assets/components/com_emc_origin/{$item->id}/{$originList[$key]->config->bgExpand}";
		$originList[$key]->status		= ($originList[$key]->config->status === 'inactive')? 'inactive': 'active';
	}
	
	echo json_encode($originList);
?>