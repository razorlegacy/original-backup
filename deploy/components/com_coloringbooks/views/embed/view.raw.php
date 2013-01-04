<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
/**
 * Embeded view - displays the barebones html document with a flash element in it by default
 *
 * @package ColoringBooks
 */
class ColoringBooksViewEmbed extends JView {

	function display($cid) {
		
		$model	=& $this->getModel('coloringbooks');
		$coloringBook			= $model->getColoringBook($cid,false);
		
		$uri = JURI::getInstance();
		$this->assignRef('feed',JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&view=api&format=raw&cid='.$cid));
		$this->assignRef('coloringBook', $coloringBook);
				
		parent::display();
	}
}
?>