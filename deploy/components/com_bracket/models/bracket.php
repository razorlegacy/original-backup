<?php
//No direct acesss
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
class BracketModelBracket extends JModel {
      
      function MySQLDateOffset($dt,$year_offset='',$month_offset='',$day_offset='') { 
      		return ($dt=='0000-00-00') ? '' :  
      		date ("Y-m-d", mktime(0,0,0,substr($dt,5,2)+$month_offset,substr($dt,8,2)+$day_offset,substr($dt,0,4)+$year_offset)); 
	  }

       function getBracketInfo($cid){
			$db = JFactory::getDBO();
			$query = "SELECT * from #__bracket WHERE id = {$cid}";
			$db->setQuery($query);
			return $db->loadObject();
       }
       
       function getBracketDates($cid){
       		$db = JFactory::getDBO();
       		$query = "SELECT * FROM #__bracket_periods WHERE  bracket_id = {$cid}";
       		$db->setQuery($query);
			return $db->loadAssocList();
       }
       
       function getBracketEntries($cid){
       		$db = JFactory::getDBO();
       		$query = "SELECT * FROM #__bracket_entries WHERE bracket_id = {$cid} ORDER BY position";
       		$db->setQuery($query);
			return $db->loadAssocList();
       }
      
      function getBracketVotes($cid){
       		$db = JFactory::getDBO();
       		$query = "SELECT * FROM #__bracket_votes WHERE bracket_id = {$cid}";
       		$db->setQuery($query);
			return $db->loadAssocList();
       }
}
?>