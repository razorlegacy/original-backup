<?php /* vim: set filetype=javascript: */ defined('_JEXEC') or die('Restricted access'); ?>
var _gaq = _gaq || [];
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

var ao_sliver = (function (window, document) {
	return function (spec, my) {
		var config	= spec;
		my = my || {};
			
		//Cross browser custom event handling
		my.event = {};
		my.event.bind = (function(window, document) {
			if (document.addEventListener) {
				return function( elem, type, cb ) {
					var i;
					if ((elem && !elem.length) || elem === window) {
						elem.addEventListener(type, cb, false );
					}
					else if (elem && elem.length) {
						var len = elem.length;
						for (i = 0; i < len; i++) {
							my.event.bind(elem[i], type, cb);
						}
					}
				};
			}
		// this only supports custom events
			else if (document.attachEvent) {
				return function (elem, type, cb) {
					var i,len;
					if ((elem && !elem.length) || elem === window) {
						if (elem[type] === undefined) {
							elem[type] = 0;
						}
						elem.attachEvent('onpropertychange', function(event) {
							if (event.propertyName === type) {
								return cb.call(elem, window.event);
							}
						});
					}
					else if (elem.length) {
						len = elem.length;
						for (i = 0; i < len; i++) {
							my.event.bind(elem[i], type, cb);
						}
					}
				};
			}
		})(this, document);
		
	// TODO: Make this safe for non-custom events
		my.event.fire = (function () {
			if (document.createEvent) {
				return function (fireOnThis, evt) {
					var evObj = document.createEvent('Event');
					evObj.initEvent(evt, true, false);
					fireOnThis.dispatchEvent(evObj);
				};
			} else if (document.createEventObject) {
				return function (fireOnThis, evt) {
					if (typeof fireOnThis[evt] === 'number') {
						fireOnThis[evt]++;
					}
				};
			}
		})();


		// mini-interface to the cookies
		my.storage = {
			store: function (name, value, days) {
				var expires;
				if (days) {
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					expires = "; expires=" + date.toGMTString();
				} else {
					expires = "";
				}
				document['coo' + 'kie'] = name + "=" + value + expires + "; path=/";
			},
			read: function (name) {
				name = name || 'sliver_open_'+config.id;
				var nameEQ = name + "=";
				var ca = document['coo' + 'kie'].split(';');
				var i;
				for (i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) === ' ') {
						c = c.substring(1, c.length);
					}
					if (c.indexOf(nameEQ) === 0) {
						return c.substring(nameEQ.length, c.length);
					}
				}
				return false;
			}
		};

		/** elem is a DOM element that you want to adjust the vertical background position on
		* delta is an integer value in pixels that you would like to adjust the background by
		* NOTE: This is adjusted immediately. For animations this is meant to be called at each successive 
		* step of the animation.
		*/
		my.adjustBGYPosition = function (delta, elem) {
			elem = elem || my.body;
			var bg_position = my.getBGPos();
			if (bg_position.y !== null) {
				elem.style.backgroundPosition = bg_position.x + ' ' + (delta + bg_position.y) + "px";
			}

		};

		my.getCompProp = (function () {

			var ao_rupper = /([A-Z]|^ms)/g,
				ao_rnumpx = /^-?\d+(?:px)?$/i,
				ao_rnum = /^-?\d/,
				ao_rpct = /%$/,
				px,
				getComputedStyle,
				currentStyle;

			/**
			 * Return position in pixels
			 */
			px = function (elem, ret) {
				var left,
					rsLeft = elem.runtimeStyle && elem.runtimeStyle[name],
					style = elem.style;
				// A bit of logic for normalizing single or double value background properties
				var retY = ret;
				var retArry = ret.split(' ', 2);
				if (retArry.length > 1) {
					retY = retArry[1];
				} else {
					retY = retArry[0];
				}

				// if not 0, a pixel property, percentage, but still a number, try to get a pixel value out.
				// From the awesome hack by Dean Edwards
				// http://erik.eae.net/archives/2007/07/27/18.54.15/#comment-102291
				if (!ao_rnumpx.test(retY) && ao_rnum.test(retY) && !ao_rpct.test(retY)) {
					// Remember the original values
					left = style.left;

					// Put in the new values to get a computed value out
					if (rsLeft) {
						elem.runtimeStyle.left = elem.currentStyle.left;
					}
					style.left = name === "fontSize" ? "1em" : (retY || 0);
					retY = style.pixelLeft + "px";

					// Revert the changed values
					style.left = left;
					if (rsLeft) {
						elem.runtimeStyle.left = rsLeft;
					}
					//my own little bit of logic - not sure if its a correct assumption
				} else if (retY === 'top' || retY === '0%') {
					retY = '0px';
				}

				// Whatever it came in as it's got to go out as
				if (retArry.length > 1) {
					retArry[1] = retY;
					ret = retArry.join(' ');
				} else {
					ret = retY;
				}
				return ret;
			};

			// get the computed style the W3C way
			if (document.defaultView && document.defaultView.getComputedStyle) {
				getComputedStyle = function (elem, name) {
					var ret, defaultView, computedStyle;

					name = name.replace(ao_rupper, "-$1").toLowerCase();

					if (!(defaultView = elem.ownerDocument.defaultView)) {
						return undefined;
					}

					if ((computedStyle = defaultView.getComputedStyle(elem, null))) {
						ret = computedStyle.getPropertyValue(name);
					}

					if (name === 'background-position' || name === 'background-position-y') {
						ret = px(elem, ret, name);
					}

					return ret;
				};
			}

			// Get the computed style the IE < 9 way
			if (document.documentElement.currentStyle) {
				currentStyle = function (elem, name) {
					var ret = elem.currentStyle && elem.currentStyle[name];
					if (ret === 'auto') {
						ret = elem.offsetHeight+ "px";
					}
					ret = px(elem, ret);

					return ret === "" ? "auto" : ret;
				};
			}

			// If we can use the W3C way, do so otherwise fall back to IE
			var curCSS = getComputedStyle || currentStyle;
			return curCSS;
		})();

	// Takes strings with css pixel measurement and returns the integer value.
		my.dePixel = function (value) {
			if (typeof(value) === 'number') {
				return value;
			}

			var pixelvalueregex = /^(-?\d+)px$/;
			var matches = value.match(pixelvalueregex);

			if (matches !== null) {
				return parseInt(matches[1], 10);
			}
			return matches;
		};

		my.setElementHeight = function (el, height) {
			var preWrapperHeight = my.sliverWrapper.offsetHeight;
			el.style.height = height + 'px';
			var postWrapperHeight = my.sliverWrapper.offsetHeight;
			var delta = postWrapperHeight - preWrapperHeight;
			if (delta) {
				my.adjustBGYPosition(delta);
			}
		};

		my.animation = {};
		/**
			* Adjusts the height of a DOM element el from x pixels to y pixels according to
			* the function animation over a period of duration at resolution milliseconds per frame.
			* el - element you want to animate the height of
			* from - the initial height of el
			* to - the desired final height of el
			* animation - the function used to transform el closer to height *to* at each frame
			*    animation must accept the parameters
			*    x: null - doesn't do anything
			*    t: current time (frame) starts at zero 
			*    b: beginning value (eg. 200 (px))
			*    c: to - from
			*    d: duration (in frames)
			* duration - the time in milliseconds that the transformation should take
			* resolution - the number of milliseconds between each frame - defaults to 25 (40 fps)
			*    There isn't much of a point to any value below 16 as that is roughly 60 frames
			*    per second, Most monitors only draw 60 times per second.
		 */
		my.animation.animate = (function () {
			//static
			animation_inProgress = {}
			return function (args) {
				
				if (args.from === args.to) {
					return this;
				} else if (animation_inProgress[args.el.id]) {
					return false;
				}

				animation_inProgress[args.el.id] = true;
				//TODO: this could be simplified and more stringent.
				if ('string' === typeof args.animation) {
					args.animation = my.animation.ease[args.animation];
				}
				args.animation = args.animation || my.animation.ease.easeOutQuad;
				if (typeof args.animation !== 'function') {
					throw 'animation must be a function';
				}

				args.duration = args.duration || 2000;
				args.resolution = args.resolution || 25;
				// doing a no-no here by reusing a variable for a different meaning.
				args.duration = args.duration / args.resolution;

				var difference = args.to - args.from,
					t = 0,
					step,
					anim;

				t = 0;
				step = function () {
					var height = args.animation(null, t++, args.from, difference, args.duration);
					my.setElementHeight(args.el, height);
					if (t > args.duration) {
						window.clearInterval(anim);
						animation_inProgress[args.el.id] = false;
						if (args.eventelement && args.eventname) {
							my.event.fire(args.eventelement, args.eventname);
						}
					}
				};
				anim = window.setInterval(step, args.resolution);
				return this;
			};
		})();

		/**
		 * Get the background Position of a dom element in pixels as an integer.
		 * Only the Y position is converted.
		 * @param {DOMElement} [el=document.body] If not specified the element is assumed to be document.body
		 */
		my.getBGPos = function (el) {
			if (!el) {
				el = my.body;
			}

			var pixelvalueregex = /^(?:(-?\d+)px|0%)$/;
			
			/*
			 * First try background-position-y.
			 * It's a MS property which if set in IE9 does not
			 * also set the second property of background position.
			 * Making it, oddly enough, this the more reliable way of 
			 * retrieving the true value.
			 */
			var bg_position = {x: null, y: null};
			bg_position.x = my.getCompProp(el, 'background-position-x');
			bg_position.y = my.getCompProp(el, 'background-position-y');

			// Fallback to the correct way of retrieving bg position
			if (bg_position.x === '' && bg_position.y === '') {
				// Not sure if its safe to call split here w/o checking curCSS returned properly.
				var bg_position_list = my.getCompProp(el, 'background-position').split(' ', 2);
				bg_position.x = bg_position_list[0];
				bg_position.y = bg_position_list[1];
			}

			var pixelvalue = bg_position.y.match(pixelvalueregex);
			if (pixelvalue !== null) {
				bg_position.y = parseInt(pixelvalue[1], 10);
			}

			return bg_position;
		};

		my.setButtonContainersWidth = function (containers) {
			var section,
				sect,
				onld = function (domobj) {
					return function () {
						var ab_width = this.width || this.naturalWidth;
						domobj.style.width = ab_width + 'px';
					};
				};

			for (section in containers) {
				if (containers.hasOwnProperty(section)) {
					sect = containers[section];
					sect.tmp_img = document.createElement('img');
					sect.tmp_img.onload = onld(my[sect.dom]);
					sect.tmp_img.setAttribute('src', sect.bg);
				}
			}
		};

		/**
		 * Call insert when you are ready to create the sliver
		 */
		var insert = (function () {
			var toomanycalls = 0;
			return function () {
			var slivercss,
				setButtonContainersWidth,
				initial_height,
				iHTML,
				i,
				button,
				tmp_img;

			if (toomanycalls++ > 1000) {
				window.clearInterval(my.shPollVH);
			}

			// Is the Body accessible yet?
			// break out of an infinite loop if for some
			// odd reason the body is never present.
			// PS do we even need to do polling anymore?
			if (!document.getElementsByTagName('body').length || !my.body) {
				return;
			}

			iHTML = [
				'<div id="ao_wrapper"></div><div id="ao_sliver_actionbar"><div id="ao_sliver_rollover_container">'
			];

			my.sliverButtonsDOM = document.createElement('div');
			var sliverButtons = [];
			// Create buttons
			for (i = 0, button; button = spec.buttons[i]; i++) {
				var buttonhtml = '';
				var href = '';
				if (button.action === 'link' || button.action === 'dfplink') {
					href = 'href="' + button.url + '" ';
				}

				var buttonStyleAttrib = ' style="left:' + button.x_offset + 'px;top:' + button.y_offset + 'px;width:' + button.width + 'px;height:' + button.height + 'px;"';

				//consider making anchor tag when link for maximum compatibility.
				buttonhtml = '<div id="' + button.name + '_' + button.id + '" ' + href + 'class="ao_sliver_button" ' + buttonStyleAttrib + '></div>';
				if (button.area === 'actionbar') {
					iHTML.push(buttonhtml);
				} else {
					sliverButtons.push(buttonhtml);
				}
			}

			//close rollover container and ao_sliver_actionbar
			iHTML.push('</div></div>');

			// put content in ao_sliver_header
			my.sliverWrapper.style.height = '0'; //Weird quirks mode fix
			my.sliverWrapper.innerHTML = iHTML.join('');

			my.sliverDOM = document.getElementById('ao_wrapper');
			my.abDOM = document.getElementById('ao_sliver_actionbar');
			my.actionbarButtonsDOM = document.getElementById('ao_sliver_rollover_container');

			my.sliverButtonsDOM.innerHTML = sliverButtons.join('');

			my.sliverButtonsDOM.style.margin = '0 auto';
			my.sliverButtonsDOM.style.height = '100%';
			my.sliverButtonsDOM.style.position = 'relative';
			//my.sliverButtonsDOM.style.width = '1000px';

			my.sliverButtonsDOM.style.background = spec.sliver.color + ' url(' + spec.sliver.current_background + ') no-repeat 50% top';
			my.sliverDOM.style.background = spec.sliver.color;

			// Setup the initial sliver and actionbar heights
			initial_height = spec.starts_opened ? spec.sliver_height_open : spec.sliver_height_closed;
			abinitial_height = spec.starts_opened && spec.abdisappear ? spec.ab_height_closed : spec.ab_height_open;
			my.abDOM.style.height = 0; //Weird quirks mode fix
			my.sliverDOM.style.height = 0; //Weird quirks mode fix
			my.sliverWrapper.style.height = ''; //Weird quirks mode fix
			my.setElementHeight(my.abDOM,abinitial_height);
			my.setElementHeight(my.sliverDOM,initial_height);

			my.sliverDOM.appendChild(my.sliverButtonsDOM);
			if (my.videos) {
				var video = my.videos[0];
				my.videoDOMWrapper = document.createElement('div');
				my.videoDOMWrapper.innerHTML = video.embed_code;
				my.sliverButtonsDOM.appendChild(my.videoDOMWrapper);

				my.videoDOM = my.sliverButtonsDOM.getElementsByTagName('object')[0];
				var viddomstyle = my.videoDOMWrapper.style;
				viddomstyle.border = 'none';
				viddomstyle.position = 'absolute';
				viddomstyle.left = video.posX + 'px';
				viddomstyle.top = video.posY + 'px';
				my.videoDOM.style.width = video.width + 'px';
				my.videoDOM.style.height = video.height + 'px';
				my.videoDOM.style.fontSize = '0';
				my.videoDOM.width = video.width + 'px';
				my.videoDOM.height = video.height + 'px';
				my.videoDOMembed = my.videoDOM.getElementsByTagName('embed')[0];
				if (my.videoDOMembed) {
					my.videoDOMembed.width = video.width + 'px';
					my.videoDOMembed.height = video.height + 'px';
				}
				if(!window.flowplayer) {
					flowplayer = new Object();
				}

				if (flowplayer.fireEvent) {
					var oldfire = flowplayer.fireEvent
				}

				var playClip = function (i) {
					return function (e) {
						var clips = document.getElementById('sliver_playlist').getElementsByTagName('a');
						for(var j = 0; j < clips.length; j++) {
							clips[j].className = '';
						}
						this.className = 'active';
						my.getVideo(my.videoDOM.id).fp_play(i);
						return false;
					};
				}

				var first_unmute = true,
					firstLoad = true;
				flowplayer.fireEvent = function (id,action,clippos,clip) {
					var i, sb, clips, playlist, thumbnail, thumbnailDOM, width, height, ratio, link;
					if (id === 'sidh015') {
						if (firstLoad && action === 'onLoad') {
							firstLoad = false;
							sb = my.getVideo(my.videoDOM.id);
							clips = sb.fp_getPlaylist();
							if (clips.length > 1) {
								playlist = document.createElement('div');
								playlist.id = 'sliver_playlist';
								playlist.className = my.playlist.orientation;
								if (my.playlist.position === 'top' || my.playlist.position === 'left') {
									console.log(sb);
									my.videoDOMWrapper.insertBefore(playlist,my.videoDOM);
								} else {
									my.videoDOMWrapper.appendChild(playlist);
								}

								for (i = 0; i < clips.length; i++) {
									//make thumbnails
									thumbnail = clips[i]['media:thumbnail'];
									thumbnailDOM = document.createElement('img');
									thumbnailDOM.src = thumbnail['url'];
									thumbnailDOM.border = 0;

									width = thumbnail.width, height = thumbnail.height;
									ratio = width / height;

									if (ratio > 1 && width > my.thumbnails.max_width) {
										height = my.thumbnails.max_width * (1 / ratio);
										width = my.thumbnails.max_width;
									} else if (ratio <= 1 && height > my.thumbnails.max_height) {
										width = my.thumbnails.max_height * (1 / ratio);
										height = my.thumbnails.max_height;
									}
									thumbnailDOM.width = width;
									thumbnailDOM.height = height;
									link = document.createElement('a');
									link.href = '#';
									link.onclick = playClip(i);
									if (i === 0) {
										link.className = 'active';
									}

									link.appendChild(thumbnailDOM);
									playlist.appendChild(link);
									thumbnail = undefined, thumbnailDOM = undefined, link = undefined, width = undefined, height = undefined, ratio = undefined;
								}
							}

							if (video.startMuted) {
								sb.fp_mute();
							} else {
								sb.fp_unmute();
							}
							if ((spec.starts_opened || my.sliverIsOpen) && video.autoPlay) {
								sb.fp_play();
							}
							sb.fp_setVolume(video.volume);
						} else if (action === 'onMouseOver') {
							if (first_unmute && video.startMuted && video.unmuteOnRollover) {
								var vid = my.getVideo(my.videoDOM.id);
								vid.fp_unmute();
								first_unmute = false;
							}
						}
					} else {
						oldfire(id,action);
					}
				}
			}

			// Fire an event that says the sliver has been inserted
			my.event.fire(my.sliverWrapper, 'sliverready');

			// attaching onclick/rollover actions for buttons
			for (i = 0, button = undefined; button = spec.buttons[i]; i++) {
				var dom_button = document.getElementById(button.name + '_' + button.id);
				dom_button[my.events[button.on]] = my.actions[button.action];
			}

			//stop polling
			//Do we still need polling if we don't load until the DOM is ready? Was that the purpose of polling?
			window.clearInterval(my.shPollVH);
			
			//If auto expand is set, and autoclose is true, the sliver will close after X seconds.
			if( spec.autoOpen && spec.autoClose>0 ) {
				setTimeout(my.actions['closesliver'],spec.autoClose);
			}
		
		};
		})();

		my.insert = insert;
		
		
// Cross-browser video get function supplied by springboard 
// I'm not a fan that it uses browser detection rather than feature detection
		my.getVideo = function (id) {
			if (document[id]) {
				return document[id];
			} else if (window[id]) {
				if(window[id].item) {
					return window[id].item();
				}
				return window[id];
			}
		};

		my.isReady = false;
		var init = function () {
			this.prepReadyEvent = function () {
				my.ready = function () {
					if (my.isReady === true) {
						return;
					}
					my.isReady = true;
					
					if (!my.shPollVH) {
						my.shPollVH = window.setInterval(my.insert, 1);
					}
				};

				var doScrollCheck = function () {
					if ( my.isReady ) {
						return;
					}

					try {
						// If IE is used, use the trick by Diego Perini
						// http://javascript.nwbox.com/IEContentLoaded/
						document.documentElement.doScroll("left");
					} catch (e) {
						setTimeout(doScrollCheck, 1);
						return;
					}

					// and execute any waiting functions
					my.ready();
				};

				if (document.addEventListener) {
					my.DOMContentLoaded = function () {
						document.removeEventListener("DOMContentLoaded", my.DOMContentLoaded, false);
						my.ready();
					};

				} else if (document.attachEvent) {
					my.DOMContentLoaded = function () {
						// Make sure body exists, at least, in case IE gets a little overzealous (ticket #5443).
						if (document.readyState === "complete") {
							document.detachEvent("onreadystatechange", my.DOMContentLoaded);
							my.ready();
						}
					};
				}

				if (document.addEventListener) {
					// Use the handy event callback
					document.addEventListener("DOMContentLoaded", my.DOMContentLoaded, false);

					// A fallback to window.onload, that will always work
					window.addEventListener("load", my.ready, false);

				// If IE event model is used
				} else if (document.attachEvent) {
					// ensure firing before onload,
					// maybe late but safe also for iframes
					document.attachEvent("onreadystatechange", my.DOMContentLoaded);

					// A fallback to window.onload, that will always work
					window.attachEvent("onload", my.ready);

					// If IE and not a frame
					// continually check to see if the document is ready
					var toplevel = false;

					try {
						toplevel = window.frameElement === null;
					} catch (e) {}

					if (document.documentElement.doScroll && toplevel) {
						doScrollCheck();
					}
				}

				return this;
			};

			this.insertCSS = function () {
				// Returns a style tag for the sliver
				slivercss = function (params) {
					var aoCSS = [
						'#ao_sliver_header {',
						'overflow:hidden;',
						'position:relative;',
						'width:100%;',
						'padding:0;',
						'}',
						'#ao_sliver_header a {',
						'border: 0;',
						'}',

						'#ao_sliver_header a {',
						'text-decoration:none;',
						'margin:0;',
						'border:0;',
						'}',

						'#ao_wrapper {',
						'position: relative;',
						'overflow: hidden;',
						'background: white;',
						'text-align: center;',
						'}',
						'#ao_wrapper > div {',
						'margin: 0 auto;',
						'}',
						'#ao_sliver_header a img {',
						'vertical-align:text-bottom;',
						'}',

						'#ao_sliver_actionbar {',
						'background: ' + params.actionbar_color + ';',
						'width:100%;',
						'left:0px;',
						'z-index: 20000;',
						'text-align: center;',
						'}',
						'.ao_sliver_button {',
						'}',

						'#ao_sliver_header .ao_sliver_button{ position: absolute; cursor: pointer; }',
						'#ao_sliver_rollover_container { width: 1000px; margin: 0 auto; position: relative;height: 100%;',
						'background: ' + params.actionbar_color + ' url(' + params.currentActionbarURL + ') no-repeat center top;',
						'}',

						'#sliver_playlist a {',
						'opacity: 0.6;',
						'-moz-transition: all 0.5s ease;',
						'-webkit-transition: all 0.5s ease;',
						'transition-property: all 0.5s ease;',
						'border: 1px solid transparent;',
						'font-size: 0;',
						'}',
						'#sliver_playlist.vertical {',
						'display: inline-block;',
						'vertical-align: bottom;',
						'margin: 0 5px;',
						'zoom:1;',
						'*display: inline;',
						'}',
						'#sliver_playlist.vertical a {',
						'display: block;',
						'margin: 4px 0;',
						'}',
						'#sliver_playlist.horizontal a {',
						'display: inline-block;',
						'margin: 0 4px;',
						'}',
						'#sliver_playlist.horizontal {',
						'display: block;',
						'margin: 5px 0;',
						'}'
					];
					//add a class for ab disappear ... shouldn't have conditional css.

					if (params.abdisappear) {
						aoCSS.push('#ao_wrapper { z-index: 100; overflow: hidden;}',
							'#ao_sliver_actionbar { z-index: 99; }');
					}

					aoCSS.push('#sliver_playlist a.active, #sliver_playlist a:hover {',
						'opacity: 1;',
						'border: 1px solid ' + params.thumb.activeColor + ';',
						'box-shadow: ' + params.thumb.shadowOffsetX + 'px ' + params.thumb.shadowOffsetY + 'px ' + params.thumb.shadowBlurRadius + 'px ' + params.thumb.shadowSpreadRadius + 'px ' + params.thumb.shadowColor + ';');

					return aoCSS.join('');
				};

				// Insert css
				var csstag = document.createElement('style');
				csstag.setAttribute('type','text/css');
				thumbProps = { shadowOffsetX: spec.sliver.playlist.thumb.shadow.offsetX,
					shadowOffsetY: spec.sliver.playlist.thumb.shadow.offsetY,
					shadowBlurRadius: spec.sliver.playlist.thumb.shadow.blurRadius,
					shadowSpreadRadius: spec.sliver.playlist.thumb.shadow.spreadRadius,
					shadowColor: spec.sliver.playlist.thumb.shadow.color,
					activeColor: spec.sliver.playlist.thumb.activeOutlineColor
				};
				var cssText = slivercss({'currentActionbarURL': spec.actionbar.current_background,
					'actionbar_color': spec.actionbar.color,
					'abdisappear': spec.abdisappear,
					'thumb': thumbProps
					});
				try {
					var tn = document.createTextNode(cssText);
					csstag.appendChild(tn);
				} catch (e) {
					csstag.styleSheet.cssText = cssText;
				}
				document.getElementsByTagName('head')[0].appendChild(csstag);
				return this;
			}


			this.setupTracking = function (id,tracking,disabled) {
				if (disabled) {
					my.tracking = { category:undefined,trackEvent:function(){}};
					return this;
				}
				var trackingObjectName = tracking.prefix + id;
				var trackingObject = trackingObjectName + '.';
				_gaq.push([trackingObject + '_setAccount', tracking.account]);
				_gaq.push([trackingObject + '_setDomainName', 'none']);
				_gaq.push([trackingObject + '_setAllowLinker', true]);
				_gaq.push([trackingObject + '_trackPageview']);

				my.tracking = {
					category: tracking.prefix,
					trackEvent: function (action, label, value, category) {
						category = category || my.tracking.category;
						var event = [trackingObjectName + '._trackEvent', category, action];
						if (value !== undefined && (label === undefined || label === null)) {
							event.push(undefined);
							event.push(value);
						} else if (value !== undefined && label !== undefined) {
							event.push(label);
							event.push(value);
						} else if (value === undefined && label !== undefined) {
							event.push(label);
						}
						_gaq.push(event);
					}
				};
				return this;
			};

			// Grab images and the like early so they are ready when needed
			this.prefetchResources = function () {
				var actionbar = document.createElement('img'),
					sliver = document.createElement('img');

				actionbar.setAttribute('src', spec.actionbar.current_background);
				sliver.setAttribute('src', spec.sliver.current_background);
				return this;
			};

			/**
				* Simplify const calculated values from the config
			 */
			this.interpretConfig = function (spec) {
				//TODO seriously sliver_open is a bad name. its set to 1 if the sliver should be closed...yeah.
				spec.showHeader = my.storage.read('sliver_open_'+config.id) !== "1";
				//set a freq cap if not set
				if (spec.showHeader && my.storage.read('sliver_open_'+config.id) !== "0") {
					my.storage.store('sliver_open_'+config.id, 1, 1);
				}
				// If the sliver left previously open or this is the first visit
				spec.starts_opened = spec.showHeader && spec.autoOpen;
				spec.sliver_height_open = spec.sliver.height;
				spec.ab_height_open = spec.actionbar.height;

				spec.ab_height_closed = 0;
				spec.sliver_height_closed = 0;

				my.playlist = {};
				my.playlist.position = spec.sliver.playlist.position;
				if (my.playlist.position === 'left' || my.playlist.position === 'right') {
					my.playlist.orientation = 'vertical';
				} else {
					my.playlist.orientation = 'horizontal';
				}

				my.thumbnails = {};
				my.thumbnails.max_width = spec.sliver.playlist.thumb.maxWidth;
				my.thumbnails.max_height = spec.sliver.playlist.thumb.maxHeight;

				var curDate;
				var getCurBg = function (images) {
					var i, img, curbg;
					for (i = 0; i < images.length; i++) {
						img = images[i];
						if (img.date !== "") {
							var now = new Date();
							var relDate = new Date(img.date);
							if (!curDate) {
								curDate = relDate;
							}

							if (now > relDate && curDate <= relDate) {
								curDate = new Date(relDate);
								curbg = img.src;
							}
						}
					}
					return curbg;
				};
				spec.sliver.current_background = getCurBg(spec.sliver.backgrounds);
				spec.actionbar.current_background = getCurBg(spec.actionbar.image);
				
				//This needs to be called after body ready
				my.body = document.getElementsByTagName('body')[0];
				//This needs to be called after sliver is inserted
				my.sliverWrapper = document.getElementById('ao_sliver_header');

				// This way none of the internal functions have to deal with a dfp link differently than a regular link.
				var i, button;
				for (i = 0; button = spec.buttons[i]; i++) {
					if (button.action === 'dfplink') {
						button.url = spec.urls.target;
					}
				}

				var video,
					now = new Date(),
					curDateStr;
				curDate = null;
				my.videos = {};
				for (i = 0; video = spec.videos[i]; i++) {
					if (!my.videos[video.date]) {
						my.videos[video.date] = [];
					}
					my.videos[video.date].push(video);
					if (video.date !== "") {
						var relDate = new Date(video.date);
						if (!curDate) {
							curDate = relDate;
						}

						if (now > relDate && curDate <= relDate) {
							curDate = new Date(video.date);
							curDateStr = video.date;
						}
					}
				}
				my.videos = my.videos[curDateStr];

				my.sliverIsOpen = spec.starts_opened;

				return this;
			};

			this.bindEvents = function(spec) {
				var containers = function () {
					// Guess the width of the action bar based on its image
					var containers = {
						'sliver': {'dom': 'sliverButtonsDOM', 'bg': spec.sliver.current_background},
						'actionbar': {'dom': 'actionbarButtonsDOM','bg': spec.actionbar.current_background}
					};
					my.setButtonContainersWidth(containers);
				};
				my.event.bind(my.sliverWrapper,'sliverready', containers);

				my.event.bind(my.sliverWrapper,'sliverready',function () { my.tracking.trackEvent('sliverloaded'); });

				my.event.bind(my.sliverWrapper,'sliveropen',function (e) {
					if (my.videos[0].autoPlay && !spec.starts_opened) {
						try {my.getVideo(my.videoDOM.id).fp_play();} catch (e){}
					}
				});

				my.event.bind(my.sliverWrapper,'sliverclose',function (e) {
					my.getVideo(my.videoDOM.id).fp_pause();
				});

				return this;
			};


			this.interpretConfig(spec).prepReadyEvent().prefetchResources().setupTracking(spec.id, spec.tracking,spec.disableAnalyitics).bindEvents(spec).insertCSS();
		};

		var clickout = function (e) {
			if (!e) {
				var e = window.event;
			}
			var target = e.target || e.srcElement;
			var win = window.open(target.getAttribute('href'), '_blank');
			win.focus();
			my.tracking.trackEvent('clickout', target.id);
		};
		
		//Action map right now used by buttons to specify an action that should be taken when a button is "pressed"
		my.actions = {
			opensliver: function (e) {
				var target, baranimation, animation;
				if (!e) {
					var e = window.event;
				}
				if (my.sliverIsOpen) {
					return;
				}
				animation = my.animation.animate({el: my.sliverDOM,
					from: my.dePixel(my.getCompProp(my.sliverDOM, 'height')),
					to: spec.sliver_height_open,
					animation: spec.sliver.openAnimation,
					duration: spec.sliver.openAnimationDuration,
					resolution: spec.animationResolution,
					eventelement: my.sliverWrapper,
					eventname: 'sliveropened'});
				if (spec.abdisappear && animation) {
					baranimation = my.animation.animate({el: my.abDOM,
						from: my.dePixel(my.getCompProp(my.abDOM, 'height')),
						to: spec.ab_height_closed,
						animation: spec.actionbar.closeAnimation,
						duration: spec.actionbar.closeAnimationDuration,
						resolution: spec.animationResolution,
						eventelement: my.sliverWrapper,
						eventname: 'sliverabclosed'});
				}
				if (animation !== false) {
					my.storage.store('sliver_open_'+config.id, 0,1);
					my.sliverIsOpen = true;
					my.event.fire(my.sliverWrapper, 'sliveropen');
					//TODO: move tracking into sliveropen event handler
					target = e.target || e.srcElement;
					my.tracking.trackEvent('opensliver', target.id);
				}
			},
			closesliver: function (e) {
				var target, animation;
				if (!e) {
					var e = window.event;
				}
				if (!my.sliverIsOpen) {
					return;
				}
					animation = my.animation.animate({el: my.sliverDOM,
						from: my.dePixel(my.getCompProp(my.sliverDOM, 'height')),
						to: spec.sliver_height_closed,
						animation: spec.sliver.closeAnimation,
						duration: spec.sliver.closeAnimationDuration,
						resolution: spec.animationResolution,
						eventelement: my.sliverWrapper,
						eventname: 'sliverclosed'});
				if (spec.abdisappear && animation) {
					var iesucks = function () {
						my.animation.animate({el: my.abDOM,
							from: my.dePixel(my.getCompProp(my.abDOM, 'height')),
							to: spec.ab_height_open,
							animation: spec.actionbar.openAnimation,
							duration: spec.actionbar.openAnimationDuration,
							resolution: spec.animationResolution,
							eventelement: my.sliverWrapper,
							eventname: 'sliverabopened'});
					}
					window.setTimeout(iesucks, spec.actionbar.openDelay);
				}
				if (animation !== false) {
					my.storage.store('sliver_open_'+config.id, 1,1);
					my.sliverIsOpen = false;
					my.event.fire(my.sliverWrapper, 'sliverclose');
					//TODO: move tracking into sliver close event handler
					if( e=='[object MouseEvent]' ) {
						target = e.target || e.srcElement;
						my.tracking.trackEvent('closesliver', target.id);
					}
				}
			},
			link: clickout,
			dfplink: clickout
		};	

		my.events = {
			'rollover': 'onmouseover',
			'click': 'onclick'
		};
		
	/*
	 *
	 * TERMS OF USE - EASING EQUATIONS
	 *
	 * Open source under the BSD License. 
	 *
	 * Copyright © 2001 Robert Penner
	 * All rights reserved.
	 *
	 * Redistribution and use in source and binary forms, with or without modification, 
	 * are permitted provided that the following conditions are met:
	 *
	 * Redistributions of source code must retain the above copyright notice, this list of 
	 * conditions and the following disclaimer.
	 * Redistributions in binary form must reproduce the above copyright notice, this list 
	 * of conditions and the following disclaimer in the documentation and/or other materials 
	 * provided with the distribution.
	 *
	 * Neither the name of the author nor the names of contributors may be used to endorse 
	 * or promote products derived from this software without specific prior written permission.
	 *
	 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
	 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
	 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
	 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
	 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
	 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
	 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
	 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
	 * OF THE POSSIBILITY OF SUCH DAMAGE. 
	 *
	 */
	// t: current time, b: beginning value, c: change In value (end - begin), d: duration
		my.animation.ease = {
			def: 'easeOutQuad',
			swing: function (x, t, b, c, d) {
				return my.animation.ease.easeOutQuad(x, t, b, c, d);
			},
			easeInQuad: function (x, t, b, c, d) {
				return c*(t/=d)*t + b;
			},
			easeOutQuad: function (x, t, b, c, d) {
				return -c *(t/=d)*(t-2) + b;
			},
			easeInOutQuad: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) return c/2*t*t + b;
				return -c/2 * ((--t)*(t-2) - 1) + b;
			},
			easeInCubic: function (x, t, b, c, d) {
				return c*(t/=d)*t*t + b;
			},
			easeOutCubic: function (x, t, b, c, d) {
				return c*((t=t/d-1)*t*t + 1) + b;
			},
			easeInOutCubic: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) return c/2*t*t*t + b;
				return c/2*((t-=2)*t*t + 2) + b;
			},
			easeInQuart: function (x, t, b, c, d) {
				return c*(t/=d)*t*t*t + b;
			},
			easeOutQuart: function (x, t, b, c, d) {
				return -c * ((t=t/d-1)*t*t*t - 1) + b;
			},
			easeInOutQuart: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
				return -c/2 * ((t-=2)*t*t*t - 2) + b;
			},
			easeInQuint: function (x, t, b, c, d) {
				return c*(t/=d)*t*t*t*t + b;
			},
			easeOutQuint: function (x, t, b, c, d) {
				return c*((t=t/d-1)*t*t*t*t + 1) + b;
			},
			easeInOutQuint: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
				return c/2*((t-=2)*t*t*t*t + 2) + b;
			},
			easeInSine: function (x, t, b, c, d) {
				return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
			},
			easeOutSine: function (x, t, b, c, d) {
				return c * Math.sin(t/d * (Math.PI/2)) + b;
			},
			easeInOutSine: function (x, t, b, c, d) {
				return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
			},
			easeInExpo: function (x, t, b, c, d) {
				return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
			},
			easeOutExpo: function (x, t, b, c, d) {
				return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
			},
			easeInOutExpo: function (x, t, b, c, d) {
				if (t==0) return b;
				if (t==d) return b+c;
				if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
				return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
			},
			easeInCirc: function (x, t, b, c, d) {
				return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
			},
			easeOutCirc: function (x, t, b, c, d) {
				return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
			},
			easeInOutCirc: function (x, t, b, c, d) {
				if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
				return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
			},
			easeInElastic: function (x, t, b, c, d) {
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
			},
			easeOutElastic: function (x, t, b, c, d) {
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
			},
			easeInOutElastic: function (x, t, b, c, d) {
				var s=1.70158;var p=0;var a=c;
				if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
				if (a < Math.abs(c)) { a=c; var s=p/4; }
				else var s = p/(2*Math.PI) * Math.asin (c/a);
				if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
				return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
			},
			easeInBack: function (x, t, b, c, d, s) {
				if (s == undefined) s = 1.70158;
				return c*(t/=d)*t*((s+1)*t - s) + b;
			},
			easeOutBack: function (x, t, b, c, d, s) {
				if (s == undefined) s = 1.70158;
				return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
			},
			easeInOutBack: function (x, t, b, c, d, s) {
				if (s == undefined) s = 1.70158; 
				if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
				return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
			},
			easeInBounce: function (x, t, b, c, d) {
				return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
			},
			easeOutBounce: function (x, t, b, c, d) {
				if ((t/=d) < (1/2.75)) {
					return c*(7.5625*t*t) + b;
				} else if (t < (2/2.75)) {
					return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
				} else if (t < (2.5/2.75)) {
					return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
				} else {
					return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
				}
			},
			easeInOutBounce: function (x, t, b, c, d) {
				if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
				return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
			}
		};

		return {init: init};
	};
})(window.top, window.top.document);

// Closure for protecting sliver config and instance
// Consider this the MAIN function
(function(){

	// PHP writes out the CMS configuration values here
	// PHP shouldn't really be touching any other part of the file
	<?php
		// I hate typing out echo htmlspecialchars for each variable...
		function h($content) {
			echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
		}
	?>
	var config = {
		id: <?php echo $this->sliver->id; ?>,
		tweenBG: <?php echo $this->sliver->tweenBG ? 'true': 'false'; ?>,
		abdisappear: <?php echo $this->sliver->abdisappear ? 'true': 'false';?>,
		prefix: "<?php h($this->sliver->prefix); ?>",
		autoOpen: <?php echo $this->sliver->autoOpen? 'true': 'false'; ?>,
		autoClose: <?php echo $this->sliver->autoClose; ?>,
		flowplayerscript: "<?php h($this->flowplayerscript); ?>",
		flowplayerflash: "<?php h($this->flowplayerflash); ?>",
		animationResolution: <?php echo $this->sliver->animation_resolution; ?>,
		disableAnalyitics: <?php echo $this->da ? 'true' : 'false'; ?>,
		urls: {
			target: '<?php h($this->ct); ?>'
		},
		tracking: {
			account: 'UA-12310597-73',
			prefix: "<?php h($this->sliver->prefix); ?>"
		},
		buttons: [<?php
			$first = true;
			foreach ($this->buttons as $button){
				if (!$first) echo ',';
				else $first = false;
				?>{
					name: "<?php h($button->name); ?>",
					id: "<?php h($button->id); ?>",
					area: "<?php h($button->area); ?>",
					action: "<?php h($button->action); ?>",
					on: "<?php h($button->on); ?>",
					url: "<?php h($button->url); ?>",
					x_offset: "<?php h($button->x_offset); ?>",
					y_offset: "<?php h($button->y_offset); ?>",
					width: "<?php h($button->width); ?>",
					height: "<?php h($button->height); ?>"
				}<?php
			} ?>],
		sliver: {
			height: <?php echo $this->sliver->sliver_height; ?>,
			color: "<?php echo $this->sliver->sliver_color; ?>",
			openAnimation: "<?php echo $this->sliver->sliv_open_animation; ?>",
			closeAnimation: "<?php echo $this->sliver->sliv_close_animation; ?>",
			openAnimationDuration: <?php echo $this->sliver->sliv_open_duration; ?>,
			closeAnimationDuration: <?php echo $this->sliver->sliv_close_duration; ?>,
			playlist: {
				position: "<?php echo $this->sliver->playlist_position; ?>",
				thumb: {
					maxHeight: <?php echo $this->sliver->playlist_thumb_max_height; ?>,
					maxWidth: <?php echo $this->sliver->playlist_thumb_max_width; ?>,
					activeOutlineColor: '<?php echo $this->sliver->playlist_thumb_active_outline_color; ?>',
					shadow: {
						offsetX: <?php echo $this->sliver->playlist_thumb_shadow_offset_x; ?>,
						offsetY: <?php echo $this->sliver->playlist_thumb_shadow_offset_y; ?>,
						blurRadius: <?php echo $this->sliver->playlist_thumb_shadow_blur_radius; ?>,
						spreadRadius: <?php echo $this->sliver->playlist_thumb_shadow_spread_radius; ?>,
						color: '<?php echo $this->sliver->playlist_thumb_shadow_color; ?>'
					}
				}
			},
			backgrounds: [<?php
				$first = true;
				foreach ($this->backgrounds as $background) {
					if(!$first) echo ',';
					else $first=false;
					?>{
						date: "<?php h($background->starts); ?>",
						src: "<?php h($background->flash_uri); ?>",
						height: <?php h($background->flash_height); ?>,
						width: <?php h($background->flash_width); ?>,
						action: "ao_headerClick"
					}
				<?php } ?>
			]
		},
		actionbar: {
			height: <?php echo $this->sliver->actionbar_height; ?>,
			color: "<?php echo $this->sliver->actionbar_color; ?>",
			openDelay: "<?php echo $this->sliver->ab_open_delay ?>",
			openAnimation: "<?php echo $this->sliver->ab_open_animation ?>",
			closeAnimation: "<?php echo $this->sliver->ab_close_animation ?>",
			openAnimationDuration: "<?php echo $this->sliver->ab_open_duration ?>",
			closeAnimationDuration: "<?php echo $this->sliver->ab_close_duration ?>",
			image: [<?php
				$first = true; 
				foreach ($this->backgrounds as $image){
					if(!$first) echo ',';
					else $first=false; ?>
					{
						date: "<?php echo $image->starts;?>",
						src: "<?php echo $image->actionbar_uri;?>"
					}<?php
				} ?>
			]
		},
		videos: [<?php
		$first = true;
		foreach ($this->videos as $video) {
			if(!$first) echo ',';
			else $first = false;
			?>{date: "<?php h($video->starts); ?>",
				height: <?php h($video->height); ?>,
				width: <?php h($video->width); ?>,
				autoPlay: <?php echo $video->autoPlay? 'true': 'false'; ?>,
				autoPlayOn: "<?php h($video->autoPlayOn); ?>",
				startMuted: <?php echo $video->startMuted ? 'true': 'false'; ?>,
				unmuteOnRollover: <?php echo $video->unmuteOnRollover? 'true': 'false'; ?>,
				volume: <?php h($video->volume); ?>,
				posX: <?php h($video->posX); ?>,
				posY: <?php h($video->posY); ?>,
				embed_code: <?php echo json_encode($video->embed_code);
			?>}<?php
		} ?>]
	};

	var aSliver = ao_sliver(config);
	aSliver.init();
})();
/*jslint devel: true, browser: true, sloppy: true, vars: true, plusplus: true, maxerr: 800, indent: 4 */
/*global ActiveXObject: false */
