	<?php
	if($error = JError::getError(true)) {
		echo '<p id="login-error-message">';
		echo $error->get('message');
		echo '</p>';
	}
	?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" style="clear: both;">
	<p id="form-login-username">
		<!-- <label for="modlgn_username"><?php echo JText::_('Username'); ?></label> -->
		<input name="username" id="modlgn_username" type="text" class="inputbox" size="15" placeholder="<?php echo JText::_('Username'); ?>"/>
	</p>

	<p id="form-login-password">
		<!-- <label for="modlgn_passwd"><?php echo JText::_('Password'); ?></label> -->
		<input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" placeholder="<?php echo JText::_('Password'); ?>"/>
	</p>
	
	<div id="azure-login-buttons">
		<div id="azure-login-reset" class="originButton originButton-iconCancel">
			<input type="reset" value=""/>
			<span><?php echo JText::_( 'Reset' );?></span>
		</div>
		
		<div id="azure-login-submit" class="originButton originButton-iconNext">
			<input type="submit" value=""/>
			<span><?php echo JText::_( 'Login' );?></span>
		</div>
	</div>
	<input type="hidden" name="option" value="com_login" />
	<input type="hidden" name="task" value="login" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>