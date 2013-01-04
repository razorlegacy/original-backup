<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class BracketViewEntry extends JView {
	function display($bracketData, $bracketDetails) {
		$document =& JFactory::getDocument();
		JToolBarHelper::title('Bracket Entry Manager');
		JToolBarHelper::cancel('default','Bracket Main Menu');
		$params 				= JComponentHelper::getParams('com_bracket');
		//$bracketModel	 	=& $this->getModel();
		//$bracketEntries		= $bracketModel->getBracketEntries();
		$this->assignRef('params', $params);
		$this->assignRef('bracketData', $bracketData);
		$this->assignRef('bracketDetails', $bracketDetails);
		parent::display();
	}
}
?>