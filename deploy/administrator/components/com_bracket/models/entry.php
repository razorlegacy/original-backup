<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
jimport('joomla.application.application');

class BracketModelEntry extends JModel {
	
	const ASSETS_PATH = 'assets/components/com_bracket';	
	
	// Return Bracket Entries
	function getBracketEntries($cid) {
		$db =& JFactory::getDBO();

		$query = "SELECT * FROM #__bracket_entries WHERE bracket_id = {$cid} ORDER BY position";
       	$db->setQuery($query);
		return $db->loadAssocList();
	}
	
	//Get Entry Details for Updating
	function getEntryDetail($eid) {
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__bracket_entries WHERE id = {$eid}";
       	$db->setQuery($query);
		return $db->loadAssocList();
	}
	
	//Update Entry Details
	function updateEntry($name, $description, $position, $eid, $cid) {
		
		$db =& JFactory::getDBO();	
		
		//Image file upload and prep for SQL Update
		$image_basedir = JPATH_ROOT.DS.self::ASSETS_PATH.DS.$cid;
		
		// if directory does not exist create it
		if (!file_exists($image_basedir)) {
			mkdir($image_basedir, '777', true);
		}
				
		$image_update_sql = '';
		$image_relpaths = array();
		$image_types = array('image_relpath', 'finalist_relpath', 'winner_relpath', 'hover_relpath');
		
		foreach ($image_types as $image_type) {
			$file_key = "{$image_type}";
				
			if (array_key_exists($file_key, $_FILES) && is_numeric(strpos($_FILES[$file_key]['type'], 'image')) && ($_FILES[$file_key]['error'] == 0)) {
				$image_relpaths[$image_type] = $cid . '_' . $file_key . '_' . $_FILES[$file_key]['name'];
				$uploadResult = move_uploaded_file($_FILES[$file_key]['tmp_name'], $image_basedir . DS . $image_relpaths[$image_type]);
				$image_update_sql .= "{$image_type} = '" . $db->getEscaped($image_relpaths[$image_type]) . "', ";
			} 
		}
		
		//SQL Update
		$sql = 'UPDATE #__bracket_entries SET ' . $image_update_sql . ' `description` = \'' . $db->getEscaped($description) . '\', `name` = \'' . $db->getEscaped($name) . '\' WHERE id = ' . $eid;
		$db->setQuery($sql);
		$db->query();
		JApplication::redirect('index.php?option=com_bracket&task=entry&cid=' . $cid);
	}
	
	//Reset entry to blank.
	function resetEntry($eid, $cid) {
		$db =& JFactory::getDBO();	
		$sql = 'UPDATE #__bracket_entries SET `image_relpath` = \'\', `finalist_relpath` = \'\', `winner_relpath` = \'\', `hover_relpath` = \'\', `description` = \'\', `name` = \'\' WHERE id = ' . $eid;
		$db->setQuery($sql);
		$db->query();
		JApplication::redirect('index.php?option=com_bracket&task=entry&cid=' . $cid);
	}
	
	//update entry positions after drag & drop
	function updatePositions($positions, $cid) {
		$i = 1;
		$db =& JFactory::getDBO();	
		foreach ($positions as $position) {
			$sql = 'UPDATE #__bracket_entries SET `position` = \'' . $i . '\' WHERE id = ' . $position;
			//echo $sql . '\r\n';
			$db->setQuery($sql);
			$db->query();
			$i++;
		}
	}
}
