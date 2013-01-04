<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the backend of the ColoringBooks Component add and edit tasks
 *
 * @package    ColoringBooks
 */
class ColoringBooksViewColoringBookForm extends JView
{
	private $componentBase = 'administrator/components/com_coloringbooks';
	function __construct(){
		parent::__construct();
		$this->jsBase = $this->componentBase.'/js';
	}
 /**
	* A helper method to include common css and js elements in the page
	*
	* @param string $str Path to file or directory
	* @access private
	*/
	private function _includejslibs(){
		$document =& JFactory::getDocument();

		JHTML::stylesheet('jquery-ui-1.8.9.custom.css',$this->jsBase."/jquery-ui-1.8.9.custom/css/ui-lightness/");
		
		$document->addScript('http://code.jquery.com/jquery-1.5.min.js');
		$document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js');
		$document->addScript('http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js');
		
		
		JHTML::script('fileuploader.js',$this->jsBase.'/valums-file-uploader/client/');
		JHTML::stylesheet('fileuploader.css',$this->jsBase.'/valums-file-uploader/client/');
	}
	
 /**
  * Throws out the html for editing a coloring book
  *
  * @package    ColoringBooks
	* @param int $coloringBookId 
  */
	function displayEdit($coloringBookId) {  
		$this->_includejslibs();
		
		JHTML::script("coloringbooks.js", $this->jsBase."/", false);
		JHTML::stylesheet("coloringbooks.css", $this->componentBase."/css/");  
		JToolBarHelper::title('Coloring Book'.': [<small>Edit</small>]');
		JToolBarHelper::save();
		JToolBarHelper::cancel();  

		$model = $this->getModel();
		$users = $this->getModel('users')->getAllUsers();
		$user =& JFactory::getUser();
		
		$coloringBook = $model->getColoringBook($coloringBookId);
		$this->assignRef('coloringBook', $coloringBook);
		$this->assignRef('users', $users);
		$this->assignRef('currentuser', $user);

		parent::display();
	}
	
 /**
  * Throws out the html for adding a new Coloring Book
  *
  * @package    ColoringBooks
	* @param int $coloringBookId 
  */
	function displayAdd(){
		$this->_includejslibs();
	
		JHTML::script("coloringbooks.js", $this->jsBase."/", false);
		JHTML::stylesheet("coloringbooks.css", $this->componentBase."/css/");  
		JToolBarHelper::title('Coloring Book'.': [<small>Add</small>]');
		JToolBarHelper::save();
		JToolBarHelper::cancel();  

		$model = $this->getModel();
		$users = $this->getModel('users')->getAllUsers();
		$user =& JFactory::getUser();
		
		$coloringBook = $model->getNewColoringBook();
		$this->assignRef('coloringBook', $coloringBook);
		$this->assignRef('users', $users);
		$this->assignRef('currentuser', $user);
		
		parent::display();
	}
}
?> 
