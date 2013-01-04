<?php
	class azureUi {
		public function buildButton($icon, $label, $name, $class, $color = 'black', $dataArray = '') {
			$data		= '';
			if($dataArray) {
				foreach($dataArray as $key=>$value) {
					$data	.= "data-{$key}='{$value}'";
				}
			}
			
			return "<a href='#' class='azure-btn {$class}' name='{$name}' {$data}><div class='azure-btn-label'>{$label}</div><img class='azure-btn-icon' src='/libraries/evolve/images/evolve/_{$color}/{$icon}.png'/></a>";
		}
	}	
?>