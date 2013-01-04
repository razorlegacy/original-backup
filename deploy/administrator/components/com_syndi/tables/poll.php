<?php
defined('_JEXEC') or die();

class TablePoll extends JTable {
        public $poll_id		= null;
        public $title		    		= null;
        public $polldaddy_feed	= null;
		public $polldaddy_key		= null;
		public $tab_id		    	= null;
        public $ordering				= null;
		public $timestamp			= null;
        
        function __construct(&$db) {
                parent::__construct('#__syndi_poll', 'poll_id', $db);
        }
}

?>