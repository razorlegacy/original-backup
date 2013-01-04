<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
/**
 * Embeded view - displays the barebones html document with a flash element in it by default
 *
 * @package ColoringBooks
 */
class SliversViewEmbed extends JView {

	function display($id,$ct,$da = false) {
		$document	=& JFactory::getDocument();
		$document->setMimeEncoding('text/javascript');

		$model	=& $this->getModel('slivers');
		$videoModel	=& $this->getModel('videos');
		$buttonModel	=& $this->getModel('buttons');
		$scheduledImagesModel	=& $this->getModel('scheduledImages');
		$sliver			= $model->getSliver($id);
		$videos			= $videoModel->getVideosForSliver($id);
		$buttons		= $buttonModel->getButtonsForSliver($id);
		$scheduledImages			= $scheduledImagesModel->getScheduledImagesForSliver($id);
		$base = (JURI::base()).'components/com_slivers/';
		$flowplayer = $base.'assets/flowplayer/';
		//$flowplayerscript = $flowplayer.'example/flowplayer-3.2.6.min.js';
		$flowplayerscript = $flowplayer.'example/flowplayer-3.2.6.js';
		//TODO: MUST REPLACE WITH LOCAL COPY BEFORE PUSHING LIVE!!!!!111ONE!!!!
		$flowplayerflash = 'http://cdn.assets.gorillanation.com/internal/flowplayer/flowplayer-3.2.7.swf';

		$this->assignRef('sliver', $sliver);
		$this->assignRef('videos', $videos);
		$this->assignRef('buttons', $buttons);
		$this->assignRef('backgrounds', $scheduledImages);
		$this->assignRef('flowplayerscript',$flowplayerscript);
		$this->assignRef('flowplayerflash',$flowplayerflash);
		$this->assignRef('ct', $ct);
		$this->assignRef('da', $da);
		$uri = JURI::getInstance();
		$this->assignRef('feed',JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&view=api&format=raw&id='.$id));

		parent::display();
	}
}
