<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Slivers Component (List)
 *
 * @package    SliversAdmin
 */
class SliversViewList extends JView
{
/**
 * Displays the slivers available to the user
 *
 */
	function display(){
		JToolBarHelper::title('Sliver Manager', 'generic.png');
		JToolBarHelper::deleteList();
		JToolBarHelper::editList();
		JToolBarHelper::addNew();

		$user =& JFactory::getUser();
		$displayUsers = $user->authorize('com_slivers', 'viewAlterOtherSlivers');
		$acl = JFactory::getACL();

		$model = $this->getModel();
		$slivers = $model->getAllSlivers();

		$this->assignRef('slivers', $slivers);
		$this->assignRef('displayUsers', $displayUsers);
		parent::display();
	}
}
