/*
    Qatrix JavaScript v0.9.4

    Copyright (c) 2012, The Qatrix project, Angel Lai
    The Qatrix project is under MIT license.
    For details, see the Qatrix website: http:// qatrix.com
*/

(function(){var h={version:'0.9.4',rbline:/\n+/g,rbrace:/^(?:\{.*\}|\[.*\])$/,rcamelCase:/-([a-z])/ig,rdigit:/\d/,rline:/\r\n/g,rnum:/[0-9\.]/ig,rspace:/\s+/,rtrim:/(^\s*)|(\s*$)/g,rvalidchars:/^[\],:{}\s]*$/,rvalidescape:/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,rvalidtokens:/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,rvalidbraces:/(?:^|:|,)(?:\s*\[)+/g,nodeManip:function(a,b){var c=typeof b;if(c==='string'){var d=a&&a.ownerDocument||document,fragment=d.createDocumentFragment(),div=document.createElement('div'),ret=[];div.innerHTML=b;while(div.childNodes[0]!=null){fragment.appendChild(div.childNodes[0])}b=fragment;div=null}if(c==='number'){b+=''}return b},$:function(a){return document.getElementById(a)},$each:function(a,b){var i=0,length=a.length,name;if(length){for(;i<length;i++){b.call(a[i],i,a[i])}}else{for(name in a){b.call(a[name],name,a[name])}}},$id:function(b,c){var d=[],elem;if(typeof b==='string'){elem=$(b);if(elem!=null&&c){c(elem)}return elem}$each(b,function(i,a){elem=$(a);if(elem!=null){d.push(elem)}});if(c&&d.length>0){$each(d,function(i,a){c(a)})}return d},$dom:function(b,c){if(c){b.length?$each(b,function(i,a){c(a)}):c(item)}return b},$tag:function(b,c,d){var e=b.getElementsByTagName(c);if(d&&e.length>0){$each(e,function(i,a){d(a)})}return e},$class:document.getElementsByClassName?function(b,c,d){var e=b.getElementsByClassName(c);if(d&&e.length>0){$each(e,function(i,a){d(a)})}return e}:function(b,c,d){var e=[],rclass=new RegExp('\\b'+c+'\\b');$tag(b,'*',function(a){if(rclass.test(a.className)){e.push(a)}});if(d&&e.length>0){$each(e,function(i,a){d(a)})}return e},$select:document.querySelectorAll?function(b,c){var d=document.querySelectorAll(b);if(c&&d.length>0){$each(d,function(i,a){c(a)})}return d}:function(b,c){var d=h.Qselector.styleSheet,match=[];d.addRule(b,'q:a');$tag(document,'*',function(a){if(a.currentStyle.q==='a'){match.push(a)}});d.cssText='';if(c&&match.length>0){$each(match,function(i,a){c(a)})}return match},$new:function(c,d){var f=document.createElement(c);if(d){try{$each(d,function(a,b){switch(a){case'css':case'style':$css.set(f,b);break;case'innerHTML':case'html':$html(f,b);break;case'className':case'class':$className.set(f,b);break;case'text':$text(f,b);break;default:$attr.set(f,a,b);break}});return f}catch(e){}finally{f=null}}return f},$string:{camelCase:function(c){return c.replace('-ms-','ms-').replace(h.rcamelCase,function(a,b){return(b+'').toUpperCase()})},replace:function(a,b){for(var c in b){a=a.replace(new RegExp(c,'ig'),b[c])}return a},slashes:function(a){return $string.replace(a,{"\\\\":'\\\\',"\b":'\\b',"\t":'\\t',"\n":'\\n',"\r":'\\r','"':'\\"'})},trim:String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(h.rtrim,'')}},$attr:{get:function(a,b){return a.getAttribute(b)},set:function(a,b,c){return a.setAttribute(b,c)},remove:function(a,b){return a.removeAttribute(b)}},$data:{get:function(a,b){var c=$attr.get(a,'data-'+b);return c==="true"?true:c==="false"?false:c==="null"?'':c===null?'':c===''?'':!isNaN(parseFloat(c))&&isFinite(c)?+c:h.rbrace.test(c)?$json.decode(c):c},set:function(c,d,e){typeof d==='object'?$each(d,function(a,b){$attr.set(c,'data-'+a,b)}):$attr.set(c,'data-'+d,e);return c},remove:function(a,b){return $attr.remove(a,'data-'+b)}},$cache:{data:{},get:function(a){var b=$cache.data[a];return b||typeof b==='number'?b:null},set:function(a,b){$cache.data[a]=b;return b},inc:function(a){var b=$cache.data[a];return typeof b==='number'?$cache.data[a]++:b},dec:function(a){var b=$cache.data[a];return typeof b==='number'?$cache.data[a]--:b},remove:function(a){delete $cache.data[a];return true},flush:function(){$cache.data={};return true}},$storage:{set:window.localStorage?function(a,b){localStorage[a]=typeof b==='object'?$json.encode(b):b}:function(a,b){var b=typeof b==='object'?$json.encode(b):b;$data.set(h.storage,a,b);h.storage.save('Qstorage')},get:window.localStorage?function(a){var b=localStorage[a];if($json.isJSON(b)){return $json.decode(b)}return b||''}:function(a){h.storage.load('Qstorage');return $data.get(h.storage,a)||''},remove:window.localStorage?function(a){localStorage.removeItem(a);return true}:function(a){h.storage.load('Qstorage');$data.remove(h.storage,a);return true}},$event:{add:function(a,b,c){if(a.nodeType===3||a.nodeType===8||!b||!c){return false}if(a.addEventListener){if(b==='mouseenter'||b==='mouseleave'){b=b==='mouseenter'?'mouseover':'mouseout';c=$event.handler.mouseenter(c)}a.addEventListener(b,c,false)}else{if(a.getAttribute){var d=c.toString();if($data.get(a,'event-'+b+'-'+d)){return false}$data.set(a,'event-'+b+'-'+d,true)}a.attachEvent('on'+b,c)}return a},remove:document.removeEventListener?function(a,b,c){a.removeEventListener(b,c,false);return a}:function(a,b,c){a.detachEvent('on'+b,c);if(a.removeAttribute){$attr.remove(a,'event-'+b+'-'+c.toString())}return a},handler:{mouseenter:function(e){return function(c){function is_child(a,b){if(a===b){return false}while(b&&b!==a){b=b.parentNode}return b===a}var d=c.relatedTarget;if(this===d||is_child(this,d)){return}e.call(this,c)}}},key:function(a){return a.which||a.charCode||a.keyCode},metaKey:function(a){return!a.metaKey&&a.ctrlKey?a.ctrlKey:a.metaKey},target:function(a){return a.target?a.target:a.srcElement||document}},$clear:function(a){if(a){clearTimeout(a);clearInterval(a)}return null},$ready:function(a){if(document.readyState==='complete'){return setTimeout(a,1)}if(document.addEventListener){document.addEventListener('DOMContentLoaded',a,false);return}function domready(){try{document.documentElement.doScroll('left')}catch(e){setTimeout(domready,1);return}a()}domready()},$css:{get:function(a,b){return $style.get(a,b)},set:function(c,d,e){typeof d==='object'?$each(d,function(a,b){$style.set(c,$string.camelCase(a),$css.fix(a,b))}):$style.set(c,$string.camelCase(d),$css.fix(d,e));return c},number:{'fontWeight':true,'lineHeight':true,'opacity':true,"zIndex":true},unit:function(a,b){if($css.number[a]){return''}var c=b.toString().replace(h.rnum,'');return c===''?'px':c},fix:function(a,b){if(typeof b==='number'&&!$css.number[a]){b+='px'}return b==null&&isNaN(b)?false:b}},$style:{get:window.getComputedStyle?function(a,b){if(a!==null){return document.defaultView.getComputedStyle(a,null).getPropertyValue(b)}return false}:function(a,b){if(a!==null){if(b==='width'&&a.currentStyle['width']==='auto'){return a.offsetWidth}if(b==='height'&&a.currentStyle['height']==='auto'){return a.offsetHeight}return a.currentStyle[$string.camelCase(b)]}return false},set:document.documentElement.style.opacity===''?function(a,b,c){a.style[b]=c;return true}:function(a,b,c){if(!a.currentStyle||!a.currentStyle.hasLayout){a.style.zoom=1}if(b==='opacity'){a.style.filter='alpha(opacity='+c*100+')'}else{a.style[b]=c}return true}},$pos:function(a,x,y){$style.set(a,'left',x+'px');$style.set(a,'top',y+'px');return a},$offset:function(a){var b=document.body,doc_elem=document.documentElement,box=a.getBoundingClientRect();return{top:box.top+(window.scrollY||a.scrollTop)-(doc_elem.clientTop||b.clientTop||0),left:box.left+(window.scrollX||a.scrollLeft)-(doc_elem.clientLeft||b.clientLeft||0)}},$append:function(a,b){return a.appendChild(h.nodeManip(a,b))},$prepend:function(a,b){return a.firstChild?a.insertBefore(h.nodeManip(a,b),a.firstChild):a.appendChild(h.nodeManip(a,b))},$before:function(a,b){return a.parentNode.insertBefore(h.nodeManip(a,b),a)},$after:function(a,b){return a.nextSibling?a.parentNode.insertBefore(h.nodeManip(a,b),a.nextSibling):a.parentNode.appendChild(h.nodeManip(a,b))},$remove:function(a){return a!=null&&a.parentNode?a.parentNode.removeChild(a):a},$empty:function(a){a.innerHTML='';return a},$html:function(a,b){if(!b){return a.nodeType===1?a.innerHTML:null}try{a.innerHTML=b}catch(e){$append($empty(a),b)}return a},$text:function(a,b){if(!b){var c='',textContent=(a.textContent),nodeType,block,preblock;for(a=a.firstChild;a;a=a.nextSibling){nodeType=a.nodeType;if(nodeType===3&&$string.trim(a.nodeValue)!=''){c+=a.nodeValue.replace(h.rbline,'')+"\n";preblock=true}if(nodeType===1||nodeType===2){block=$style.get(a,'display')==='block';if(block&&!preblock){c+="\n"}c+=textContent?$string.trim(a.textContent.replace(h.rbline,'')):a.innerText.replace(h.rline,'');c+=block?"\n":'';preblock=block}}return c}$empty(a);a.appendChild(document.createTextNode(b));return a},$className:{add:function(b,c){if(b.className===''){b.className=c}else{var d=b.className,nclass=[];$each(c.split(h.rspace),function(i,a){if(!new RegExp('\\b('+a+')\\b').test(d)){nclass.push(' '+a)}});b.className+=nclass.join('')}return b},set:function(a,b){a.className=b;return a},has:function(a,b){return new RegExp('\\b('+b.split(h.rspace).join('|')+')\\b').test(a.className)},remove:function(a,b){a.className=b?$string.trim(a.className.replace(new RegExp('\\b('+b.split(h.rspace).join('|')+')\\b','g'),'').split(h.rspace).join(' ')):'';return a}},$hide:function(c){$each(arguments,function(i,b){typeof b==='string'?$(b).style.display='none':typeof b==='object'&&b.length?$each(b,function(i,a){a.style.display='none'}):b.style.display='none'})},$show:function(c){$each(arguments,function(i,b){typeof b==='string'?$(b).style.display='block':typeof b==='object'&&b.length?$each(b,function(i,a){a.style.display='block'}):b.style.display='block'})},$animate:(function(){var a=document.documentElement.style;return(a.webkitTransition===''||a.MozTransition===''||a.OTransition===''||a.MsTransition===''||a.transition==='')}())?(function(){var g=document.documentElement.style,prefix_name=g.webkitTransition===''?'Webkit':g.MozTransition===''?'Moz':g.OTransition===''?'O':g.MsTransition===''?'ms':'',transition_name=prefix_name+'Transition',transform_name=prefix_name+'Transform';return function(b,c,d,e){var f=[],css_name=[],unit=[],css_style=[],g=b.style,css,offset;d=d||'300';for(css in c){css_name[css]=$string.camelCase(css);if(c[css].from!=null){f[css]=!$css.number[css]?parseInt(c[css].to):c[css].to;unit[css]=$css.unit(css,c[css].to);$style.set(b,css_name[css],parseInt(c[css].from)+unit[css])}else{f[css]=!$css.number[css]?parseInt(c[css]):c[css];unit[css]=$css.unit(css,c[css]);$style.set(b,css_name[css],$style.get(b,css_name[css]))}if(css==='left'||css==='top'){offset=$offset(b);$style.set(b,css,(css==='left'?offset.left:offset.top)+'px')}css_style.push(css)}setTimeout(function(){g[transition_name]='all '+d+'ms';if(c['left']||c['top']){g[transform_name]='translateZ(0)'}$each(css_style,function(i,a){g[css_name[a]]=f[a]+unit[a]})},15);setTimeout(function(){g[transition_name]=g[transform_name]='';if(e){e(b)}},d);return b}})():function(a,b,c,d){var e=0,p=30,i=0,j=0,length=0,css,css_to_value=[],css_from_value=[],css_name=[],css_unit=[],css_style=[],property_value,offset,timer;c=c||'300';for(css in b){css_name.push(css==='opacity'?'filter':$string.camelCase(css));if(b[css].from!=null){property_value=b[css].to;css_from_value.push(!$css.number[css]?parseInt(b[css].from):b[css].from);$style.set(a,css_name[i],css_from_value[i]+$css.unit(css,property_value))}else{property_value=b[css];if(css==='left'||css==='top'){offset=$offset(a);css_from_value.push(css==='left'?offset.left:offset.top)}else{css_from_value.push(parseInt($style.get(a,$string.camelCase(css))))}}css_to_value.push(!$css.number[css]?parseInt(property_value):property_value);css_unit.push($css.unit(css,property_value));i++;length++}for(j=0;j<p;j++){css_style[j]=[];for(i=0;i<length;i++){css_style[j][css_name[i]]=css_name[i]==='filter'?'alpha(opacity='+(css_from_value[i]+(css_to_value[i]-css_from_value[i])/p*j)*100+')':(css_from_value[i]+(css_to_value[i]-css_from_value[i])/p*j)+css_unit[i]}}for(;i<p;i++){timer=setTimeout(function(){for(i=0;i<length;i++){a.style[css_name[i]]=css_style[e][css_name[i]]}e++},(c/p)*i)}setTimeout(function(){for(i=0;i<length;i++){a.style[css_name[i]]=css_style[e][css_name[i]]}if(d){d(a)}},c);return a},$fadeout:function(a,b,c){b=b||'500';return $animate(a,{'opacity':{from:1,to:0}},b,c)},$fadein:function(a,b,c){b=b||'500';return $animate(a,{'opacity':{from:0,to:1}},b,c)},$cookie:{get:function(a){var b=document.cookie.split('; '),i=0,l=b.length,temp;for(;i<l;i++){temp=b[i].split('=');if(temp[0]==a){return decodeURIComponent(temp[1])}}return null},set:function(a,b,c){var d=new Date(),expires_date;d.setTime(d.getTime());if(c){c=c*86400000}expires_date=new Date(d.getTime()+(c));return document.cookie=a+'='+encodeURIComponent(b)+((c)?';expires='+expires_date.toGMTString():'')+'; path=/'},remove:function(){$each(arguments,function(i,a){$cookie.set(a,'',-1)});return true}},$json:{decode:window.JSON?function(a){return $json.isJSON(a)?JSON.parse($string.trim(a)):false}:function(a){return $json.isJSON(a)?eval('('+$string.trim(a)+')'):false},encode:window.JSON?function(a){return JSON.stringify(a)}:function(e){function stringify(c){var d=[],i,type,value,rvalue;for(i in c){value=c[i];type=typeof value;if(type==='undefined'){return}if(type!=='function'){switch(type){case'object':rvalue=value===null?value:value.getDay?'"'+(1e3-~value.getUTCMonth()*10+value.toUTCString()+1e3+value/1).replace(/1(..).*?(\d\d)\D+(\d+).(\S+).*(...)/,'$3-$1-$2T$4.$5Z')+'"':value.length?'['+(function(){var b=[];$each(value,function(i,a){b.push((typeof a==='string'?'"'+$string.slashes(a)+'"':a))});return b.join(',')})()+']':$json.encode(value);break;case'number':rvalue=!isFinite(value)?null:value;break;case'boolean':case'null':rvalue=value;break;case'string':rvalue='"'+$string.slashes(value)+'"';break}d.push('"'+i+'"'+':'+rvalue)}}return d.join(',')}return'{'+stringify(e)+'}'},isJSON:function(a){return typeof a==='string'&&$string.trim(a)!==''?h.rvalidchars.test(a.replace(h.rvalidescape,'@').replace(h.rvalidtokens,']').replace(h.rvalidbraces,'')):false}},$ajax:function(c,d){if(typeof c==='object'){d=c;c=undefined}d=d||{};var e=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP'),param=[],type=d.type||'POST',response,c;if(e){c=c||d.url;e.open(type,c,true);e.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');if(d.header){$each(d.header,function(a,b){e.setRequestHeader(a,b)})}if(d.data){$each(d.data,function(a,b){param.push($url(a)+'='+$url(b))})}e.send(param.join('&').replace(/%20/g,'+'));e.onreadystatechange=function(){if(e.readyState===4&&e.status===200&&d.success){data=e.responseText;d.success(data!=''&&$json.isJSON(data)?$json.decode(data):data)}else{if(d.error){d.error.call()}}}}},$loadscript:function(a){return $before(document.head||document.getElementsByTagName('head')[0]||document.documentElement,$new('script',{'type':'text/javascript','async':true,'src':a}))},$url:function(a){return encodeURIComponent(a)},$rand:function(a,b){return Math.floor(Math.random()*(b-a+1)+a)},$browser:(function(){var a=navigator.userAgent.toLowerCase(),browser={msie:/msie/,msie6:/msie 6\.0/,msie7:/msie 7\.0/,msie8:/msie 8\.0/,msie9:/msie 9\.0/,msie10:/msie 10\.0/,firefox:/firefox/,opera:/opera/,webkit:/webkit/,iPad:/ipad/,iPhone:/iphone/,android:/android/},key;for(key in browser){browser[key]=browser[key].test(a)}return browser}())};for(var k in h){if(k.indexOf('$')===0){window[k]=h[k]}}window.Qatrix=h;$ready(function(){if(!document.querySelectorAll){h.Qselector=$append(document.body,$new('style'))}if(!window.localStorage){h.storage=$append(document.body,$new('link',{'style':{'behavior':'url(#default#userData)'}}))}})})();

/* Cross Domain */
var XD=function(){var e,g,h=1,f,d=this;return{postMessage:function(c,b,a){b&&(a=a||parent,d.postMessage?a.postMessage(c,b.replace(/([^:]+:\/\/[^\/]+).*/,"$1")):b&&(a.location=b.replace(/#.*$/,"")+"#"+ +new Date+h++ +"&"+c))},receiveMessage:function(c,b){if(d.postMessage)if(c&&(f=function(a){if("string"===typeof b&&a.origin!==b||"[object Function]"===Object.prototype.toString.call(b)&&!1===b(a.origin))return!1;c(a)}),d.addEventListener)d[c?"addEventListener":"removeEventListener"]("message",f,!1);
else d[c?"attachEvent":"detachEvent"]("onmessage",f);else e&&clearInterval(e),e=null,c&&(e=setInterval(function(){var a=document.location.hash,b=/^#?\d+&/;a!==g&&b.test(a)&&(g=a,c({data:a.replace(b,"")}))},100))}}}();

/*!
* aug.js - A javascript library to extend existing objects and prototypes
* v0.0.3
* https://github.com/jgallen23/aug
* copyright JGA 2011
* MIT License
*/
var aug=function(){var b=Array.prototype.slice.call(arguments),c=!1,d=b.shift(),e="";if(typeof d=="string"||typeof d=="boolean")e=d===!0?"deep":d,d=b.shift(),e=="defaults"&&(d=aug({},d),e="strict");for(var f=0,g=b.length;f<g;f++){var h=b[f];for(var i in h)if(e=="deep"&&typeof h[i]=="object"&&typeof d[i]!="undefined")aug(e,d[i],h[i]);else if(e!="strict"||e=="strict"&&typeof d[i]!="undefined")d[i]=h[i]}return d};typeof window=="undefined"&&(module.exports=aug)

var currentDate		= new Date(),
	currentDate		= currentDate.getTime(),
	emcOriginConfig	= $json.decode(decodeURIComponent(window.name)),
	autoClose,
	currentState,
	trigger;

var emcOrigin = (function() {
	var publicMethods = {
		analytics: function(type, param) {
			
			if(emcOriginConfig.preview == true) {
				var baseLabel	= '[Origin] '+param.name+'--'+param.id;
				
				switch(type) {
					case 'expand':
						console.log('expand');
						//_gaq.push(['_trackEvent', baseLabel, 'Expand']);
						break;
					
					case 'click':
						console.log('click - '+param);
						//_gaq.push(['_trackEvent', baseLabel, '[Click] '+param]);
						break;
						
					case 'default':
						console.log('close');
						//_gaq.push(['_trackEvent', baseLabel, 'Close']);
						break;
						
					case 'load':
						console.log('load');
						//_gaq.push(['_trackEvent', baseLabel, 'Load']);
						break;
				}
			}
		},
		autoInitiate: function() {
			if(publicMethods.query(document.location.href, 'auto') > 0) {
				//Grabs cookie and compares value. If value in cookie is less than frequency cap, auto initiate unit
				var cookie 	= ($cookie.get('emcOrigin-'+data.id))? parseInt($cookie.get('emcOrigin-'+data.id)): 0;

				if(cookie < publicMethods.query(document.location.href, 'auto')) {
					var now		= new Date(),
						expire 	= new Date();
						cookie++;
					expire.setFullYear(now.getFullYear());
					expire.setMonth(now.getMonth());
					expire.setDate(now.getDate()+1);
					expire.setHours(now.getHours());
						
					document.cookie 	= 'emcOrigin-'+data.id+'='+cookie+';expires='+expire.toUTCString();
					
					emcOriginTrigger[data.format]();
					
					if(publicMethods.query(document.location.href, 'close') > 0) {
						autoClose		= setTimeout(function() {aug(data, {'toggle': 'default'});emcOriginTrigger[data.format]();aug(data, {'toggle': 'expand'});}, parseInt(publicMethods.query(document.location.href, 'close')));
					}
				}
			}
		},
		link: function() {
			var	clickthruId;
			
			if($select('a[id^="link"]').length > 0) {
				$each($select('a[id^="link"]'), function(i, node) {
					node.onclick = function(e) {
						publicMethods.analytics('click', e.target.href);
					}
				});
			}
			
			if($select('a[id^="clickthru"]').length > 0) {
				$each($select('a[id^="clickthru"]'), function(i, node) {
					clickthruId		= $data.get(node, 'type');
					$attr.set(node, 'href', emcOriginConfig[clickthruId]);
					
					node.onclick = function(e) {
						publicMethods.analytics('click', e.target.href);
					}
				});
			}

		},
		query: function(string, variable) {
	        var vars = string.split("&");
	        for(var i = 0; i < vars.length; i++) {
	            var pair = vars[i].split('=');
	            if (pair[0] == variable) {
	                return unescape(pair[1]);
	            }
	        }
		},
		schedule: function(type) {
			var scheduleTrigger	= true;
			
			if($select('#'+type).length) {
				$each($select('#'+type+' [id^="schedule-"]'), function(i, node) {
					var startDate	= ($data.get(node, 'startDate') == 0)? Number.NEGATIVE_INFINITY: $data.get(node, 'startDate'),
						endDate		= ($data.get(node, 'endDate') == 0)? Number.POSITIVE_INFINITY: $data.get(node, 'endDate');
					
					if(!scheduleTrigger) $remove(node);

					if((currentDate >= startDate && currentDate <= endDate) && scheduleTrigger) {
						scheduleTrigger	= false;
					} else {
						$remove(node);
					}
					
				});
			}
		},
		toggle: function(type, selector) {
			var arrayType	= ['content-embed', 'content-flash'];
			for(var i in arrayType) {
				$class($(selector), arrayType[i], function(node) {
					switch(type) {
						case 'hide':
							$data.set(node, 'content', encodeURIComponent($html(node)));
							$hide(node);
							$empty(node);
							break;
						case 'show':
							var content 	= decodeURIComponent($data.get(node, 'content'));
							$show(node);
							$html(node, content);
							//SB Playlist edge case
							if(typeof emcOrigin_sbPlayerConfig != 'undefined') SbTeaserWidget.init(emcOrigin_sbPlayerConfig);
							
							break;
					}
				});
			}
		},
		xd: function() {
			XD.postMessage($json.encode(data), decodeURIComponent(source.substring(8)));
		}
	};
	
	var emcOriginTrigger = {
		init: function(e) {
			clearTimeout(autoClose);
			switch(e.type) {
				case 'click':
					emcOriginTrigger[data.format]();
					break;
				case 'mousemove':
					var onmousestop = function() {
							emcOrigin.trigger('disable');
							emcOriginTrigger[data.format]();
							trigger	= false;
						};
					return function() {
						clearTimeout(trigger);
						trigger = setTimeout(onmousestop, publicMethods.query(document.location.href, 'hover'));
					}();
					break;
			}
		},
		expansion: function() {
			emcOrigin.trigger('disable');
			switch(currentState) {
				case 'default':
					animateFrom		= data.start;
					animateTo		= data.end;
					currentState	= 'expand';
					embed			= 'show';
					break;
				case 'expand':
					animateFrom		= data.end;
					animateTo		= data.start;
					currentState	= 'default';
					embed			= 'hide';
					break;
			}
			
			aug(data, {'toggle': currentState});
			publicMethods.analytics(currentState, data);
			$animate($(data.animateSelector), {'top': {from: animateFrom, to: animateTo}}, data.duration, function(item) {
				$pos($(data.animateSelector), 0, animateTo);
				publicMethods.toggle(embed, 'expand');
				emcOrigin.trigger('enable');
			});
			
			publicMethods.xd();
		},
		overlay: function() {
			if(data.toggle == 'expand') {
				publicMethods.toggle('hide', 'default');
				publicMethods.toggle('show', 'default');
				setTimeout(function(){emcOrigin.trigger('enable');}, 500);
			} else {
			}
			
			publicMethods.analytics(data.toggle, data);
			publicMethods.xd();
		}
	};

	return {
		init: function(type) {
			publicMethods.link();
			emcOrigin.trigger('enable');
			
			switch(data.format) {
				case 'expansion':
					currentState	= 'default';
					publicMethods.analytics('load', data);
					publicMethods.schedule('default');
					publicMethods.schedule('expand');
					publicMethods.toggle('hide', 'expand');
					break;
				case 'overlay':
					switch(data.toggle) {
						case 'default':
							publicMethods.schedule('expand');
							break;
						case 'expand':
							publicMethods.analytics('load', data);
							publicMethods.schedule('default');
							break;
					}
					break;
			}
			publicMethods.autoInitiate();
		},
		trigger: function(state) {
		
			switch(state) {
				case 'disable':
					$each($select('.trigger'), function(i, node){
						$event.remove(node, 'click', emcOriginTrigger.init);
						$event.remove(node, 'mousemove', emcOriginTrigger.init);
					});
					break;
				default:
				case 'enable':
					$each($select('.trigger'), function(i, node) {
						//Hover
						if($data.get(node, 'type') == 'mouseenter') {
							$event.add(node, 'mousemove', emcOriginTrigger.init);
							$event.add(node, 'mouseout', function() {
								clearTimeout(trigger);
							});
						} else {
							//Click
							$event.add(node, $data.get(node, 'type'), emcOriginTrigger.init);
						}
					});

					break;
			}
		}
	}

})();

$ready(function() {emcOrigin.init();});