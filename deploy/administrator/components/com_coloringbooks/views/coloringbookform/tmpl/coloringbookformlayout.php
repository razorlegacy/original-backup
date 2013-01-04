<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
	<style>
	#imagelist { list-style-type: none; margin: 0; padding: 0; }
	#imagelist li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; }
	</style>
<div id="leftpanel" class="<?php echo $this->coloringBook->id ? 'edit' :'add' ?>">
	<form action="index.php" method="POST" name="adminForm" id="adminForm">
		<fieldset class="adminform">
				<legend>Details</legend>
				<table class="admintable">
					<tr>
						<td class="key">Coloring Book Name</td>
						<td>
							<input type="text" name="name" id="name" maxlength="255" value="<?php echo htmlspecialchars($this->coloringBook->name); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">Owner</td>
						<td>
							<select name="owner"><?php
								foreach($this->users as $user){
									?><option value="<?php echo $user->id; ?>" <?php
										if((!$this->coloringBook->owner && $user->id == $this->currentuser->id)
											||($this->coloringBook->owner == $user->id)) echo 'selected="selected"'?>><?php
											echo htmlspecialchars($user->name); 
										?></option><?php
								}
							?></select>
						</td>
					</tr>
					<tr>
						<td class="key">Embed width</td>
						<td>
							<input type="text" name="embed_width" id="embed_width" maxlength="255" value="<?php echo htmlspecialchars($this->coloringBook->embed_width); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">Embed height</td>
						<td>
							<input type="text" name="embed_height" id="embed_height" maxlength="255" value="<?php echo htmlspecialchars($this->coloringBook->embed_height); ?>" />
						</td>
					</tr>
					<tr>
						<td class="key">Flash Uri</td>
						<td>
							<input type="text" name="swf_uri" id="swf_uri" maxlength="255" value="<?php echo htmlspecialchars($this->coloringBook->swf_uri); ?>" />
						</td>
					</tr>
				</table>
				<div id="file_upload" ></div>
				<input type="button" name="preview" id="preview" value="preview" rel="#preview_overlay" />
				<input type="submit" name="submitx" value="<?php echo $this->coloringBook->id ?'update':'create'; ?>">
		</fieldset>
		<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/>
		<input type="hidden" name="id" value="<?php echo $this->coloringBook->id; ?>"/>      
		<input type="hidden" name="task" value="apply"/> 
		
	</form>
</div>
<div id="rightpanel">
	<fieldset class="adminForm">
		<legend>Pages</legend>
		<form id ="blah" action="index.php">
			<ol id="imagelist">
				<?php foreach($this->coloringBook->pages as $page){ ?>
				<li class="ui-state-default" ><?php // echo $page->id; ?>
					<img src="<?php echo htmlspecialchars($page->uri_thumb) ?>" />
					<input type="hidden" name="id[]" value="<?php echo $page->id; ?>"/>
					<a href="#" class="delete"><?php echo JHTML::image('administrator/images/publish_x.png','delete image'); ?></a>
				</li>
				<?php } ?>
			</ol>
			<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' );?>"/> 
			<input type="hidden" name="task" value="updateOrder"/>    
			<input type="hidden" name="format" value="raw"/>  
			<input type="hidden" name="cid[]" value="<?php echo $this->coloringBook->id;?>"/>  
		</form>
	</fieldset>
</div>
<div id="preview_overlay" class="overlay"><div class="overlaywrapper"></div></div>