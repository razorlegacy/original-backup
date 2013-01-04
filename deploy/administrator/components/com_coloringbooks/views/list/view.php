<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the ColoringBooks Component (List)
 * 
 * @package    ColoringBooksAdmin
 */
class ColoringBooksViewList extends JView
{
/**
 * Displays the coloring books available to the user 
 *
 */
	function display(){
		JToolBarHelper::title('Coloring Book Manager', 'generic.png');
		JToolBarHelper::deleteList();    
		JToolBarHelper::editListX();      
		JToolBarHelper::addNewX();        

		$uri = JFactory::getURI();
		JHTML::stylesheet("coloringbooks.css", $uri->base()."components/com_coloringbooks/css/");  
		
		$document =& JFactory::getDocument();
		$document->addScript('http://code.jquery.com/jquery-1.5.min.js');
		$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js');
		$document->addScript('http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js');
		JHTML::script('coloringbooks.js',$uri->base().'components/com_coloringbooks/js/');
		
		$user =& JFactory::getUser();
		$displayUsers = $user->authorize('com_coloringbooks', 'viewAlterOtherBooks');
		$acl = JFactory::getACL();
		
		$model = $this->getModel();
		$coloringBooks = $model->getColoringBooks();
		
		$this->assignRef('coloringBooks', $coloringBooks);
		$this->assignRef('displayUsers', $displayUsers);
		parent::display();
	}
}
?>
