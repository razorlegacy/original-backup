<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
jimport( 'joomla.filter.filterinput' );
jimport( 'joomla.error.log' );

require_once (JPATH_COMPONENT.DS."classes".DS.'sliverNav.php');

/**
 * Greetings Component Administrator Controller
 * @package SliversAdmin
 */
class SliversController extends JController
{

/**
  * Overides the default execute method to allow some navigation magic
  * @param string $task task may be the name of one of the navigation elements + a navigation direction or simply a controller function. In the later case a the function will simply be called. In the former a helper function will be called before redirecting.
  * 
	*/
	function execute($task){
		if(strpos($task,'+') !== false){
			list($task,$direction) = explode('+',$task,2);
		}
		switch($task){
			case 'videos':
				$this->setNavigation($task,$direction,null);
				break;
			case 'positions':
				$this->positionsHelper();
				$this->setNavigation($task,$direction);
				break;
			case 'scheduledImages':
				if($direction == 'up' || $direction == 'current')
					$this->imagesHelper();
				$this->setNavigation('images',$direction,null);
				break;
			case 'general':
				$this->generalHelper();
				$this->setNavigation($task,$direction);
				break;
			case 'final':
				$this->setNavigation($task,$direction,null);
				break;
			default:
				parent::execute($task);
		}
		
	}
/**
 * Saves $type and navigates in the $direction provided.
 *
 * @param string $type can be 'images','videos','positions' or 'general'. Indicates what model is being saved.
 * @param string $direction can be 'next','forward','continue', 'previous','back','current','up'. Indicates where relative to the current position the user should be redirected after saving.
 * @param string $message an additional message to display to the user on the navigated to page.
 */

	private function setNavigation($type,$direction = 'up', $message = 'Sliver saved! Remember to bust the sliver cache when you are done editing if you want to see the changes immediately.'){
		$sliver_id  = JRequest::getVar( 'sliver_id');
		$nav = new sliverNav($type,$sliver_id);
		switch($direction){
			case 'next':
			case 'forward':
			case 'continue':
				$task = $nav->getNext();
				break;
			case 'previous':
			case 'back':
				$task = $nav->getPrevious();
				break;
			case 'current':
				$task = $nav->getActiveTask();
				break;
			case 'up':
			default:
				$task = 'display';
		}

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task='.$task.'&cid[]='.$sliver_id,false);
		$this->setRedirect($redirectTo, $message);
	}

/**
 * Edit really is generic so I abstracted it.
 *
 * @param string $modelName The name of the model that we are editing
 * @param string $theViewName The name of the view that we should display $model in
 * @param string $layoutName The name of the layout that we should use with $theViewName
 */
	private function edit($modelName,$theViewName = null,$layoutName = null){
		if(!is_array($modelName)) $modelName = array($modelName);
		//This sets the default view (second argument)
		$viewName    = JRequest::getVar( 'view', $theViewName );
		//This sets the default layout/template for the view
		$viewLayout  = JRequest::getVar( 'layout', $layoutName );

		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
		if($cids === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$sliverId = (int)$cids[0];
		$view = & $this->getView($viewName);
		$first = true;
		foreach($modelName as $mn){
			if($model = $this->getModel($mn)){
				$view->setModel($model,$first);
			}
			unset($model);
			$first = false;
		}
		$view->setLayout($viewLayout);
		$view->displayEdit($sliverId);
	}

	/**
	* Default action for component - displays a list of slivers the user currently has access to.
	*
	*/
	function display() {
		$viewName    = JRequest::getVar( 'view', 'list' );
		$viewLayout  = JRequest::getVar( 'layout', 'listlayout' );
		$view = & $this->getView($viewName);

		if ($model = & $this->getModel('slivers')) {
			if($videos = & $this->getModel('videos')) $view->setModel($videos);
			else JError::raiseError(500,'Unable to acquire videos model');

			$view->setModel($model, true);
		}

		$view->setLayout($viewLayout);
		$view->display();
	}

 /**
	* Displays an add Sliver form. Starts on the General page.
	*/
	function add(){
		$view = & $this->getView('setupgeneral');
		$model = & $this->getModel('slivers');
		$users = & $this->getModel('users');
		$videos = & $this->getModel('videos');
		$scheduledImages = & $this->getModel('scheduledImages');

		if (!$model) JError::raiseError(500, 'Model named slivers not found');
		if (!$users) JError::raiseError(500, 'Model named users not found');
		if (!$videos) JError::raiseError(500, 'Model named videos not found');
		if (!$scheduledImages) JError::raiseError(500, 'Model named scheduledImages not found');

		$view->setModel($model, true);
		$view->setModel($users);
		$view->setModel($videos);
		$view->setModel($scheduledImages);

		$view->setLayout('setupgenerallayout');
		$view->displayAdd();
	}

 /**
	* Deletes the selected slivers, and their pages using {@link SliversModelSlivers::delete() delete}
	*/
	function remove(){

		$arrayIDs = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array

		if($arrayIDs === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$model = & $this->getModel('slivers');
		$model->delete($arrayIDs);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo, 'Deleted...');
	}

	function displayFinalPage () {
		$viewName    = JRequest::getVar( 'view', 'finalpage' );
		$viewLayout  = JRequest::getVar( 'layout', 'finalpagelayout' );
		$view = & $this->getView($viewName);

		if ($model = & $this->getModel('slivers')) {
			$view->setModel($model, true);
		}

		$view->setLayout($viewLayout);
		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
		$sliverId = (int)$cids[0];
		$view->display($sliverId);
	}

 /**
	* Edit first sliver from the list of selected slivers
	*
	*/
	function editGeneral(){
		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array

		if($cids === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$sliverId = (int)$cids[0]; //get the first id from the list (we can only edit one coloringbook at a time)
		$view = & $this->getView('setupgeneral');

		// Get/Create the model
		if ($model = & $this->getModel('slivers')) {

			if($users = & $this->getModel('users')) $view->setModel($users);
			else JError::raiseError(500,'Unable to acquire users model');

			if($videos = & $this->getModel('videos')) $view->setModel($videos);
			else JError::raiseError(500,'Unable to acquire videos model');

			if($scheduledImages = & $this->getModel('scheduledImages')) $view->setModel($scheduledImages);
			else JError::raiseError(500,'Unable to acquire scheduledImages model');

			$view->setModel($model, true);
		}


		$view->setLayout('setupgenerallayout');
		$view->displayEdit($sliverId);
	}

/**
 * Displays the edit page for videos
 */
	public function editVideos(){
		$this->edit(array('videos','slivers'),'setupvideos','setupvideoslayout');
	}

	public function editVideo() {
		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
		if ($cids === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$sliverId = (int)$cids[0];
		$videoId     = JRequest::getVar('id', null, 'default', 'INT' ); //Reads cid as an array

		$viewName    = JRequest::getVar('view', 'editvideo' );
		$viewLayout  = JRequest::getVar('layout', 'editvideolayout' );

		$view = & $this->getView($viewName,'html');

		if($model = $this->getModel('videos')){
			$view->setModel($model,true);
		}

		$view->setLayout($viewLayout);
		$view->displayEdit($sliverId,$videoId);
	}

	public function addVideo() {
		$cids = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
		if ($cids === null){ //Make sure the cid parameter was in the request
			JError::raiseError(500, 'cid parameter missing from the request');
		}

		$sliverId = (int)$cids[0];
		$date    = JRequest::getVar( 'starts');

		$viewName    = JRequest::getVar( 'view', 'editvideo' );
		$viewLayout  = JRequest::getVar( 'layout', 'editvideolayout' );

		$view = & $this->getView($viewName,'html');

		if($model = $this->getModel('videos')){
			$view->setModel($model,true);
		}

		$view->setLayout($viewLayout);
		$view->displayAdd($sliverId,$date);
	}


/**
 * Displays the edit page for scheduled images
 */
	public function editScheduledImages(){
		$this->edit(array('scheduledImages','slivers'),'setupimages','setupimageslayout');
	}

	public function editPositions(){
		$this->edit(array('slivers','scheduledImages','buttons','videos'),'setuppositions','setuppositionslayout');
	}

/**
 * Insert/Update Helper function for the general properties of a sliver
 */
	private function generalHelper(){
		$sliver = JRequest::get();

		$model = & $this->getModel('slivers');
		$sliverRow = $model->save($sliver);

		if(!$sliver['id']){
			$buttons =& $this->getModel('buttons');
			$close = $buttons->getNewButton($sliverRow->id);
			$trigger = $buttons->getNewButton($sliverRow->id);
			$trigger->area = 'actionbar';
			$trigger->action = 'opensliver';
			$close->name = 'close button';
			$trigger->name = 'open button';
			$trigger->on = 'rollover';
			if($close->check()) $close->store();
			else JError::raiseError(500,'failed db check: '.$close->getError());
			if($trigger->check()) $trigger->store();
			else JError::raiseError(500,'failed db check: '.$trigger->getError());
		}
		JRequest::setVar('sliver_id',$sliverRow->id,'GET');
	}

/**
 * Insert/Update Helper function for the scheduled Backgrounds associated with a sliver
 */
	private function imagesHelper(){
		$scheduledImage = JRequest::get();

		$scheduledImageModel =& $this->getModel('scheduledimages')|| JError::raiseError(500,'Unable to acquire scheduledImages model');

		return $scheduledImageModel->save($scheduledImage);
	}

	public function saveVideo() {
		$video = array();
		$filter = & JFilterInput::getInstance();

		$video['sliver_id'] =     JRequest::getVar('sliver_id',null,'POST','INT');
		$video['id'] =            JRequest::getVar('id',null,'POST','INT');
		$video['name'] =            JRequest::getVar('name',null,'POST','STRING');

		$video['height'] =        JRequest::getVar('height',null,'POST','INT');
		$video['width'] =         JRequest::getVar('width',null,'POST','INT');
		$video['posX'] =          JRequest::getVar('posX',null,'POST','INT');
		$video['posY'] =          JRequest::getVar('posY',null,'POST','INT');

		$video['autoOpen'] =      JRequest::getVar('autoOpen',null,'POST','BOOL');
		$video['volume'] =        JRequest::getVar('volume',null,'POST','INT');
		$video['starts'] =        JRequest::getVar('starts',null,'POST');
		$video['embed_code'] =        JRequest::getVar('embed_code',null,'POST','STRING',JREQUEST_ALLOWRAW);

		foreach(array('autoPlay','startMuted','unmuteOnRollover') as $checkbox){
			if(JRequest::getVar($checkbox,null,'POST','BOOL')){
				$video[$checkbox] = true;
			}
		}
		
		if(!empty($video)){
			$model =& $this->getModel('videos')|| JError::raiseError(500,'Unable to acquire model');
			$model->save(array($video));
		}
	}

/**
 * Saves scheduled images then either redirects to the view of all slivers or returns a json view of the sliver just saved
 * @todo this should be separated from the json response. The two do fundamentally different things after saving.
 */
	public function saveScheduledImages(){
		$state = $this->imagesHelper();

		$viewName = JRequest::getVar('view','list','default');
		if($viewName == 'list'){
			$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=display',false);
			$this->setRedirect($redirectTo, 'Sliver saved! Remember to bust the sliver cache when you are done editing if you want to see the changes immediately.');
		}else{
			//This sets the default layout/template for the view

			$viewLayout  = JRequest::getVar( 'layout', 'image.raw' );
			$viewType  = JRequest::getVar( 'format', 'raw' );
			$scheduledImagesModel =& $this->getModel('scheduledimages');

			$view =& $this->getView($viewName,$viewType);
			$view->setModel($scheduledImagesModel,true);
			$view->setLayout($viewLayout);
			$view->displayImage($state->id);
		}
	}

/**
 * Insert/Update Helper function for saving the positions of all the buttons and videos using the positioner.
 */
	private function positionsHelper(){
		$positions = JRequest::get();

		$i = 0;
		$buttons = array();
		while(isset($positions['button_id'][$i])){
			$buttons[$i]['id'] = $positions['button_id'][$i];
			$buttons[$i]['width'] = $positions['button_width'][$i];
			$buttons[$i]['height'] = $positions['button_height'][$i];
			$buttons[$i]['x_offset'] = $positions['button_x_offset'][$i];
			$buttons[$i]['y_offset'] = $positions['button_y_offset'][$i];
			$buttons[$i]['sliver_id'] = $positions['sliver_id'];
			//Ignoring these as they are not actually modified in the positioner
// 			$buttons[$i]['button_area'] = $positions['button_area'][$i];
// 			$buttons[$i]['button_action'] = $positions['button_action'][$i];
// 			$buttons[$i]['button_on'] = $positions['button_on'][$i];
			$i++;
		}

		$videosModel =& $this->getModel('videos')|| JError::raiseError(500,'Unable to acquire videos model');
		$buttonsModel =& $this->getModel('buttons')|| JError::raiseError(500,'Unable to acquire videos model');
		if(isset($positions['posX']) && isset($positions['posY']))
			$videosModel->updateVideosPosition($positions['sliver_id'],$positions['posX'],$positions['posY']);

		foreach($buttons as $button){
			$buttonsModel->save($button);
		}
		
	}

/**
 * Adds/Updates a button then redirects to the editPositions page
 */
	public function applyButton(){
		$sliver_id  = JRequest::getVar( 'sliver_id');
		$button = JRequest::get();

		$buttonsModel =& $this->getModel('buttons')|| JError::raiseError(500,'Unable to acquire buttons model');

		$buttonsModel->save($button);

		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&task=editPositions&hidemainmenu=1&cid[]='.$sliver_id,false);
		$this->setRedirect($redirectTo, 'Sliver saved! Remember to bust the sliver cache when you are done editing if you want to see the changes immediately.');
	}

/**
 * Deletes the video(s) with the provided id(s).
 */
	function removeVideos(){
		$videoIds = JRequest::getVar('id',null,'default','array');
		$this->getModel('videos')->delete($videoIds);
	}

/**
 * Deletes the Button(s) with the provided id(s).
 */
	function removeButtons(){
		$buttonIds = JRequest::getVar('id',null,'default','array');
		$this->getModel('buttons')->delete($buttonIds);
	}

 /**
	* Deletes the scheduledImage with the supplied id using {@link ColoringBooksModelColoringBooks::deletePage() deletePage}
	* Intended to be used with AJAX function as it displays nothing.
	*/
	function removeImage(){
		$sImageIds = JRequest::getVar('sid',null,'default','array');
		$this->getModel('scheduledImages')->delete($sImageIds[0]);
	}

 /**
	* Sends the user back to the default component page.
	*/
	function cancel(){
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option'));
		$this->setRedirect($redirectTo, 'Cancelled...');
	}

}
