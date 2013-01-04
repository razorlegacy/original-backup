<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
class BracketModelVotes extends JModel {
	
	function updateVotes($period, $voted, $rival) {
		
		//get db
		$db = JFactory::getDBO();
		$db2 = JFactory::getDBO();
		
		//establish period for vote
		$votePeriod = "period".$period;
		
		//query vote table for current total for new vote
		$sqlVoted = "SELECT ".$votePeriod." FROM `#__bracket_votes` WHERE entry_id='".$voted."'";
		$db->setQuery($sqlVoted);
		$resultVoted = $db->loadResult();
		
		//increment vote total and update db with it
		$resultVoted++;
		$sqlUpdate = (object) array(
			'entry_id' => $voted,
			$votePeriod =>$resultVoted
		);
		$db->updateObject('#__bracket_votes',$sqlUpdate,'entry_id');
				
		//query vote table for rival vote total
		$sqlRival = "SELECT * FROM `#__bracket_votes` WHERE entry_id='".$rival."'";
		$db2->setQuery($sqlRival);
		$resultRival = $db2->loadAssoc();
		
		//return array to be parsed to xml
		$returnVote = array(
			"voted" => array( 
				"id" => $voted, 
				"votes" => $resultVoted
			),
			"rival" => array(
				"id" => $rival,
				"votes" => $resultRival[$votePeriod]
			)
		);

		return $returnVote;
		
	}
}