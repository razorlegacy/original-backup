    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableGroups extends JTable {
           public $id 				= null;
		   public $oid 				= null;
		   public $mid				= null;
		   //public $content			= null;
		   public $link				= null;
		   public $size				= null;
		   public $ordering 		= null;
		   
           function TableGroups(&$db){
                 parent::__construct('#__orochi_groups', 'id', $db);
           }
    }

    ?>