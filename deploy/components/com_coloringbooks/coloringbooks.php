<?php
/**
 * Entry point for public interface to coloring books component
 *
 * @package ColoringBooks
 */

defined('_JEXEC') or die();

require_once(JPATH_COMPONENT.DS.'ColoringBooksController.php');

$controller	= new ColoringBooksController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>