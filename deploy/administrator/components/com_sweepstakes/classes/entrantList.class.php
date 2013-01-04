<?php
defined('_JEXEC') or die();
/**
* Class used to display an entrant list with corresponding field titles
*/
class entrantList {

	private $fieldHeaders		= array();

	function __construct($fields) {
		$this->fieldHeaders		= $fields;
	}
	
	function _build($output) {
		echo $output;
	}
	
	/**
	* Gets number of field columns and adds 2 for an ID and Timestamp field
	* @return int Colspan value
	*/
	function getColspan() {
		$colspan		= sizeof($this->fieldHeaders['name']) + 2;
		return $colspan;
	}
	
	/**
	*
	*/
	function entrantList($entrants) {
		$k	= 0;
		$i	= 0;
		foreach($entrants as $row) {
			$output		.= "<tr class='row{$k}'>\n";
			$output		.= "\t<td name='uid[]'>{$row->uid}</td>\n";
		
			$entrantData	= unserialize($row->fields);
			foreach($entrantData as $key=>$value) {
				if($value != null) {
					$value	= $value;
				} else {
					$value	= "N/A";
				}
				$output	.= "\t<td align='center'>{$value}</td>\n";
			}
			$output		.= "<td align='center'>".JHTML::date($row->timestamp, '%D %r', JText::_('DATE_FORMAT_LC'))."</td>\n";
			$output		.= "</tr>\n";
			
			$k	= 1 - $k;
			$i++;
		}
		
		$this->_build($output);
	}
}