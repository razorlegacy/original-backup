<?php defined('_JEXEC') or die('Restricted access'); ?>
<ul>
<?php 
	$acl = new evolveUserHelper();
	
	$model = new modActivityHelper();
	$activities = $model->loadActivity();
	
	foreach($activities as $activity) {
		//get username
		$user = $acl->loadUser($activity->modified_by);
				
		echo '<li>'.$activity->date.' '.$user[0].' '.$activity->action.' '.$activity->name.'</li>';
	}
?>
</ul>