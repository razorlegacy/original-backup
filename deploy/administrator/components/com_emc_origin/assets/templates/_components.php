<?php 
	$components = array(
					'dfp',
					'embed',
					'flash',
					'image',
					'link',
					'springboard',
					'trigger',
					'youtube'
					);
	foreach($components as $component) {
		?>
		<div ng:show="originWorkspace.panelEditor == '<?php echo $component;?>'">
		<?php
			include_once($component.'.php');
		?>
		</div>
		<?php
	}
?>