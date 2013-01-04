    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableContent extends JTable {
       public $id 		= null;
	   public $oid 		= null;
	   public $sid 		= null;
	   public $content	= null;
	   public $config 	= null;
	   public $render	= null;
	   public $state 	= null;
	   
       function TableContent(&$db){
             parent::__construct('#__emc_origin_content', 'id', $db);
       }
    }

    ?>