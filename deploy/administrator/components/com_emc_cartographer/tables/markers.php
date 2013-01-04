    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableMarkers extends JTable {
       public $id 					= null;
	   public $cid 				= null;
	   public $gid 				= null;
       public $content 		= null;
	   public $coordinates 	= null;

       function TableMarkers(&$db){
             parent::__construct('#__emc_cartographer_markers', 'id', $db);
       }
    }

    ?>