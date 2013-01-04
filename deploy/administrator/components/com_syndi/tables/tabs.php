<?php
defined('_JEXEC') or die();

class TableTabs extends JTable {
        public $tab_id		= null;
        public $sid			= null;
        public $title		= null;
        public $alias		= null;
        public $typetab		= null;
        public $tab_bg		= null;
        public $timestamp	= null;
        public $tab_order	= null;
		
        function __construct(&$db) {
                parent::__construct('#__syndi_tabs', 'tab_id', $db);
        }
}

?>