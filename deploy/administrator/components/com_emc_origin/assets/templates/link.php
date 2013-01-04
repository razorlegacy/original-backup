<h2>Link</h2>
<div id="editor-link">
	<label>Event</label>
	<div class="onoffswitch">
    	<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ng:model="originEditor.content">
    	<label class="onoffswitch-label" for="myonoffswitch">
	    	<div class="onoffswitch-inner"></div>
	    	<div class="onoffswitch-switch"></div>
	    </label>
    </div> 	
		
	<div id="render" class="originUI-hidden" render>
		<script>
			var _scope = angular.element($j('#workspaceCtrl')).scope(),
				_class;
				switch(_scope.originEditor.content) {
					case 'false':
						_class	= 'click';
						break;
					case 'true':
						_class	= 'hover';
						break;
				}
				_scope.originEditor.content_render	= '<a href="#" class="'+_class+'" <%=style%>></a>';
		</script>
	</div>
</div>