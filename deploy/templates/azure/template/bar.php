<div id="originBar-wrapper">
	<div id="originBar">
		<a href="/<?php if(isset($user)) echo 'administrator';?>" id="bar-logo" class="originButton">Origin</a>
		<?php if(isset($user)) {?>
			<a href="#" id="originBar-settings" class="originButton">Settings</a>
			<div class="azure-hidden">
				<div id="originBar-settings-content">
					<ul class="originList">
						<li id="bar-settings-users"><a href="/administrator/index.php?option=com_users" class="azure-cta">User Manager</a></li>
						<?php if ($acl->checkACL(1)) { ?>
						<li id="bar-settings-advanced" class="">
							<a href="#" id="bar-advanced-toggle" class="azure-cta">Settings</a>
							<ul class="originList azure-hidden">
								<li><a href="/administrator/index.php?option=com_config" class="azure-cta">Configuration</a></li>
								<li><a href="/administrator/index.php?option=com_installer" class="azure-cta">Installer</a></li>
								<li><a href="/administrator/index.php?option=com_modules&client=1" class="azure-cta">Modules</a></li>
								<li><a href="/administrator/index.php?option=com_plugins" class="azure-cta">Plugins</a></li>
								<li><a href="/administrator/index.php?option=com_templates" class="azure-cta">Templates</a></li>
							</ul>
						</li>
						<?php }//end super-admin settings ?>
						<li id="bar-settings-logout"><a href="/administrator/index.php?option=com_login&task=logout" class="azure-cta">Logout</a></li>
					</ul>
				</div>
			</div>
		<?php } else { ?>
			<a href="#" id="originBar-login" class="originButton">Login</a>
			<div class="originUI-hidden">
				<iframe id="originBar-login-content" src="" data-src="/administrator/?iframe=true" frameborder="0" scrolling="no"></iframe>	
			</div>
		<?php } ?>
	</div>
</div>