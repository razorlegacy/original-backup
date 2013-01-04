<?php $settingsStyle	=  ($acl->checkACL(1))? " azure-admin": " azure-manager"; ?>

<h1>home</h1>
<div id="origin-home">
	<div id="content-left" class="originTiles">
		<div id="activity">
			<span class="originTiles-title">Activity&nbsp;</span>
			<jdoc:include type="modules" name="home_activity"/>
		</div>
	</div><!--
	--><div id="content-center" class="originTiles">
		<a href="/administrator/index.php?option=com_emc_origin" id="creator" class="originTiles">
			<img src="/templates/azure/images/tile-creator.png" class="originTiles-thumbnail"/>
			<span class="originTiles-title originUI-bg">origin ad creator</span>
		</a>
		<div id="analytics" class="originTiles">
			<img src="/templates/azure/images/tile-analytics.png" class="originTiles-thumbnail"/>
			<span class="originTiles-title originUI-bg">coming soon</span>
		</div>
	</div><!--
	--><div id="content-right" class="originTiles">
			<h3>Legacy Apps</h3>
			<div id="apps">
				<a href="/administrator/index.php?option=com_emc_cartographer" id="" class="originTiles">
					<img src="/templates/azure/images/tile-cartographer.png" class="originTiles-thumbnail"/>
					<span class="originTiles-title originUI-bg">cartographer</span>
				</a>
				<a href="/administrator/index.php?option=com_orochi" id="" class="originTiles">
					<img src="/templates/azure/images/tile-syndi.png" class="originTiles-thumbnail"/>
					<span class="originTiles-title originUI-bg">syndi</span>
				</a>
				<a href="/administrator/index.php?option=com_giftguides" id="" class="originTiles">
					<img src="/templates/azure/images/tile-giftguide.png" class="originTiles-thumbnail"/>
					<span class="originTiles-title originUI-bg">gift guide</span>
				</a>
				<a href="/administrator/index.php?option=com_sweepstakes" id="" class="originTiles">
					<img src="/templates/azure/images/tile-sweepstakes.png" class="originTiles-thumbnail"/>
					<span class="originTiles-title originUI-bg">sweepstakes</span>
				</a>
			</div>
		</div>
</div>