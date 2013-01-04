<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?><!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]-->
<style type="text/css">
.scheduledImage .images .flash img{
	height: <?php echo $this->sliver->sliver_height; ?>px;
}
.scheduledImage .images .actionbar img{
	height: <?php echo $this->sliver->actionbar_height; ?>px;
}
</style><?php
echo $this->nav->getNav();
?><form action="index.php" method="post" name="adminForm" id="adminForm">
	<?php if(isset($this->scheduledImages)){ ?>
	<div id="images">
		<fieldset class="adminForm">
			<legend>Images</legend><input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>" id="option"/>
		<input type="hidden" id="sliver_id" name="sliver_id" value="<?php echo $this->sliver_id; ?>"/>
		<input type="hidden" id="cid" name="cid[]" value="<?php echo $this->sliver_id; ?>"/>
		<input type="hidden" name="task" value="save"/><?php

			foreach($this->scheduledImages as $scheduledImage){ 
			?><div class="scheduledImage">
				<div class="nav">
					<span class="dates">
						<label for="starts">Live Date</label>
						<input type="date" name="starts" required class="date" value="<?php echo $scheduledImage->starts ?>" />
					</span>
					<div class="close"></div>
					<input type="button" class="delete" value="delete" />
				</div>
				<div class="images">
					<div class="edit">
						<div class="uri_input">
							<label for="flash_uri">Sliver Background URI</label>
							<input type="url" required name="flash_uri" value="<?php echo $scheduledImage->flash_uri ?>" placeholder="eg. http://cdn.assets.gorillanation.com/paul/sliver/paul_mar_18.jpg"/>
						</div>
						<div class="uri_input">
							<label for="actionbar_uri">Action Bar Background URI</label>
							<input type="url" required name="actionbar_uri" value="<?php echo $scheduledImage->actionbar_uri ?>" placeholder="eg. http://cdn.assets.gorillanation.com/paul/sliver/paul_mar_18.jpg" />
						</div>
						<a href="#" class="update_link">update</a>
					</div>
					<label>Sliver Background URI</label>
					<img class="flash" src="<?php echo $scheduledImage->flash_uri ?>" alt="sliver image"/>
					<label>Action Bar Background URI</label>
					<img class="actionbar" src="<?php echo $scheduledImage->actionbar_uri ?>" alt="actionbar image" />
				</div>
				<input type="hidden" name="id" value="<?php echo $scheduledImage->id; ?>" />
			</div>
			<?php }
			$areImages = count($this->scheduledImages) > 0;?>
			<div class="addScheduledImage<?php if(!$areImages) echo ' solo'; ?>">
				<h3>Add Scheduled Background</h3>
				<div class="nav">
					<span title="Date on which this set of backgrounds is first displayed."><label for="starts">Live Date</label><input type="date" required name="starts" class="validate[required,date] date" id="starts" /></span>
				</div>
				<div class="images">
					<div class="flash">
						<div class="edit">
							<div class="uri_input" title="The upper (larger) section will have this as a background."><label for="flash_uri">Sliver Background URI (top)</label><input class="validate[required]" type="url" required name="flash_uri" id="flash_uri" placeholder="eg. http://cdn.assets.gorillanation.com/paul/sliver/paul_mar_18.jpg"/></div>
						</div>
					</div>
					<div class="actionbar">
						<div class="edit">
							<div class="uri_input" title="The lower (thinner) section will have this as a background."><label for="actionbar_uri">Action Bar Background URI (bottom)</label><input class="validate[required]" type="url" required name="actionbar_uri" id="actionbar_uri" placeholder="eg. http://cdn.assets.gorillanation.com/paul/sliver/paul_mar_18.jpg" /></div>
						</div>
					</div>
				</div>
				<input type="submit" name="submitx" value="Create" id="addScheduledImageSubmit"/>
			</div>
		</fieldset>
	</div>
<?php } ?>
</form>
