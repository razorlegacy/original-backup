'use strict';

angular.module('originApp.directives', [])
	.directive('contentTest', function() {
		return {
			restrict: 'E',
			link: function(scope, element, attrs) {
				//element.replaceWith('here');
				console.log($j(element).replaceWith('tes'));
			}
		}
	})
	.directive('asset', function($compile) {
		return {
			link: function(scope, item, attrs) {
				item.draggable({
					revert: true,
					revertDuration: 0,
					start: function(event, ui) {
						scope.$parent.asset	= scope.asset;
					}
				});
			}
		}	
	})
	.directive('content', function() {
		return {
			restrict: 'E',
			link: function(scope, item, attrs) {
				var type 	= scope.content.content_data.type,
					color,
					colorRgb,
					css		= {},
					style	= '';
					
				$j.each(scope.content.content_config, function(index, value) {
					css[index] 	= value;
					style		+= index+':'+value+';';
				});
				
				console.log(item);
				item.replaceWith('test');
				//item.html(_.template(scope.content.content_render)({style: style}));
				//item.replaceWith(_.template(scope.content.content_render)({style: style}));
				//item.css(css);
			
					
				_(scope.components).find(function(component) {
					_(component.content).find(function(content) {
						if(content.alias === type) {
							color = component.color;
						}
					});
				});
	
				scope.$watch('content', function(content) {
					var css = {
						top:	content.content_config.coordY+'px',
						left:	content.content_config.coordX+'px',
						width:	content.content_config.width+'px',
						height: content.content_config.height+'px',
						zIndex: content.content_config.zIndex
						//outlineColor: color
						//backgroundColor: 'rgba('+colorRgb.r+', '+colorRgb.g+', '+colorRgb.b+', .2)'
					}
					item.css(css);
				});
			
				item.draggable({
					containment: 'parent',
					create: function(event, ui) {
						
					},
					stop: function(event, ui) {
						scope.content.content_config.width		= ui.helper.width()+'px';
						scope.content.content_config.height		= ui.helper.height()+'px';
						scope.content.content_config.left		= ui.position.left+'px';
						scope.content.content_config.top		= ui.position.top+'px';
						
						console.log(scope.content.content_config);
						//scope.originSave('content_config', scope.content.content_config);
					}
				});
				

				item.resizable({
					containment: 'parent',
					stop: function(event, ui) {
						scope.content.content_config.height		= ui.helper.height()+'px';
						scope.content.content_config.width		= ui.helper.width()+'px';
						//scope.originSave('content_config', scope.content.content_config);
					}
				});
				
			}
		}
	})
	.directive('workspace', function() {
		return function(scope, item, attrs) {
			//Assigns droppable event
			item.droppable({
				accept: '.asset',
				drop: function(event, ui) {
				
					var content_render,
						content_data = {
							content:scope.asset.name
						},
						content_config = {
							top: 	Math.floor(event.pageY - $j(this).offset().top)+'px',
							left: 	Math.floor(event.pageX - $j(this).offset().left)+'px',
							zIndex: parseInt(scope.originObj.zIndex)+1
						};

					switch(scope.asset.type) {
						case 'swf':
							content_data.type = 'flash';
							break;
						default:
							content_data.title	= scope.asset.name+'-'+content_config.zIndex;
							content_data.type 	= 'image';
							content_render		= '<img src="http://'+document.domain+'/assets/components/com_emc_origin/'+scope.originObj.oid+'/'+scope.asset.name+'" style="<%=style%>"/>';
							break;
					}
					
					scope.originSave('content_create', {
						oid: scope.originObj.oid,
						sid: scope.originObj.sid,
						content_data: content_data,
						content_config: content_config,
						content_render: content_render,
						state: scope.state_content
					});
				}
			});
		}	
	});
				