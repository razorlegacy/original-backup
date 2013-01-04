<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Greetings Component
 *
 */
class BracketViewBracket extends JView
{
             
    function display()
    {
        /*$model = &$this->getModel();
        $greetings = $model->getBracket();
        $this->assignRef( 'greetings', $greetings );*/
        $params = &JComponentHelper::getParams( 'cid' );
        parent::display();
    }
}
?>