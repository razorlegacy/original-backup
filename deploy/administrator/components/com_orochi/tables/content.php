    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableContent extends JTable {
           public $id 				= null;
		   public $oid 				= null;
		   public $gid 				= null;
		   public $mid				= null;
		   public $content 			= null;
           public $ordering	 		= null;
		   
           function TableContent(&$db){
                 parent::__construct('#__orochi_content', 'id', $db);
           }
    }

    ?>