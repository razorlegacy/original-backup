    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableSyndi extends JTable {
           public $sid 			= null;
		   public $timestamp 	= null;
           public $syndi_name 	= null;
           public $syndi_bg		= null;
		   public $config 		= null;
		   public $manager 		= null;

          
           function TableSyndi(&$db){
                 parent::__construct('#__syndi', 'sid', $db);
           }
    }

    ?>