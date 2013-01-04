<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
	$acl = new evolveUserHelper();
	
	$model = new modActivityHelper();
	$activities = $model->loadActivity();
?>

	<ul class="originList">
        <?php
        foreach($activities as $activity) {
                //get username
                switch($activity->action) {
                        case 'created':
                        	$user = JFactory::getUser($activity->manager);
                        	break;
                        case 'modified':
                        	$user = JFactory::getUser($activity->modified_by);
                        	break;
                }
                $user   = "<span class='activity-name'>{$user->name}</span>";
                $link   = "<a href='http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&view=preview&format=raw&id={$activity->id}&auto=0&close=0&hover=0' target='_blank' class='activity-link'>{$activity->name}</a>";
                $timestamp      = date('M j, Y', strtotime($activity->date)).' @'.date('g:i A', strtotime($activity->date));
               
                echo "<li><span class='activity-item'>{$user} {$activity->action} {$link}</span><span class='activity-timestamp'>{$timestamp}</span></li>";
                //echo "<tr><td class='activity-user'>{$user[0]}</td><td class='activity-action'>{$activity->action}</td><td class='activity-project'>{$link}</td><td>on</td><td class='activity-date'>{$date}</td><td>@</td><td class='activity-time'>{$time}</td></tr>";
        }
        ?>
        </ul> 