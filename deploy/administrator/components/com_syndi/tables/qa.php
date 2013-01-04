<?php
defined('_JEXEC') or die();

class TableQa extends JTable {
        public $qa_id			= null;
        public $email			= null;
		public $title			= null;
		public $description		= null;
        public $tab_id          = null;
		public $timestamp		= null;
		public $ordering		= null;
		
        function __construct(&$db) {
                parent::__construct('#__syndi_qa', 'qa_id', $db);
        }
}

?>