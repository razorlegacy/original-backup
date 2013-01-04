    <?php

    defined('_JEXEC') or die('Restricted Access');

    class TableFacebook extends JTable {
           public $facebook_id 	= null;
		   public $name			= null;
		   public $alias		= null;
		   public $feedURL 	 	= null;
		   public $header		= null;
           public $colorscheme	= null;
		   public $tab_id      	= null;
		   public $ordering		= null;
		   public $timestamp 	= null;
          
           function __construct(&$db){
                 parent::__construct('#__syndi_facebook', 'facebook_id', $db);
           }
    }

    ?>