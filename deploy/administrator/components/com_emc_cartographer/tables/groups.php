    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableGroups extends JTable {
       public $id 					= null;
	   public $cid 				= null;
	   public $content 		= null;
       public $ordering 		= null;
	   
       function TableGroups(&$db){
             parent::__construct('#__emc_cartographer_groups', 'id', $db);
       }
    }

    ?>