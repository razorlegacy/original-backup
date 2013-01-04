<?php
defined('_JEXEC') or die();

class TableImage extends JTable {
        public $image_id			= null;
        public $image       		= null;
		public $clickURL 			= null;
        public $tab_id				= null;
		public $ordering			= null;
		public $timestamp			= null;
               
        function __construct(&$db) {
                parent::__construct('#__syndi_image', 'image_id', $db);
        }
}

?>