<h2>Trigger</h2>
<div id="editor-trigger" ng:controller="templateCtrl">
	<ul class="originList">
		<li>
			<div id="switch-trigger-state" class="onoffswitch">
		    	<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-state" ng:model="originEditor.content_data.state">
		    	<label class="onoffswitch-label" for="myonoffswitch-state">
			    	<div class="onoffswitch-inner"></div>
			    	<div class="onoffswitch-switch"></div>
			    </label>
		    </div> 
		</li>
		<li>
			<div id="switch-trigger-effect" class="onoffswitch">
		    	<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-effect" ng:model="originEditor.content_data.effect">
		    	<label class="onoffswitch-label" for="myonoffswitch-effect">
			    	<div class="onoffswitch-inner"></div>
			    	<div class="onoffswitch-switch"></div>
			    </label>
		    </div> 
		</li>
	</ul>
		
	<script>
		var templateCtrl = function($scope) {
			var _scope = angular.element($j('#workspaceCtrl')).scope();
				_scope.originEditor.content_config.width	= '32px';
				_scope.originEditor.content_config.height	= '32px';
				
				
			_scope.$watch('originEditor', function() {
				if(_scope.originEditor.content_data && _scope.originEditor.content_data.type === 'trigger') {
					switch(_scope.originEditor.content_data.state) {
						default:
						case false:
							_scope.originEditor.content_data.class 	= 'click';
							break;
						case true:
							_scope.originEditor.content_data.class 	= 'hover';
							break;
					}			
					
					switch(_scope.originEditor.content_data.effect) {
						default:
						case false:
							_scope.originEditor.content_data.effectClass	= 'toggle';
							break;
						case true:
							_scope.originEditor.content_data.effectClass	= 'remove';
							break;
					}
					
					_scope.originEditor.content_data.title		= _scope.originEditor.content_data.effectClass;
					_scope.originEditor.content_render			= '<a class="trigger" data-type="'+_scope.originEditor.content_data.class+'" data-effect="'+_scope.originEditor.content_data.effectClass+'" <%=style%>></a>';
				}
			}, true);
		}
	</script>
</div>