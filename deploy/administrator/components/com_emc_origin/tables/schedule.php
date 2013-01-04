    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableSchedule extends JTable {
       public $id 				= null;
	   public $oid 			= null;
	   public $start_date 	= null;
	   public $end_date 	= null;
	   
       function TableSchedule(&$db){
             parent::__construct('#__emc_origin_schedule', 'id', $db);
       }
    }

    ?>