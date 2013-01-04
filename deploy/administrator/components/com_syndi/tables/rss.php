<?php
defined('_JEXEC') or die();

class TableRss extends JTable {
        public $rss_id					= null;
        public $feed_url				= null;
		public $articles_number	= null;
		public $tab_id  					= null;
        public $ordering				= null;
		public $timestamp			= null;
        
        function __construct(&$db) {
                parent::__construct('#__syndi_rss', 'rss_id', $db);
        }
}

?>