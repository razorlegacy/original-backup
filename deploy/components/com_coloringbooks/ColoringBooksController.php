<?php
defined('_JEXEC') or die();

jimport("joomla.application.component.controller");
require_once (JPATH_COMPONENT.DS."classes".DS.'class.phpmailer.php');

/**
 * Controller for front-end interface to coloring books component
 *
 * @package ColoringBooks
 */
class ColoringBooksController extends JController {

	function display() {
		$viewName		= JRequest::getVar('view', 'api');
		$viewLayout		= JRequest::getVar('layout', 'default');
		$viewType		= JRequest::getVar('format', 'raw');
		$cid			= JRequest::getVar('cid', '', 'get', 'int');
		$view			=& $this->getView($viewName, $viewType);
		
		//load model
		$view->setModel($this->getModel('coloringbooks'), true);
		
		$view->setLayout($viewLayout);
		$view->display($cid);
	}
	
	// function sendToFriend(){
		// function ok_mime_type($mime){
			// if(!is_int($mime))
			// $accepted_mimes = array('image/png','image/jpeg');
			// else
			// $accepted_mimes = array(IMAGETYPE_PNG,IMAGETYPE_JPEG);

			// return in_array($mime,$accepted_mimes);
		// }	
		
		// $cid	= JRequest::getVar('cid', '','default', 'int');
		// $fromName = JRequest::getVar('fromname', '','string');
		// $toEmail = JRequest::getVar('toemail', '');
		// $toName = JRequest::getVar('toname', '','string');
		// $content = JRequest::getVar('content', '','string');
		
		// $attachment = JRequest::getVar('filedata',null,'files');
		
		// if(!is_uploaded_file($attachment['tmp_name']))
			// JError::raiseError(500,'error uploading image');
		
		// if('image/png' != $attachment['type'] || IMAGETYPE_PNG !== exif_imagetype(ini_get('upload_tmp_dir').'/'.$attachment['tmp_name']))
			// JError::raiseError(500,'invalid Image type');
		
		////load model
		// $model = $this->getModel('coloringbooks');
		
		// if(!$model->getColoringBook($cid,false)->email_enabled)
			// JError::raiseError(500,'Email is disabled on this book.');
		
		// if(!filter_var($toEmail,FILTER_VALIDATE_EMAIL)) 
			// JError::raiseError(500,'Invalid Email address');
		// $mail = new PHPMailer();
    // $mail->IsSendmail();
		
		// $mail->From       = 'noreply@evolvemediacorp.com';
		// $mail->FromName       = 'noreply';
		
		// $mail->Subject    = $fromName." Sent You Their Drawing!";
		// $mail->addAddress($toEmail,$toName);
		// $mail->Body = $content;
		// $mail->AddAttachment(ini_get('upload_tmp_dir').'/'.$attachment['tmp_name'],  '', 'base64', 'image/png');
		
		// if(!$mail->Send()) {
        // echo '{"error": "' . $mail->ErrorInfo . '"}';
    // } else {
        // echo '{"success": true}';
    // }
	

	// }
	
}
?>