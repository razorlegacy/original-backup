    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableOrigin extends JTable {
       public $id 				= null;
	   public $name 			= null;
	   public $config 			= null;
	   public $content			= null;
       public $manager 			= null;
	   public $modified_by 		= null;
	   public $modify_date		= null;
	   public $create_date		= null;
	   
      
       function TableOrigin(&$db){
             parent::__construct('#__emc_origin', 'id', $db);
       }
    }

    ?>