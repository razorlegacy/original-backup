<?php // no direct access
defined('_JEXEC') or die('Restricted access');
	function h($content) {
		echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
	}
?>
<!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]-->
<?php echo $this->nav->getNav(); ?>
<form action="index.php" method="post" name="adminForm" id="videos"><?php
foreach ($this->videos as $date => $videos) {
	?><div class ="videoplaylist"><h2><?php
	h($date);
	?></h2><ul class="connectedSortable"><?php
	foreach ($videos as $video) {
		?><li class="ui-state-default">
				<a class="videotitle" href="<?php h($this->editvideo.$video->id); ?>"><?php h($video->name); ?></a>
				<a href="<?php h($this->editvideo.$video->id); ?>" class="editvideo">edit</a>
				<span class="close"></span>
				<input type="button" href="<?php h($this->deletevideo.$video->id); ?>" class="delete" value="delete">
				<input type="hidden" value="<?php echo $video->id ?>" name="id"/>
			</li><?php
	}
	?></ul></div><?php
}
?><a class="addvideo" href="<?php h($this->addvideo);?>">Add Video</a>
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" id="option"/>
				<input type="hidden" name="task" value="save"/>
	<input type="hidden" id="sliver_id" name="sliver_id" value="<?php echo $this->sliver_id; ?>"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->sliver_id; ?>"/>
</form>
