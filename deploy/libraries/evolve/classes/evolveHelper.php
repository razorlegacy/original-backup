<?php
	class evolveHelper {
		/**
		*
		**/
		function __construct() {
			$host_name 	= $_SERVER["HTTP_HOST"];
	        $prefix 	= "admin.";
	
	        if(stristr($host_name, $prefix)) {
	        	$host_name = str_replace($prefix, "", $host_name);
	        }
	        define('emcHostName', $host_name);
		}
	
		/**
		* Searches rendered HTML for a specific tag and extracts the attribute
		* @param string $source Formatted HTML
		* @param string $tag HTML tag
		* @param string $attr HTML attribute
		* @return string HTML's tag attribute
		**/
		function parseHTML($source, $tag, $attr) {
		
			$doc	= new DOMDocument();
			$doc->loadHTML($source);
			
			$xml	= simplexml_import_dom($doc);
			$result	= $xml->xpath('//'.$tag);
			
			return $result[0][$attr];
		}
		
		
		/**
		*
		**/
		function limitIntroText($introtext, $limit = 100) {
			$introtext	= trim(strip_tags($introtext));
			
			if(strlen($introtext) > $limit) {
				$introtextShort		= substr($introtext, 0, $limit);
				$introtext			= substr($introtextShort, 0, strrpos($introtextShort, ' ')).'...';
			}
			
			return $introtext;
		}
		
		/*
		*	Returns a content with HTML line breaks
		*	@return string
		*/
		function strMultilineContent($content) {
			$search   = array("\\r\\n", "\\n", "\\r");
			$replace = '<br />';
				
			$content = str_replace($search, $replace, $content);
			
			return	$content;
		}
		
	}
?>