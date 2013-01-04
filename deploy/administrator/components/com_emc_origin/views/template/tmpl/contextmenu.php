<?php defined('_JEXEC') or die('Restricted access');?>


<ul id="markerMenu" class="">
	<li><?php echo evolveUi::dialogButton('145', JText::_('CONTEXTMENU_EDIT'), 'marker_edit', 'evolve-bg-primary');?></li>
	<li><?php echo evolveUi::dialogButton('10', JText::_('CONTEXTMENU_FRONT'), 'marker_front', 'evolve-bg-primary');?></li>
	<li><?php echo evolveUi::dialogButton('7', JText::_('CONTEXTMENU_BACK'), 'marker_back', 'evolve-bg-primary');?></li>
	<li><?php echo evolveUi::dialogButton('186', JText::_('CONTEXTMENU_DELETE'), 'marker_delete', 'evolve-bg-primary');?></li>
</ul>

<ul id="scheduleMenuDefault">
	<li><?php echo evolveUi::dialogButton('55', JText::_('CONTEXTMENU_COPY'), 'schedule_copy', 'evolve-bg-primary');?></li>
</ul>

<ul id="scheduleMenu">
	<li><?php echo evolveUi::dialogButton('145', JText::_('CONTEXTMENU_EDIT'), 'schedule_edit', 'evolve-bg-primary');?></li>
	<li><?php echo evolveUi::dialogButton('55', JText::_('CONTEXTMENU_COPY'), 'schedule_copy', 'evolve-bg-primary');?></li>
	<li><?php echo evolveUi::dialogButton('186', JText::_('CONTEXTMENU_DELETE'), 'schedule_delete', 'evolve-bg-primary');?></li>
</ul>