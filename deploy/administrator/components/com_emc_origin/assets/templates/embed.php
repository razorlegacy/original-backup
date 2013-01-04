<div id="editor-embed">
	<label>Embed Code</label>
	<textarea id="" ui:codemirror="{theme:'night', lineWrapping: true}" ng:model="originEditor.content"></textarea>
	
	<!--
<input type="hidden" name="content" ng:model="originEditor.content" value="{{originEditor.content}}">
	<div class="originUI-hidden">
	<iframe width="560" height="315" src="http://www.youtube.com/embed/pQJXyOvKNK0" frameborder="0" allowfullscreen></iframe>
	<iframe src=\"<?php echo '';?>\" <%=style%>></iframe>
-->
	<script>
		var _scope = angular.element($j('#workspaceCtrl')).scope();
			_scope.originEditor.content_render	= '<iframe src="" <%=style%>></iframe>';
	</script>
</div>