﻿CKEDITOR.dialog.add('about',function(editor)
{var lang=editor.lang.jabout;return{title:CKEDITOR.env.ie?lang.dlgTitle:lang.title,minWidth:390,minHeight:230,contents:[{id:'tab1',label:'',title:'',expand:true,padding:0,elements:[{type:'html',html:'<style type="text/css">'+'.cke_about_container'+'{'+'color:#000 !important;'+'padding:10px 10px 0;'+'margin-top:5px'+'}'+'.cke_about_container p'+'{'+'margin: 0 0 10px;'+'}'+'.cke_about_container .cke_about_logo'+'{'+'height:130px;'+'background-image:url('+CKEDITOR.plugins.get('jabout').path+'dialogs/logo.png);'+'background-position:center; '+'background-repeat:no-repeat;'+'margin-bottom:10px;'+'background-color:#F2F2F2;'+'border-bottom:1px solid #E3E4E3;'+'border-top:1px solid #E3E4E3;'+'padding:5px 6px;'+'}'+'.cke_about_container a'+'{'+'cursor:pointer !important;'+'color:blue !important;'+'text-decoration:underline !important;'+'}'+'</style>'+'<div class="cke_about_container">'+'<div class="cke_about_logo"></div>'+'<p>'+'For licensing information please visit the following web sites:<br>'+'<a href="http://joomlackeditor.com/terms-of-use" target="_blank">http://joomlackeditor.com/terms-of-use</a><br>'+'<a href="http://ckeditor.com/license" target="_blank">http://ckeditor.com/license</a>'+'</p>'+'<p>'+'Joomla!&trade; Integration & Plug-ins for the CKEditor.<br>'+'Copyright © <a href="http://www.webxsolution.com/"title="Specialists in Joomla!&trade; related matters" target="_blank">WebxSolution Ltd</a>, All rights reserved.<br>'+'License: GPLv2.0.<br>'+'Author: <a href="http://www.webxsolution.com/"title="Specialists in Joomla!&trade; related matters" target="_blank">WebxSolution Ltd</a>.<br>'+'</p>'+'<p>'+'CK API Engine '+CKEDITOR.version+' (revision '+CKEDITOR.revision+')<br>'+
lang.copy.replace('$1','<a href="http://cksource.com/" target="_blank">CKSource</a> - Frederico Knabben')+'</p>'+'</div>'}]}],buttons:[CKEDITOR.dialog.cancelButton]};});