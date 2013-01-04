<?php
	class evolveUi {
		public function dialogButton($iconId, $text, $name, $class, $dataArray = '') {
			$data		= '';
			if($dataArray) {
				foreach($dataArray as $key=>$value) {
					$data	.= "data-{$key}='{$value}'";
				}
			}
			
			return "<a href='#' class='evolve-ui-button {$class}' name='{$name}' {$data}><span class='evolve-ui-icon evolve-ui-icon{$iconId}'></span><span class='evolve-ui-label'>{$text}</span></a>";
		}
		
		
		public function uploadButton($iconId, $text, $name, $class, $classInput) {
			return "<a href='#' class='evolve-ui-button {$class}' name='{$name}'><span class='evolve-ui-icon evolve-ui-icon{$iconId}'></span><span class='evolve-ui-label'>{$text}</span><input type='file' class='{$classInput}' name='files[]'></a>";
		}
	}	
?>