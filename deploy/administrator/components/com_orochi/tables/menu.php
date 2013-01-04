    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableMenu extends JTable {
           public $id 				= null;
		   public $oid 				= null;
		   public $content			= null;
		   //public $type				= null;
		   //public $groups			= null;
		   public $ordering 		= null;
                     
           function TableMenu(&$db){
                 parent::__construct('#__orochi_menu', 'id', $db);
           }
    }

    ?>