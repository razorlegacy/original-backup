<?php

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class BracketViewList extends JView
{
	function display() {
		$document =& JFactory::getDocument();
		JToolBarHelper::title('Bracket Manager');
		
		//JToolBarHelper::title(   JText::_( 'TERM MANAGER' ), 'tag.png' );
		//JToolBarHelper::editListX();
		//JToolBarHelper::spacer();
		JToolBarHelper::addNewX();
		JToolBarHelper::spacer();
		//JToolBarHelper::customX('batchadd','new','',JText::_( 'BATCH ADD'),false);
		//JToolBarHelper::spacer();
		JToolBarHelper::deleteListX();
		//JToolBarHelper::spacer();
		//JToolBarHelper::back('Control Panel','index.php?option=com_tag');
		
		$params = JComponentHelper::getParams('com_bracket');
		$this->assignRef('params', $params);
		$bracketList = $this->get('bracketList', array());
		$this->assignRef('bracketList', $bracketList);
		
		parent::display();
	}
	
	/*function display()
	{
		$document =& JFactory::getDocument();
		$document->addScript('/includes/js/overlib_mini.js');
		
		JToolBarHelper::title('Hot or Not?');
		
		$categories = $this->get('categories');
		$images = $this->get('images');
		$pagination = $this->get('pagination');
		$currentCategoryID = $this->get('current_category_id');
		$filterOrder = $this->get('filter_order');
		$filterOrderDir = $this->get('filter_order_dir');
		$categoryType = $this->get('category_type');
		
		$this->assignRef('images', $images);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('categories', $categories);
		$this->assignRef('current_category_id', $currentCategoryID);
		$this->assignRef('filter_order', $filterOrder);
		$this->assignRef('filter_order_dir', $filterOrderDir);
		$this->assignRef('category_type', $categoryType);
		
		parent::display();
	}*/
}