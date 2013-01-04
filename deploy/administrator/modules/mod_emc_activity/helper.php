<?php
	defined('_JEXEC') or die();

	class modActivityHelper {
		public $_originDB   = null;
		
		function __construct() {
			$this->_originDB		=& JFactory::getDBO();
		}
		
		function loadActivity() {
			$query = "SELECT id, name, manager, modified_by, date, action FROM (
						SELECT id, name, manager, modified_by, date, action FROM 
						(SELECT id, name, manager, modified_by, create_date as 'date', 'created' as 'action'
						FROM #__emc_origin ORDER BY create_date DESC LIMIT 20) AS A
						UNION ALL
						(SELECT id, name, manager, modified_by, modify_date as 'date', 'modified' as 'action'
						FROM #__emc_origin ORDER BY modify_date DESC LIMIT 20)) AS B
						ORDER BY date DESC LIMIT 20;";
			$this->_originDB->setQuery($query);
			$rows = $this->_originDB->loadObjectList();
			return $rows;
		}
	}