<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class GiftGuidesController extends JController {

	/**
	* Controller view display
	*/
	function display() {
		//default view (2nd arg)
		$viewName	= JRequest::getVar('view', 'list');
		
		//Set default view layout/template
		$viewLayout	= JRequest::getVar('layout', 'default');
		
		$view =& $this->getView($viewName, 'html');
		
		//Get/Create model
		if($model =& $this->getModel('giftguides')) {
			//push model into the view
			$view->setModel($model, true);
		}
		
		$view->setLayout($viewLayout);
		$view->display();
	}
	
	/**
	* Create new gift guide
	*/
	function createGiftGuide() {
		
		$viewName		= JRequest::getVar('view', 'form');
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView($viewName, 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		
		$view->setLayout($viewLayout);
		$view->displayCreate();
	}
	
	/**
	* Saves gift guide
	**/
	function saveGiftGuide() {
		$post	= JRequest::get('post');
						
		$giftguidesModel	=& $this->getModel('save');
		
		//New gift guide creation
		$gid				= $giftguidesModel->saveGiftGuides($post);
		
		//Move onto Category/Product page
		$view			=& $this->getView('form', 'html');
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout('products');
		$view->displayCreateProduct($gid);
	}
	
	/**
	* Updates gift guide and associated meta data and exits to list
	**/
	function saveExitGiftGuide(){
		$post	= JRequest::get('post');
		$gid	= JRequest::getVar('id');
				
		$giftguidesModel	=& $this->getModel('save');
		$giftguidesModel->saveGiftGuides($post);
			
		$redirectTo	= JRoute::_("index.php?option=com_giftguides");
		$this->setRedirect($redirectTo, "Gift Guide saved");
	}
	
	/**
	* Edit gift guide
	*/
	function editGiftGuide() {
		$cids	= JRequest::getVar('cid', null, 'default', 'array');
		
		//Error checking
		if($cids == null) {
			JError:: raiseError(500, 'cid parameter missing from request');
		}
				
		//Only supposed to edit one at a time
		$gid			= (int)$cids[0];
		
		$viewName		= JRequest::getVar('view', 'form');
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('form', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		
		$view->displayGiftGuideEdit($gid);
	}
	
	function saveCategory() {
		$post	= JRequest::get('post');		
		$categoryModel	=& $this->getModel('save');
		
		$cid			= $categoryModel->saveCategory($post);
		$post['cid']	= $cid;
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
	}
	
	/**
	*
	**/
	function saveCategoryOrder() {
		$post	= JRequest::get('post');
		
		$categoryModel	=& $this->getModel('save');
		$categoryModel->saveCategoryOrder($post);
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
	}
	
	/**
	*
	**/
	function saveProduct() {
		$post	= JRequest::get('post', JREQUEST_ALLOWHTML);
		
		$productModel	=& $this->getModel('save');
		$aliasModel		=& $this->getModel('save');
				
		$pid			= $productModel->saveProduct($post);
		$post['pid']	= $pid;
		$aliasModel->saveAlias('product', 'alias', $post['title'], $post['gid'], $pid);
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
	}
	
	/**
	*
	**/
	function saveProductOrder() {
		$post	= JRequest::get('post');
		
		$productModel	=& $this->getModel('save');
		$productModel->saveProductOrder($post);
		
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
	}
	
	/**
	*
	**/
	function saveFeatured() {
		$post		= JRequest::get('post');
		
		$categoryModel	=& $this->getModel('save');
		$categoryModel->saveFeatured($post);
		
		//$categoryModel->saveCategory($post);
	}
	
	function deleteGiftGuide() {
		$gids	= JRequest::getVar('cid', null, 'default', 'array');
			
		if($gids == null) {
			JError::raiseError(500, "id parameter missing from request");
		}
		
		$giftguideModel		=& $this->getModel('save');
		$categoryModel		=& $this->getModel('save');
		$productModel		=& $this->getModel('save');
		
		//Remove gift guide
		$giftguideModel->deleteGiftGuide($gids);
		
		//Remove corresponding categories
		$categoryModel->deleteCategoryBulk('gid', $gids);
		
		//Remove corresponding products
		$productModel->deleteProductsBulk('gid', $gids);
		
		$redirectTo	= JRoute::_("index.php?option=".JRequest::getVar('option'));
		$this->setRedirect($redirectTo, "Gift Guide(s) removed");
	}
	
	function deleteCategory() {
		$post	= JRequest::get('post');
		
		$cid	= $post['id'];
		//Patch for other bulk deleters
		$cid_product	= array($post['id']);
		
		$categoryModel	=& $this->getModel('save');
		$productModel	=& $this->getModel('save');
		
		//Remove category
		$categoryModel->deleteGeneric($cid, 'category', $post['gid']);
		//Remove product by category
		$productModel->deleteProductsBulk('cid', $cid_product);
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
		
	}
	
	function deleteProduct() {
		$post	= JRequest::get('post');
		$pid	= $post['id'];
				
		$productModel	=& $this->getModel('save');
		$productModel->deleteGeneric($pid, 'product', $post['gid']);
		
		//Remove image file
		//print_r($post['img_large']);
		//unlink('..'.$post['img_large']);
		
		$viewLayout		= JRequest::getVar('layout', 'default');
		$view			=& $this->getView('response', 'html');
		
		$view->setModel($this->getModel('giftguides'), true);
		$view->setLayout($viewLayout);
		$view->response($post);
	}
	
	function copyGiftGuide() {
		$gids	= JRequest::getVar('cid', null, 'default', 'array');
			
		if($gids == null) {
			JError::raiseError(500, "id parameter missing from request");
		}
		
		$giftguideModel		=& $this->getModel('save');
		$giftguideModel->copyGiftGuide($gids[0]);
		
		$redirectTo	= JRoute::_("index.php?option=".JRequest::getVar('option'));
		$this->setRedirect($redirectTo, "Gift Guide(s) copied");
	}
}
?>