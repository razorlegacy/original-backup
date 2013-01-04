    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableTwitter extends JTable {
           public $twitter_id 			= null;
		   public $twitter_config 	= null;
		   public $tab_id      			= null;
		   public $ordering				= null;
		   public $timestamp 		= null;
          
           function __construct(&$db){
                 parent::__construct('#__syndi_twitter', 'twitter_id', $db);
           }
    }

    ?>