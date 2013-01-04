<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class BracketViewAdd extends JView
{
	function display() {
		$document =& JFactory::getDocument();
		JToolBarHelper::title('Bracket Manager');
		JToolBarHelper::save();
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		
		$params = JComponentHelper::getParams('com_bracket');
		$this->assignRef('params', $params);
		
		$this->assign('numEntries', 16);
		$this->assign('entriesPerGroup', 4);
		
		parent::display();
	}
}