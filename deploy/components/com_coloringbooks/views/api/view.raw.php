<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
/**
 * XML API View of a coloring book
 *
 * @package ColoringBooks
 */
class ColoringBooksViewApi extends JView {

	function display($cid) {
		$document	=& JFactory::getDocument();
		$document->setMimeEncoding('text/xml');
		
		$u =& JFactory::getURI();
		$server = $u->getScheme().'://'.$u->getHost().$u->getPort();
		
		$model	=& $this->getModel('coloringbooks');
		$coloringBook			= $model->getColoringBook($cid);
				
		$this->assignRef('coloringBook', $coloringBook);
		$this->assignRef('server', $server);
				
		parent::display();
	}
}
?>