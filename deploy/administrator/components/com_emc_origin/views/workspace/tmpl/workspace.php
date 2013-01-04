<?php defined('_JEXEC') or die('Restricted access');?>
	<div id="workspaceCtrl" ng:controller="workspaceCtrl" ng:app="workspaceApp" ng:cloak class="">
		<h1 id="workspace-title">{{originConfig.name}}</h1>
		
		
		<!--
						<li><a href="javascript:void(0);" id="icons-desktop" class="originButton workspaceUI" ng:click="workspaceUI('view', 'desktop')">desktop</a></li>
				<li><a href="javascript:void(0);" id="icons-tablet" class="originButton workspaceUI" ng:click="workspaceUI('view', 'tablet')">tablet</a></li>
				<li><a href="javascript:void(0);" id="icons-mobile" class="originButton workspaceUI" ng:click="workspaceUI('view', 'mobile')">mobile</a></li>
		-->
		<div id="workspace-top">
			<div id="states">
				<a href="javascript:void(0);" id="initial" class="originButton" ng:click="workspaceUI('state', 'initial')" ng:class="{active: originWorkspace.state=='initial'}">initial</a>
				<a href="javascript:void(0);" id="triggered" class="originButton" ng:click="workspaceUI('state', 'triggered')" ng:class="{active: originWorkspace.state=='triggered'}">triggered</a>
			</div>
			<div id="views">
				<a href="javascript:void(0);" id="desktop" class="originButton" ng:click="workspaceUI('view', 'desktop')" ng:class="{active: originWorkspace.view=='desktop'}">desktop</a>
				<a href="javascript:void(0);" id="tablet" class="originButton" ng:click="workspaceUI('view', 'tablet')" ng:class="{active: originWorkspace.view=='tablet'}">tablet</a>
				<a href="javascript:void(0);" id="mobile" class="originButton" ng:click="workspaceUI('view', 'mobile')" ng:class="{active: originWorkspace.view=='mobile'}">mobile</a>
			</div>
		</div>
		<div id="workspace-right">
			<div id="workspace-schedules" class="">
				<div id="schedule-{{$index}}" class="workspace-schedule originButton" ng:click="workspaceUI('schedule', $index)" ng:repeat="schedule in originObj.content" ng:class="{active: originWorkspace.schedule==$index}">
					<span class="schedule-label">
						<span class="schedule-label-month">{{schedule.start_date | dateFormat:'M'}}</span>
						<span class="schedule-label-day">{{schedule.start_date | dateFormat:'d'}}</span>
						<span class="schedule-label-year">{{schedule.start_date | dateFormat: 'yy'}}</span>
					</span>
					<span class="schedule-seperator">-</span>
					<span class="schedule-label">
						<span class="schedule-label-month">{{schedule.end_date | dateFormat:'M'}}</span>
						<span class="schedule-label-day">{{schedule.end_date | dateFormat: 'd'}}</span>
						<span class="schedule-label-year">{{schedule.end_date | dateFormat: 'yy'}}</span>
					</span>
					<!-- <span class="schedule-label-start">{{schedule.start_date}}</span><span class="schedule-label-end">{{schedule.end_date}}</span> -->
				</div>
			</div>
			<div id="workspace" class="originUI-droppable">
				<div id="" class="workspace-bg" style="background-image: url(/assets/components/com_emc_origin/{{originWorkspace.id}}/{{originObj.config.config[originWorkspace.state_view]}})" workspace>
					<div id="content-{{content.id}}" class="content {{content.content_data.type}}" ng:repeat="content in originObj.current" ng:class="{active: originEditor.id == content.id}" content></div>
				</div>
			</div>
		</div>
		<div id="panel" class="">
			<div id="assets" class="" ng:show="originWorkspace.panel == 'assets'">
				<form id="fileupload" method="POST" enctype="multipart/form-data" >
					<input type="file" multiple="" name="files[]">
					<span id="assets-add"></span>
					<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_origin/<?php echo $this->id;?>/"/>
				</form>
				<div class="preview">
					<img ng:src="/assets/components/com_emc_origin/{{originWorkspace.id}}/{{originEditor.name}}"/>
				</div>
				<ul class="originList">
					<li class="asset" ng:repeat="asset in originObj.assets.files" ng:click="originEditor.name = asset.name" ng:class="{active: originEditor.name == asset.name}" asset>
						{{asset.name}}
					</li>
				</ul>
			</div>
			<div id="layers" class="" ng:show="originWorkspace.panel == 'layers'">
				<span id="components-add" class="" ng:click="panelSlideComponents()">add</span>
				<ul class="originList" layers>
					<li id="layer-{{layer.id}}" class="layer" ng:repeat="layer in originObj.current | orderBy:layerZindex:true" ng:class="{active: originEditor.id == layer.id}" data-index="{{layer.id}}" layer>
						<a href="javascript:void(0);" class="layer-thumbnail" style="background-image: url(/administrator/components/com_emc_origin/assets/images/_components/_thumbnail/{{layer.content_data.type}}.png);">edit</a>
						<span class="layer-title" ng:click="panelSlideEditor(layer.content_data.type, layer)">{{layer.content_data.title}}-{{layer.id}}</span>
						<!-- <a href="javascript:void(0);" class="layer-edit originButton originButton-iconEdit" ng:click="panelAdd('edit', $index)">edit</a> -->
					</li>
				</ul>
				<span id="components-background" class="" ng:click="panelSlideBackground()">add</span>	
			</div>
			<div id="schedules" class="" ng:show="originWorkspace.panel == 'schedules'">
				<span id="schedules-add" class="" ng:click="panelSlideScheduler()">add</span>
				<ul class="originList">
					<li ng:repeat="schedule in originObj.content">
						<!-- <span class="">{{schedule.start_date}}-{{schedule.end_date}}</span> -->
						<span class="schedule-label">
							<span class="schedule-label-month">{{schedule.start_date | dateFormat:'M'}}</span>
							<span class="schedule-label-day">{{schedule.start_date | dateFormat:'d'}}</span>
							<span class="schedule-label-year">{{schedule.start_date | dateFormat: 'yy'}}</span>
						</span>
						<span class="schedule-seperator">-</span>
						<span class="schedule-label">
							<span class="schedule-label-month">{{schedule.end_date | dateFormat:'M'}}</span>
							<span class="schedule-label-day">{{schedule.end_date | dateFormat: 'd'}}</span>
							<span class="schedule-label-year">{{schedule.end_date | dateFormat: 'yy'}}</span>
						</span>
						<a href="javascript:void(0)" ng:click="panelSlideScheduler(schedule)">edit</a>
					</li>
				</ul>
			</div>
		</div>
		<div id="panel-settings" class="">
			<ul id="panel-views" class="originList">
				<li><a href="javascript:void(0);" id="icons-assets" class="originButton" ng:class="{active: originWorkspace.panel=='assets'}" ng:click="workspaceUI('panel', 'assets')">assets</a></li>
				<li><a href="javascript:void(0);" id="icons-layers" class="originButton" ng:class="{active: originWorkspace.panel=='layers'}" ng:click="workspaceUI('panel', 'layers')">layers</a></li>
				<li><a href="javascript:void(0);" id="icons-schedule" class="originButton" ng:class="{active: originWorkspace.panel=='schedules'}" ng:click="workspaceUI('panel', 'schedules')">schedules</a></li>
				<li><a href="javascript:void(0);" id="icons-settings" class="originButton workspaceUI" ng:click="settings('open')">settings</a></li>
			</ul>
			<div id="settings" class="panel-content">
				<a href="javascript:void(0);" id="settings-close" class="originButton originButton-iconCancel" ng:click="settings('close')">close</a>
				<h2>Settings</h2>
				<ul class="originList originForm">
					<li>
						<input type="text" ng:model="originObj.config.config.name"/>
					</li>
					<li>
						<input type="text" ng:model="originObj.config.config.ga"/>
					</li>
				</ul>
			</div>
		</div>
		<div id="panel-slide" class="">
			<a href="javascript:void(0);" id="add-close" class="originButton originButton-iconCancel" ng:click="panelSlide('close')">close</a>
			<div id="background" class="panel-content" ng:show="originWorkspace.panelSlideContent == 'background'">
				<h2>Background</h2>
				<img ng:src="/assets/components/com_emc_origin/{{originWorkspace.id}}/{{background}}"/>
				<form id="background-form" class="originForm" ng:model="originEditor">
					<ul class="originList">
						<li class="asset" ng:repeat="asset in originObj.assets.files" ng:click="originServices('background_preview', asset)">{{asset.name}}</li>
					</ul>
					<a href="javascript:void(0);" id="background-save" class="originButton originButton-iconNext" ng:click="originServices('background_save')">save</a>
				</form>
			</div>
			<div id="components" class="panel-content" ng:show="originWorkspace.panelSlideContent == 'components'">
				<h2>Components</h2>
				<div class="component-group" ng:repeat="component in originObj.components | orderBy:'group'">
					<h3>{{component.group}}</h3>
					<ul class="originList">
						<li class="component-item" ng:repeat="content in component.content | orderBy:'name'">
							<a href="javascript:void(0);" class="originButton" ng:click="panelSlideEditor(content.alias)" style="background-image: url({{content.imgLarge}});">{{content.name}}</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="editor" class="panel-content" ng:show="originWorkspace.panelSlideContent == 'editor'">
			<!-- 	<h2>Editor</h2> -->
				<form id="editor-form" class="originForm" ng:model="originEditor">
					<div id="editor-content">
						<?php //include_once($_SERVER['DOCUMENT_ROOT'].'/administrator/components/com_emc_origin/assets/templates/_components.php');?>
						<div ng:include src="editor"></div>
					</div>
					<div id="editor-config" class="">
						<h2>Config</h2>
						<ul id="config-dimensions" class="originList">
							<li>Width<input type="text" name="width" ng:model="originEditor.content_config.width" config="width"/></li>
							<li>Height<input type="text" name="height" ng:model="originEditor.content_config.height" config="height"/></li>
							<li>Z-index<input type="text" name="zIndex" ng:model="originEditor.content_config.zIndex"/></li>
						</ul>
						<ul id="config-coords" class="originList">
							<li>X<input type="text" name="left" ng:model="originEditor.content_config.left" config="left"/></li>
							<li>Y<input type="text" name="top" ng:model="originEditor.content_config.top" config="top"/></li>
						</ul>
						<!-- <span id="config-level">z-Index<input type="text" name="zIndex" ng:model="originEditor.content_config.zIndex"/></span> -->
					</div>
				</form>
				<a href="javascript:void(0);" id="editor-delete" class="originButton originButton-iconCancel" ng:click="originServices('delete', originEditor)" ng:show="originEditor.empty != true">remove</a>
				<a href="javascript:void(0);" id="editor-cancel" class="originButton originButton-iconCancel" ng:click="panelSlide('close')" ng:show="originEditor.empty == true">cancel</a>
				<a href="javascript:void(0);" id="editor-save" class="originButton originButton-iconNext" ng:click="originServices('save', originEditor)">save</a>
			</div>
<!--
			<div id="preview" class="panel-content" ng:show="originWorkspace.panelSlideContent == 'preview'">
				<h2>Preview</h2>
				<img ng:src="/assets/components/com_emc_origin/{{originWorkspace.id}}/{{originEditor.name}}"/>
			</div>
-->
			<div id="scheduler" class="panel-content" ng:show="originWorkspace.panelSlideContent == 'scheduler'">
				<h2>Scheduler</h2>
			</div>
		</div>
		<input type="hidden" id="origin_id" value="<?php echo $this->id;?>"/>
	</div>
	
	<script src="/administrator/components/com_emc_origin/assets/js/controller.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/services.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/directives.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/filters.js"></script>