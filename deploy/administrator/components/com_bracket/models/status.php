<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class BracketModelStatus extends JModel
{
	
	const ASSETS_PATH = 'assets/components/com_bracket';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getBracketConfiguration($bracketId) {
		$db =& JFactory::getDBO();
		$total_entries = 16;
		
		//sanity check the passed in values
		if (!is_numeric($bracketId)) {
			return false;
		}
		
		//make sure a bracket with the given id exists
		$sql = "SELECT count(*) FROM #__bracket WHERE id = $bracketId";
		$db->setQuery($sql);
		$db->query();
		$bracket_valid = $db->loadResult();
		if (!$bracket_valid) {
			return false;
		}
		
		$ret = array();
		
		//get general bracket info
		$sql = "SELECT id, name, created, preroll, published FROM #__bracket WHERE id = $id";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssoc();
		foreach ($resultArray as $key => $val) {
			$ret[$key] = $val;
		}
		
		//get period data
		$sql = "SELECT `id`, `bracket_id`, `position`, DATE_FORMAT(`date`, '%m-%d-%Y') AS `date` FROM #__bracket_periods WHERE bracket_id = $id ORDER BY `position` ASC";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssocList();
		$ret['periods'] = $resultArray;

		//get bracket data
		$sql = "SELECT * FROM #__bracket_entries WHERE bracket_id = $id ORDER BY `position` ASC";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssocList();
		$ret['entries'] = $resultArray;
		
		return $ret;
	}
	
	function getBracketStandings($bracket_id) {
		$db =& JFactory::getDBO();
		
		//sanity check the passed in values
		if (!is_numeric($bracket_id)) {
			return false;
		}
		$sql = "SELECT entries_position AS entry, periods_position AS period, count(*) AS votes FROM #__bracket_votes WHERE bracket_id = $bracket_id GROUP BY entry, period ORDER BY entry, period ASC";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssocList();
		
		$ret = array();
		foreach ($resultArray as $row) {
			$ret['entries'][$row['entry']]['periods'][$row['period']]['votes'] = $row['votes'];
		}
		
		return $ret;
	}
	
	function getTime() {
		return date('Y-m-d H:i:s');
	}
	
}