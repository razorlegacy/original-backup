    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableMonitor extends JTable {
       public $id 			= null;
	   public $data 		= null;
	   public $start_date	= null;
       public $end_date		= null;
	         
       function TableMonitor(&$db){
             parent::__construct('#__emc_monitor', 'id', $db);
       }
    }

    ?>