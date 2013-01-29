<h2>Embed</h2>
<div id="editor-embed" ng:controller="templateCtrl">
	<textarea id="" ui:codemirror="{theme:'night', lineWrapping: true}" ng:model="originEditor.content_data.embed"></textarea>
	<script>
		var templateCtrl = function($scope) {
			var _scope = angular.element($j('#workspaceCtrl')).scope();
				_scope.originEditor.content_config.width	= (!_scope.originEditor.content_config.width)? '32px': _scope.originEditor.content_config.width;
				_scope.originEditor.content_config.height	= (!_scope.originEditor.content_config.height)? '32px': _scope.originEditor.content_config.height;
				
			_scope.$watch('originEditor', function() {
				if(_scope.originEditor.content_data && _scope.originEditor.content_data.type === 'embed') {
					_scope.originEditor.content_data.title		= 'Custom Embed';
					_scope.originEditor.content_render			= '<iframe class="data-embed" src="%cid%" <%=style%> id="embed-%id%" frameborder="0" scrolling="0"></iframe>';
				}
			}, true);
		}
	</script>
</div>