<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
jimport( 'joomla.error.log' );
/**
 * Greetings Component Administrator Controller
 * @package ColoringBooksAdmin
 */
class ColoringBooksController extends JController
{
       
	/**
	* Default action for component - displays a list of coloringBooks the user currently has access to.
	*
	*/	
	function display() {
		//This sets the default view (second argument)        
		$viewName    = JRequest::getVar( 'view', 'list' ); 
		//This sets the default layout/template for the view
		$viewLayout  = JRequest::getVar( 'layout', 'listlayout' );        
		$view = & $this->getView($viewName);

		// Get/Create the model
		if ($model = & $this->getModel('coloringbooks')) {
		//Push the model into the view (as default)
		//Second parameter indicates that it is the default model for the view
		$view->setModel($model, true);
		}

		$view->setLayout($viewLayout);
		$view->display();
	}

 /**
	* Edit first coloring book from the list of selected coloring books
	*
	*/	
	function edit(){
		//getVar(PARAMETER_NAME, DEFAULT_VALUE, HASH, TYPE)
		//The HASH is where to read the parameter from: 
		//The default is its default value:  getVar will look for the parameter in
		//GET, then POST and then FILE   
		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array

		if($cids === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$coloringbookId = (int)$cids[0]; //get the first id from the list (we can only edit one coloringbook at a time)
		$view = & $this->getView('coloringbookForm');

		// Get/Create the model
		if ($model = & $this->getModel('coloringbooks')) {
			
			if($users = & $this->getModel('users')) $view->setModel($users);
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$view->setModel($model, true);
		}


		$view->setLayout('coloringbookformlayout');
		$view->displayEdit($coloringbookId);        
	}
	
	/**
	* Creates/updates a coloring book
	* @see ColoringBooksModelColoringBooks::saveColoringBook()
	*/	
	function save(){       
		$coloringbook = JRequest::get( 'POST' );

		$model = & $this->getModel('coloringbooks'); 
		$model->saveColoringBook($coloringbook);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display');
		$this->setRedirect($redirectTo, 'Coloring Books Saved!');                
	}
	
 /**
	* Creates/updates a coloring book exactly like {@link ColoringBooksController::save() save} except that it has a json response instead of an html one.
	* @see ColoringBooksModelColoringBooks::saveColoringBook()
	*/	
	function apply(){
		$coloringBookForm = JRequest::get( 'POST' );
		$model = & $this->getModel('coloringbooks'); 
		$coloringBook = $model->saveColoringBook($coloringBookForm);
		
		//This sets the default view (second argument)        
		$viewName    = JRequest::getVar( 'view', 'coloringBookForm' ); 
		//This sets the default layout/template for the view
		$viewLayout  = JRequest::getVar( 'layout', 'bookform.json' );        
		$viewFormat  = JRequest::getVar( 'format', 'raw' );      
		$view = & $this->getView($viewName,$viewFormat);
		$view->setLayout($viewLayout);
		
		$view->setModel($model, true);
		$view->displayEdit($coloringBook->id);
	}
	
 /**
	* Displays an add Coloring book form.
	*/		
	function add(){
		$view = & $this->getView('coloringBookForm');
		$model = & $this->getModel('coloringbooks');
		$users = & $this->getModel('users');

		if (!$model){
			JError::raiseError(500, 'Model named greetings not found');
		}
		$view->setModel($model, true);
		$view->setModel($users);
		$view->setLayout('coloringbookformlayout');
		$view->displayAdd();                  
	}
    
 /**
	* Deletes the selected coloring books, and their pages using {@link ColoringBooksModelColoringBooks::deleteColoringBooks() deleteColoringBooks}
	*/	
	function remove(){
		$arrayIDs = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array

		if($arrayIDs === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$model = & $this->getModel('coloringbooks');
		$model->deleteColoringBooks($arrayIDs);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo, 'Deleted...');                
	}             

 /**
	* Sends the user back to the default component page.
	*/	
	function cancel(){
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo, 'Cancelled...');       		
	}
	
 /**
	* Updates the page order using {@link ColoringBooksModelColoringBooks::updatePageOrder() updateOrder}
	* Intended to be used with AJAX function as it displays nothing.
	*/	
	function updateOrder(){
		$pageIDs = JRequest::getVar('id',null,'default','array');
		if($pageIDs !== null){
			$model = & $this->getModel('coloringbooks');
			$model->updatePageOrder($pageIDs);
		}
	}

 /**
	* Stores a FILE or POST submitted image to the cid provided using {@link ColoringBooksModelColoringBooks::savePage() savePage}
	* Intended to be used with AJAX function, displays a json view of the ColoringBook.
	*/	
	function uploadImage(){
		$cids = JRequest::getVar('cid',null,'default','array');
		$cid = (int) $cids[0];
		$state = $this->getModel('coloringbooks')->savePage($cid);
		
		//This sets the default view (second argument)        
		$viewName    = JRequest::getVar( 'view', 'pageuploadstate' ); 
		//This sets the default layout/template for the view
		$viewLayout  = JRequest::getVar( 'layout', 'default' );  
		$viewType  = JRequest::getVar( 'format', 'raw' );  
		
		$view = $this->getView($viewName,$viewType);
		$view->setLayout($viewLayout);
		$view->display($state);
	}
	
 /**
	* Deletes the page with the supplied id using {@link ColoringBooksModelColoringBooks::deletePage() deletePage}
	* Intended to be used with AJAX function as it displays nothing.
	*/
	function deleteImage(){
		$pids = JRequest::getVar('id');
		$this->getModel('coloringbooks')->deletePage($pids[0]);
	}
	
}
?>
