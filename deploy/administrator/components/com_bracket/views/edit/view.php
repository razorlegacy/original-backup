<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class BracketViewEdit extends JView
{
	function display() {
		$document =& JFactory::getDocument();
		JToolBarHelper::title('Edit Bracket');
		JToolBarHelper::save();
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
		$params = JComponentHelper::getParams('com_bracket');
		$this->assignRef('params', $params);
		$this->assignRef('entries', $this->entries);
		$this->assign('numEntries', 16);
		$this->assign('entriesPerGroup', 4);
		
		parent::display();
	}
}