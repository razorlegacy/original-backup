<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	//$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'User' ) . ' Manager' , 'user.png' );
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Cancel' );
	} else {
		JToolBarHelper::cancel();
	}
	//JToolBarHelper::apply();
	JToolBarHelper::save();
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $this->user, ENT_QUOTES, '' );

	if ($this->user->get('lastvisitDate') == "0000-00-00 00:00:00") {
		$lvisit = JText::_( 'Never' );
	} else {
		$lvisit	= JHTML::_('date', $this->user->get('lastvisitDate'), '%Y-%m-%d %H:%M:%S');
	}
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");

		// do field validation
		if (trim(form.name.value) == "") {
			alert( "<?php echo JText::_( 'You must provide a name.', true ); ?>" );
		} else if (form.username.value == "") {
			alert( "<?php echo JText::_( 'You must provide a user login name.', true ); ?>" );
		} else if (r.exec(form.username.value) || form.username.value.length < 2) {
			alert( "<?php echo JText::_( 'WARNLOGININVALID', true ); ?>" );
		} else if (trim(form.email.value) == "") {
			alert( "<?php echo JText::_( 'You must provide an email address.', true ); ?>" );
		} else if (form.gid.value == "") {
			alert( "<?php echo JText::_( 'You must assign user to a group.', true ); ?>" );
		} else if (((trim(form.password.value) != "") || (trim(form.password2.value) != "")) && (form.password.value != form.password2.value)){
			alert( "<?php echo JText::_( 'Password do not match.', true ); ?>" );
		} else if (form.gid.value == "29") {
			alert( "<?php echo JText::_( 'WARNSELECTPF', true ); ?>" );
		} else if (form.gid.value == "30") {
			alert( "<?php echo JText::_( 'WARNSELECTPB', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}

	function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}
</script>
<div id="azure-user">
	<form action="index.php" method="post" name="adminForm" autocomplete="off">
		<div id="originUsers-stock" class="originTiles"></div><!--
		--><div id="originUsers-form" class="originTiles adminform originForm originUI-bg">
				<table class="admintable" cellspacing="1">
					<tr>
						<td width="150" class="key">
							<input type="text" name="name" id="name" class="inputbox" size="40" value="<?php echo $this->user->get('name'); ?>" placeholder="<?php echo JText::_( 'Name' ); ?>"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<input type="text" name="username" id="username" class="inputbox" size="40" value="<?php echo $this->user->get('username'); ?>" autocomplete="off" placeholder="<?php echo JText::_( 'Username' ); ?>"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<input class="inputbox" type="text" name="email" id="email" size="40" value="<?php echo $this->user->get('email'); ?>" placeholder="<?php echo JText::_( 'Email' ); ?>"/>
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php if(!$this->user->get('password')) : ?>
								<input class="inputbox disabled" type="password" name="password" id="password" size="40" value="" disabled="disabled" placeholder="<?php echo JText::_( 'New Password' ); ?>"/>
							<?php else : ?>
								<input class="inputbox" type="password" name="password" id="password" size="40" value="" placeholder="<?php echo JText::_( 'New Password' ); ?>"/>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php if(!$this->user->get('password')) : ?>
								<input class="inputbox disabled" type="password" name="password2" id="password2" size="40" value="" disabled="disabled" placeholder="<?php echo JText::_( 'Verify Password' ); ?>"/>
							<?php else : ?>
								<input class="inputbox" type="password" name="password2" id="password2" size="40" value="" placeholder="<?php echo JText::_( 'Verify Password' ); ?>"/>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="gid">
								<?php echo JText::_( 'Group' ); ?>
							</label>
							<?php echo $this->lists['gid']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php if ($this->me->authorize( 'com_users', 'block user' )) { ?>
							<?php echo JText::_( 'Block User' ); ?>
							<?php echo $this->lists['block']; ?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<?php } if ($this->me->authorize( 'com_users', 'email_events' )) { ?>
							<?php echo JText::_( 'Receive System Emails' ); ?>
							<?php echo $this->lists['sendEmail']; ?>
						</td>
					</tr>
					<?php } if( $this->user->get('id') ) { ?>
					<tr class="originUI-hidden">
						<td class="key">
							<?php echo JText::_( 'Register Date' ).' '.JHTML::_('date', $this->user->get('registerDate'), '%Y-%m-%d %H:%M:%S') ?>
						</td>
					</tr>
					<tr class="originUI-hidden">
						<td class="key">
							<?php echo JText::_( 'Last Visit Date' ).' '.$lvisit; ?>
						</td>
					</tr>
					<?php } ?>
				</table>
		</div>
		<div id="originUsers-params" class="originUI-hidden">
			<?php
				$params = $this->user->getParameters(true);
				echo $params->render( 'params' );
			?>
		</div>
		
		<input type="hidden" name="id" value="<?php echo $this->user->get('id'); ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $this->user->get('id'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="contact_id" value="" />
		<?php if (!$this->me->authorize( 'com_users', 'email_events' )) { ?>
		<input type="hidden" name="sendEmail" value="0" />
		<?php } ?>
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>