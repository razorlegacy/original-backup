    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableCartographer extends JTable {
       public $id 					= null;
	   public $name 				= null;
	   public $content 				= null;
       public $manager 				= null;
	   public $modified_by 			= null;
	   public $timestamp			= null;
	   public $published			= null;

      
       function TableCartographer(&$db){
             parent::__construct('#__emc_cartographer', 'id', $db);
       }
    }

    ?>