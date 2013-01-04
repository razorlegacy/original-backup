<?php
defined('_JEXEC') or die();

class TableVideo extends JTable {
        public $video_id			= null;
        public $sid             	= null;
        public $pid 	     		= null;
        public $siteId	    		= null;
        public $videoId				= null;
		public $tab_id		    	= null;
        public $timestamp			= null;
        public $ordering			= null;
        public $sbFeed				= null;
               
        function __construct(&$db) {
                parent::__construct('#__syndi_video', 'video_id', $db);
        }
}

?>