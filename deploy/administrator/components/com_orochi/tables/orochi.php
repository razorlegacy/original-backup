    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableOrochi extends JTable {
           public $id 			= null;
		   public $title 		= null;
		   public $content 		= null;
           public $manager 		= null;
		   public $timestamp	= null;

          
           function TableOrochi(&$db){
                 parent::__construct('#__orochi', 'id', $db);
           }
    }

    ?>