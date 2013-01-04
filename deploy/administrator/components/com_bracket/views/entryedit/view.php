<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class BracketViewEntryEdit extends JView {
	function display($entryData) {
		JToolBarHelper::title('Bracket Entry Manager');
		JToolBarHelper::save('entryupdate');
		JToolBarHelper::spacer();
		$this->assignRef('entryData', $entryData);
		parent::display();
	}
}
?>