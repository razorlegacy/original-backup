<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	$user 			=& JFactory::getUser();
	$acl			= new evolveUserHelper();
	$originHelper	= new originHelper();
	$node			= isset($_GET['node'])? $_GET['node']: 'default';
?>
	<h1><?php echo JText::_('LIST_TITLE');?></h1>
	<div ng:controller="listCtrl" ng:app="listApp" ng:cloak>
		<a href="javascript: void(0);" id="toggleShown" class="originButton" ng:click="toggleShown()">{{listState}}</a>
		<a href="javascript: void(0);" id="create" class="originButton originButton-iconAdd"><?php echo JText::_('LIST_CREATE');?></a>
		<div id="list">
			<a href="index.php?option=com_emc_origin&task=edit&id={{item.id}}" id="list-item-{{item.id}}" class="list-items {{item.status}} {{item.type}}" ng:repeat="item in listShown">
				<div class="item-preview" style="background-image: url(/assets/components/com_emc_origin/{{item.id}}/{{item.config.triggered_desktop}})"></div>
				<!-- <a href="/index.php?option=com_emc_origin&view=preview&format=raw&id={{item.id}}&auto=0&close=0&hover=0" target="_blank" class="item-preview" style="background-image: url({{item.bgDefault}})">preview</a> -->
				<!-- <a href="index.php?option=com_emc_origin&task=edit&id={{item.id}}" class="item-title">{{item.name}}</a> -->
				<!-- <img class="item-type" ng:src="/components/com_emc_origin/assets/images/storyboard/logo/{{item.type}}.png"/> -->
				<!-- <a href="" class="item-analytics">analytics</a> -->
				<span class="item-id">{{item.id}}</span>
				<div class="item-caption">
					<span class="item-title">{{item.name}}</span>
					<span class="item-modified">Last modified by {{item.modified_by}} on {{item.modify_date}}</span>
				</div>
				<!-- <span class="item-created">Created by {{item.manager}} on {{item.create_date}}</span> -->
			</a>
		</div>
		<div id="" class="originModal originUI-hidden">
			<div id="create-modal" class="">
				<h2><?php echo JText::_('LIST_CREATE');?></h2>
				<form id="create-form" class="originForm" ng:model="origin">
					<ul class="originList">
						<li>
							<input type="text" name="name" ng:model="origin.name" placeholder="<?php echo JText::_('LIST_CREATE_TITLE');?>" class="evolve-required"/>
						</li>
						<li class="create-type">
							<label><?php echo JText::_('LIST_CREATE_TEMPLATE');?></label>
							<select name="type" ng:model="origin.type" ng:options="type.name for type in types | orderBy: 'name'"></select>
						</li>
					</ul>
					<div class="create-storyboard">
						<img ng:src="{{origin.type.img}}" class="storyboard-image"/>
						<p class="storyboard-description">{{origin.type.description}}</p>
					</div>
					<div id="create-buttons">
						<a href="#" class="originButton originButton-iconCancel" ng:click="cancel()"><?php echo JText::_('CANCEL');?></a>
						<a href="#" class="originButton originButton-iconNext" ng:click="proceed($event)"><?php echo JText::_('PROCEED');?></a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="/administrator/components/com_emc_origin/assets/js/app.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/controller.js"></script>
	<script src="/administrator/components/com_emc_origin/assets/js/services.js"></script>