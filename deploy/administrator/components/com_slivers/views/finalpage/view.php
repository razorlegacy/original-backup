<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the Slivers Component's final page
 *
 * @package    SliversAdmin
 */
class SliversViewFinalPage extends JView {

 /**
  * Throws out the html for editing a sliver
  *
	* @param int $sliverId 
  */
	function display($sliverId) {
		if(!$sliverId) JError::raiseError(500, 'invalid sliver id');

		$nav = new sliverNav('final',$sliverId);

		// Top Nav
		JToolBarHelper::title('Sliver'.': [<small>final page</small>]');
		JToolBarHelper::custom('final+back', 'back.png', 'back.png', 'Go Back', false, false );
		JToolBarHelper::divider();
		JToolBarHelper::custom('final+up', 'upload.png', 'upload.png', 'Leave', false, false );

		$model = $this->getModel();
		$sliver = $this->getModel('slivers')->getSliver($sliverId);
		$uri = JURI::getInstance();
		$embed_link = JRoute::_($uri->root().'index.php?option='.JRequest::getVar('option').'&task=display&format=raw&view=embed&id='.$sliverId);

		$this->assignRef('sliver_id', $sliverId);
		$this->assignRef('nav', $nav);
		$this->assignRef('sliver', $sliver);
		$this->assignRef('embed_link', $embed_link);

		parent::display();
	}
}
