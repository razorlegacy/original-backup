<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
/**
 * XML API View of a coloring book
 *
 * @package ColoringBooks
 */
class SliversViewApi extends JView {

	function display($id) {
		$document	=& JFactory::getDocument();
		$document->setMimeEncoding('text/xml');

		$model	=& $this->getModel('slivers');
		$videoModel	=& $this->getModel('videos');
		$buttonsModel	=& $this->getModel('buttons');
		$scheduledImagesModel	=& $this->getModel('scheduledImages');
		$sliver			= $model->getSliver($id);
		$videos			= $videoModel->getVideosForSliver($id);
		$scheduledImages			= $scheduledImagesModel->getScheduledImagesForSliver($id);
		$buttons = $buttonsModel->getButtonsForSliver($id);

		$this->assignRef('sliver', $sliver);
		$this->assignRef('videos', $videos);
		$this->assignRef('buttons', $buttons);
		$this->assignRef('backgrounds', $scheduledImages);

		parent::display();
	}
}