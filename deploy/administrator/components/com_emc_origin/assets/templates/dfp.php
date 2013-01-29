<h2>DFP</h2>
<div id="editor-dfp" ng:controller="templateCtrl">
	<ul class="originList">
		<li>
			<label>ID</label>
			<input type="text" ng:model="originEditor.content_data.url"/>
			<div class="onoffswitch">
		    	<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ng:model="originEditor.content_data.state">
		    	<label class="onoffswitch-label" for="myonoffswitch">
			    	<div class="onoffswitch-inner"></div>
			    	<div class="onoffswitch-switch"></div>
			    </label>
		    </div> 
		</li>
	</ul>
		
	<script>
		var templateCtrl = function($scope) {
			var _scope = angular.element($j('#workspaceCtrl')).scope(),
				_class;
				_scope.originEditor.content_config.width	= '32px';
				_scope.originEditor.content_config.height	= '32px';
				
			_scope.$watch('originEditor', function(){
				if(_scope.originEditor.content_data && _scope.originEditor.content_data.type === 'dfp') {
					switch(_scope.originEditor.content_data.state) {
						default:
						case false:
							_scope.originEditor.content_data.class 	= 'click';
							break;
						case true:
							_scope.originEditor.content_data.class 	= 'hover';
							break;
					}			
					
					_scope.originEditor.content_data.title		= _scope.originEditor.content_data.url;
					_scope.originEditor.content_render			= '<a href="'+_scope.originEditor.content_data.url+'" class="'+_scope.originEditor.content_data.class+'" <%=style%>></a>';
				}
			}, true);
		}
	</script>
</div>