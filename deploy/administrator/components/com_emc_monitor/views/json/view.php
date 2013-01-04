<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class MonitorViewJson extends JView {
	/*function displayList() {
		$model 	= $this->getModel('query');
		$monitor = $model->getMonitor();
		$this->assignRef('monitor', $monitor);
		parent::display();
	}*/
	function displayData() {
		$model 	= $this->getModel('query');
		$monitor = $model->getMonitor();
		$this->assignRef('monitor', $monitor);
		parent::display();
	}
	function displayDataUp($monitor) {
		$this->assignRef('category', $monitor['category']);
		$model 	= $this->getModel('query');
		$monitor = $model->getCategoryData($monitor);
		$this->assignRef('monitor', $monitor);
		
		parent::display();
	}
}