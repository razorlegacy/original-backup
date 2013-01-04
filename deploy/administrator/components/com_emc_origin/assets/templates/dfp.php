<h2>DFP Link</h2>
<div id="editor-link">
	<ul class="originList">
		<li>
			<label>Type</label>
		</li>
		<li>
			<a 
		</li>
	</ul>
	<label>Event</label>
		<input type="radio" id="link-click" name="link-event"/><label for="link-click" id="link-click" class="originButton-radio">Click</label>
		 <input type="radio" id="link-hover" name="link-event"/><label for="link-hover" id="link-hover" class="originButton-radio">Hover</label>
		<!--
		<span class="originButton editor-button" ng:click="originEditor.event = 'click'">Click</span>
	<span class="originButton editor-button" ng:click="originEditor.event = 'hover'">Hover</span>
		-->
	
	<div ng:show="originEditor.type == 'standard'">
		<label>Link</label>
		<input type="text" ng:model="originEditor.content"/>
	</div>
	
	<div id="render" class="originUI-hidden">
		<a href="{{originEditor.content}}" class="link" target="_blank" data-type=""></a>
	</div>
</div>