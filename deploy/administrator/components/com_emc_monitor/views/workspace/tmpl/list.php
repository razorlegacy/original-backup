<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	//$monitor = $this->monitor;
	//echo json_encode($monitor);
?>
	<div ng:controller="listCtrl" ng:app="listApp">
	<h2 id="monitor-app-title">{{title}}</h2>
		<div id="filters" style="float:right;">
			<!--form ng:submit="onSubmitted()"-->
			<form id="form_search" ng:model="monitor" ng-hide="hide">
				<input type="text" name="category" ng-model="monitor.category" placeholder="<?php echo JText::_('EVENT_CATEGORY_TITLE');?>"/><br/>
				<input ui-date id="monitor_start_date" name="date1" ng-model="monitor.start_date" value="{{filter[0].startDate | date:'MM dd, yyyy' }}"></input>
				<input ui-date id="monitor_end_date" name="date2" ng-model="monitor.end_date" value="{{filter[0].endDate | date:'MM dd, yyyy' }}"></input>
				<!--<br />    Date Received01: {{monitor.start_date}}
				<br />    Date Received02: {{monitor.end_date}}-->
				<!--input type="submit" value="apply" style="float:right;" -->
				<a href="#" class="monitorButton monitorButton-iconApply" ng:click="proceed($event)"><?php echo JText::_('SEARCH');?></a>
			</form>
			
		</div>
		<div id="totals">
			<div class="total-titles">
				<span class="title-total-events"><?php echo JText::_('TOTAL_EVENTS_TITLE');?></span>
				<span class="title-unique-events"><?php echo JText::_('UNIQUE_EVENTS_TITLE');?></span>
			</div>
			<!--div id="" class="total-items" ng:repeat="item in total">
				<span class="item-total-events">{{item.totalEvents}}</span>
				<span class="item-unique-events">{{item.uniqueEvents}}</span>
			</div-->
			<span class="item-total-events">{{monitor_totals.totalEvents}}</span>
			<span class="item-unique-events">{{monitor_totals.uniqueEvents}}</span>
		</div>
		<div id="list" ng-hide="hide">
			<div class="list-titles">
				<span class="title-category"><?php echo JText::_('EVENT_CATEGORY_TITLE');?></span>
				<span class="title-total-events"><?php echo JText::_('TOTAL_EVENTS_TITLE');?></span>
				<span class="title-unique-events"><?php echo JText::_('UNIQUE_EVENTS_TITLE');?></span>
			</div>
			<div id="list-item-{{item.id}}" class="list-items" ng:repeat="item in list[1]" ng-hide="hide">
				<a ng:click="monitorController(item.category,monitor.start_date,monitor.end_date)" href="#">{{item.category}}</a>
				<!--a href="/administrator/index.php?option=com_emc_monitor&task=getCategoryData&category={{item.categoryEncode}}&start_date={{monitor.start_date}}&end_date={{monitor.end_date}}">{{item.category}}</a-->
				<span class="item-total-events">{{item.totalEvents}}</span>
				<span class="item-unique-events">{{item.uniqueEvents}}</span>
			</div>
		</div>
		<div id="actions" ng-show="hide">
			<div class="action-titles">
				<span class="title-category"><?php echo JText::_('EVENT_ACTION_TITLE');?></span>
				<span class="title-total-events"><?php echo JText::_('TOTAL_EVENTS_TITLE');?></span>
				<span class="title-unique-events"><?php echo JText::_('UNIQUE_EVENTS_TITLE');?></span>
			</div>
			<div id="action-item" class="action-items" ng:repeat="item in actions">
				<span class="item-category">{{item.action}}</span>
				<span class="item-total-events">{{item.totalEvents}}</span>
				<span class="item-unique-events">{{item.uniqueEvents}}</span>
			</div>
		</div>

	</div>
	
	<script src="/administrator/components/com_emc_monitor/assets/js/app.js"></script>
	<script src="/administrator/components/com_emc_monitor/assets/js/controller.js"></script>
	<script src="/administrator/components/com_emc_monitor/assets/js/services.js"></script>
	<script src="/administrator/components/com_emc_monitor/assets/js/ui.js"></script>