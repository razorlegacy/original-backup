'use strict';

angular.module('originApp.directives', [])
	.directive('asset', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				element.draggable({
					revert: true,
					revertDuration: 0,
					start: function(event, ui) {
						scope.panelSlide('close');
						element.data('asset', scope.asset);
					}
				});
			}
		}
	})
	.directive('config', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				element.keyup(function(event) {
					
					if(event.keyCode === 38 || event.keyCode === 40) {
						switch(event.keyCode) {
							case 38:
								var value 	= element.val().split('px')[0],
	                    			value 	= Number(value) + 1;
	                    			element.val(value+'px');
								break;
							case 40:
								var value 	= element.val().split('px')[0],
	                    			value 	= Number(value) - 1;
	                    			element.val(value+'px');
								break;
						}
						
						scope.$apply(function() {
	                    	scope.originEditor.content_config[attrs.config] 	= element.val();
	                    	//Update workspace
	                    	//console.log(scope.originEditor.content_config[attrs.config]);
	                    	$j('#workspace #content-'+scope.originEditor.id).css(attrs.config, element.val());
	                    });
					}
/*
					switch (event.keyCode) {
	                    case 38:
	                    	var value 	= element.val().split('px')[0],
	                    		value 	= Number(value) + 1;
	                    	element.val(value+'px');
	                    	
	                    	scope.$apply(function() {
	                    		scope.originEditor.content_config[attrs.config] 	= element.val();
	                    	});	                    	
	                    	break;
	                    case 40: 
	                    	var value 	= element.val().split('px')[0],
	                    		value 	= Number(value) - 1;
	                    	element.val(value+'px');
	                    	
	                    	scope.$apply(function() {
	                    		scope.originEditor.content_config[attrs.config] 	= element.val();
	                    	});
	                    	break;
	                }
*/
				});
				
				element.blur(function(event) {
					var value 	= element.val(),
	                    value 	= value.match(/[0-9]+/g);
	                element.val(value[0]+'px'); 
	                
	                scope.$apply(function() {
	                    scope.originEditor.content_config[attrs.config] 	= element.val();
	                });              
				});
			}
		}
	})
	.directive('content', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
			/*
	scope.$watch('originEditor.content_config.top', function() {
					console.log('here');
				});
*/
			
				//Apply parent's CSS
				var parentCSS	= {},
					elementCSS	= '';
				$j.each(scope.content.content_config, function(key, value) {
					parentCSS[key]	= value;
					elementCSS		+= key+':'+value+';';
				});
				element.css(parentCSS);
				element.html(_.template(scope.content.content_render)({style: 'style='+elementCSS}));
				
				//Double click opens config
				element.dblclick(function() {
					scope.$apply(function() {
						//scope.originEditor.content_config[attrs.config] 	= element.val();
						scope.panelSlideEditor(scope.content.content_data.type, scope.content);
	                });
				});
				
				//Resizable on supported elements
				element.resizable({
					containment: 'parent',
					stop: function(event, ui) {
						
					}
				});
				
				//Make it draggable too
				element.draggable({
					containment: 'parent',
					stop: function(event, ui) {
						//construct config dataset
						var config = {
							top: 	Math.round(ui.position.top)+'px',
							left: 	Math.round(ui.position.left)+'px',
							width: 	Math.round(ui.helper.width())+'px',
							height: Math.round(ui.helper.height())+'px',
							zIndex: ui.helper.css('z-index')
						}
						
						//scope.originEditor.content_config	= config;
						scope.originServices('content_config', {id: scope.content.id, oid: origin_id, config: config});
					}
				});
			}
		}
	})
	.directive('layer', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				//console.log(scope.layer);
				element.data('layer', scope.layer);
			}
		}
	})
	.directive('layers', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				element.sortable({
					axis: 'y',
					handle: '.layer-thumbnail',
					update: function(event, ui) {
						var data	= scope.originObj.current;
						$j.each(element.sortable('toArray', {attribute: 'data-index'}).reverse(), function(key, content) {
							$j.grep(data, function(element, index) {
								if(element.id === content) {
									element.content_config.zIndex	= key+'';
									element.oid						= origin_id;
								}
							});
						});
						scope.originServices('order', data);
					}
				});
			}
		}
	})
	.directive('workspace', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				//Creates elements drag & dropped from the assets panel
				element.droppable({
					accept: '.asset',
					drop: function(event, ui) {
						//Pull out data
						var asset		= ui.draggable.data('asset'),
							data		= {},
							template;
						
						data.oid	= origin_id;
						data.sid	= scope.originObj.content[scope.originWorkspace.schedule].id;
						data.state	= scope.originWorkspace.state_view;
						data.content_data = {
							content:	asset.name,
							title:		asset.name+'-'+''
						};
						
						data.content_config	= {
							top: 	Math.floor(event.pageY - $j(this).offset().top)+'px',
							left:	Math.floor(event.pageX - $j(this).offset().left)+'px',
							width: 	asset.width+'px',
							height: asset.height+'px',
							zIndex: '0'
						};
							
						switch(asset.type) {
							case 'swf':
								data.content_data.type 	= 'flash';
								break;
							default:
								data.content_data.type 	= 'image';
								data.content_render		= '<img src="http://'+document.domain+'/assets/components/com_emc_origin/'+origin_id+'/'+asset.name+'" <%=style%>/>';
								break;
						}
						
						scope.originServices('content', data);
					}
				});
			}
		}
	})
	.directive('workspaceUI', function() {
		return {
			restrict: 'C',
			link: function(scope, element, attrs) {
				//console.log(scope.originWorkspace);
				//console.log(element);
				//console.log(attrs);
			}
		}
	});
/*
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
*/
				