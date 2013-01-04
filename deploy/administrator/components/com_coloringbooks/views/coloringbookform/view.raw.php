<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * JSON View class for the backend of the ColoringBooks Component Apply Task
 *
 * @package    ColoringBooks
 */
class ColoringBooksViewColoringBookForm extends JView {

 /**
  * Throws out the json for editing a coloring book
  *
  * @package    ColoringBooks
	* @param int $coloringBookId 
  */
	function displayEdit($coloringBook){
		if(is_numeric($coloringBook)){
			$model = $this->getModel();
			$coloringBook = $model->getColoringBook($coloringBook);
		}else{JError::raiseError(500,'invalid book_id supplied');}
		
		$this->assignRef('coloringBook', $coloringBook);
		// Get the document object.
		$document =& JFactory::getDocument();
		// Set the MIME type for JSON output.
		$document->setMimeEncoding( 'application/json' );
		 
		// Change the suggested filename.
		JResponse::setHeader( 'Content-Disposition', 'attachment; filename="'.$this->getName().'.json"' );
		
		parent::display();
	}
}