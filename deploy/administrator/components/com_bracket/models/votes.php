<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class BracketModelVotes extends JModel
{
	
	const ASSETS_PATH = 'assets/components/com_bracket';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function addVote($bracket_id, $vote, $rival, $period) {
		$db =& JFactory::getDBO();
		
		//sanity check the passed in values
		if (!is_numeric($bracket_id) || !is_numeric($vote) || !is_numeric($rival) || !is_numeric($period)) {
			return false;
		}
		
		$ip = ''; //TODO: Replace with x-forwarded-for if required
		
		$sql = "INSERT INTO #__bracket_votes (bracket_id, periods_position, entries_position, ip) VALUES($bracket_id, $period, $vote, '$ip')";
		$db->setQuery($sql);
		$db->query();
		
		$sql = "SELECT count(*) AS votes FROM #__bracket_votes WHERE bracket_id = $bracket_id AND periods_position = $period AND entries_position = $vote";
		$db->setQuery($sql);
		$db->query();
		$vote_count = $db->loadResult();
		
		$sql = "SELECT count(*) AS votes FROM #__bracket_votes WHERE bracket_id = $bracket_id AND periods_position = $period AND entries_position = $rival";
		$db->setQuery($sql);
		$db->query();
		$rival_count = $db->loadResult();
		
		$ret = array();
		$ret['voted']['id'] = $vote;
		$ret['voted']['votes'] = $vote_count;
		$ret['rival']['id'] = $rival;
		$ret['rival']['votes'] = $rival_count;
		
		return $ret;
	}
	
	
	
}