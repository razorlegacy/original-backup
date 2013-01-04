<div id="editor-trigger">
	<label>Type</label>
	<span class="originButton editor-button" ng:click="originEditor.content.type = 'toggle'">Toggle</span>
	<span class="originButton editor-button" ng:click="originEditor.content.type = 'remove'">Remove</span>
	
	<label>Event</label>
	<span class="originButton editor-button" ng:click="originEditor.content.event = 'click'">Click</span>
	<span class="originButton editor-button" ng:click="originEditor.content.event = 'hover'">Hover</span>
	
	<div id="render" class="originUI-hidden">
		<div class="{{originEditor.content}} {{originEditor.event}}"></div>	
	</div>
</div>