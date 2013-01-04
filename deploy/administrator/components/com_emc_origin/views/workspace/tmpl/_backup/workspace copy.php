<?php defined('_JEXEC') or die('Restricted access');?>
	<div id="workspaceCtrl" ng:controller="workspaceCtrl" ng:app="workspaceApp" ng:cloak class="">
		<h1 id="workspace-title">{{originConfig.name}}</h1>
		<div id="views" class="{{originUI.workspace}}-active">
			<a href="javascript:void(0);" ng:click="uiChange('workspace', 'desktop')" id="views-desktop" class="originButton">desktop</a>
			<a href="javascript:void(0);" ng:click="uiChange('workspace', 'tablet')" id="views-tablet" class="originButton">tablet</a>
			<a href="javascript:void(0);" ng:click="uiChange('workspace', 'mobile')" id="views-mobile" class="originButton">mobile</a>
		</div>
	
		<div id="workspace-right">
			<div id="schedules" class="">
				<div id="schedule-{{$index}}" ng:class="{'schedule-active': $index == originUI.schedule}" class="schedule originButton" ng:click="uiChange('schedule', $index)" ng:repeat="schedule in originContent">
					<span class="originButton-arrow"></span>
					<span class="schedule-label">{{schedule.start_date}} - {{schedule.end_date}}</span>
				</div>
			</div>
			<div id="workspace" class="originUI-droppable">
				<div id="" class="workspace-bg" style="background-image: url(/assets/components/com_emc_origin/{{id}}/{{originConfig.config[state_content]}})" workspace>
					<!-- <div id="" class="content {{content.content_data.type}}" ng:repeat="content in originContent[originUI.schedule][originUI.state+'_'+originUI.workspace]" content></div> -->
					<content-test id="content-{{$index}}" ng:repeat="content in originContent[originUI.schedule][originUI.state+'_'+originUI.workspace]"></content-test>
				</div>
			</div>
		</div>
		<div id="panel" class="originUI-bg">
			<div id="panel-tabs" class="{{originUI.panel}}-active">
				<a href="javascript:void(0);" id="tab-layers" class="originButton" ng:click="uiChange('panel', 'layers')">layers</a>
				<a href="javascript:void(0);" id="tab-assets" class="originButton" ng:click="uiChange('panel', 'assets')">assets</a>
				<a href="javascript:void(0);" id="tab-add" class="originButton" ng:click="addPanel('components')">add</a>
			</div>
			<div id="panel-content" class="{{originUI.panel}}-active">
				<div id="layers">
					<a href="javascript:void(0);" id="" ng:click="addPanel('background')" style="display: block">Set background</a>
					<div id="panel-states" class="{{originUI.state}}-active">
						<div id="initial" class="originButton" ng:click="uiChange('state', 'initial')">
							<span class="originButton-arrow"></span>
							<span class="panel-label">initial</span>
						</div><!--
						--><div id="triggered" class="originButton" ng:click="uiChange('state', 'triggered')">
							<span class="originButton-arrow"></span>
							<span class="panel-label">triggered</span>
						</div>
					</div>
					<ul class="originList">
						<li class="layer" ng:repeat="layer in layers | orderBy: layer.content_config.zIndex">
							<a href="javascript:void(0);" class="layer-thumbnail">
								<img ng:src="/administrator/components/com_emc_origin/assets/images/_components/_thumbnail/{{layer.content_data.type}}.png"/>
							</a>
							<span class="layer-title">{{layer.content_data.title}}</span>
							<a href="javascript:void(0);" class="layer-edit originButton originButton-iconEdit" ng:click="addPanel($index)">edit</a>
						</li>
					</ul>
				</div>
				<div id="assets">
					<form id="fileupload" method="POST" enctype="multipart/form-data" >
						<input type="file" multiple="" name="files[]">
						<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $this->id;?>/"/>
					</form>
					<ul class="originList">
						<li class="asset" ng:repeat="asset in assets.files" ng:model="asset" asset>{{asset.name}}</li>
					</ul>
				</div>
			</div>
		</div><!--
		--><div id="panel-add" class="{{originUI.panelAdd}}-active originUI-bg">
			<a href="javascript:void(0);" id="add-close" class="originButton originButton-iconCancel" ng:click="addPanel('cancel')">close</a>
			<div id="components">
				<h2>Components</h2>
				<div class="component-group" ng:repeat="component in components | orderBy:'group'">
					<h3>{{component.group}}</h3>
					<ul class="originList">
						<li class="component-item" ng:repeat="content in component.content | orderBy:'name'">
							<a href="javascript:void(0);" class="originButton" ng:click="addPanel('editor', content.alias)">
								<img class="" ng:src="{{content.imgLarge}}"/>
								<label>{{content.name}}</label>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="editor">
				<h2 style="background-image: url(/administrator/components/com_emc_origin/assets/images/_components/_thumbnail/{{originUI.editor}}.png)">{{originUI.editor}} Editor</h2>
				<form class="originForm" ng:model="originEditor">
					<div id="editor-content">
						<div ng:include src="editor"></div>
					</div>
					<div id="editor-config" class="">
						<div ng:include src="config"></div>
					</div>
					<a href="javascript:void(0);" id="editor-save" class="originButton originButton-iconNext" ng:click="originSave('content_data')">save</a>
				</form>
			</div>
		</div>
		
		
		<input type="hidden" id="origin_id" value="<?php echo $this->id;?>"/>
	</div>
	
	<script src="/administrator/components/com_emc_origin/assets/js/app.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/controller.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/services.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/directives.js"></script>