<!DOCTYPE HTML>
<?php
	$this->_addPath( 'template', JPATH_COMPONENT_SITE . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	
	$host			= $_SERVER['HTTP_HOST'];
	if($_GET['id'] && isset($_GET['debug'])) {
			$debug			= $_GET['debug'];
	}
	$configObj	= json_decode($this->cartographerObj['config']->content);
?>
<html>
	<head>
		<title><?php echo $configObj->name;?></title>
		<?php
		if(isset($debug)) {
		?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_emc_cartographer/assets/css/emcCartographer.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_emc_cartographer/assets/js/emcCartographer.js"></script>
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_emc_cartographer/assets/js/emcCartographer-dev.js"></script>
		<?php
		} else {
		?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_emc_cartographer/assets/css/emcCartographer.min.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_emc_cartographer/assets/js/emcCartographer.min.js"></script>
		<?php
		}
		?>
		<!--[if LT IE 9]><link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_emc_cartographer/assets/css/emcCartographer-ie.css" /><![endif]-->
		
		<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/index.php?option=com_emc_cartographer&view=template&layout=css&format=raw&id=<?php echo $configObj->id;?>" />
		<?php
			//$this->assignRef('cartographerObj', $this->cartographerObj);
			//$this->setLayout('css');
			//echo $this->loadTemplate();
		?>
		<script type="text/javascript">
			var $j				= jQuery.noConflict();
			<?php
			if($configObj->ga) {
			?>
				var emcCartographer_name='<?php echo $configObj->name;?>';var emcCartographer_id='<?php echo $configObj->id;?>'; 
				var _gaq=_gaq||[];_gaq.push(["_setAccount","<?php echo $configObj->ga;?>"]);_gaq.push(["_trackPageview"]);var ga=document.createElement("script");ga.type="text/javascript";ga.async=!0;ga.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(ga,s);
			<?php 
			}
			?>
			var cartographerMarkerTrigger	= '<?php echo $configObj->tooltip_trigger;?>';
			$j(function() {
				emcCartographer.init();
 			});
		</script>
	</head>
	<body id="emcCartographer_main">
		<?php
			if(sizeof($this->cartographerObj['groups'])>1) {
			?>
			<ul id="emcCartographer_group_list">
				<?php
				foreach($this->cartographerObj['groups'] as $key=>$value) {
				?>
						<li class="" data-id="<?php echo $value->id;?>" data-group="emcCartographer_group_<?php echo $value->id;?>">
							<a href="#" id="emcCartographer_group_link_<?php echo $value->id;?>" >Group_<?php echo $value->id;?></a>
						</li>
				<?php
				}
				?>
			</ul>
			<?php
			}
		?>
		<div id="emcCartographer_wrapper" class="">
			<?php
				for($i=0; $i < sizeof($this->cartographerObj['groups']); $i++) {
				?>
				<div id="emcCartographer_group_<?php echo $this->cartographerObj['groups'][$i]->id;?>" class="emcCartographer_group" style="<?php if($i>0) echo 'display: none';?>">
				<?php
					$this->assignRef('configObj', $configObj);
					$this->assignRef('groupObj', $this->cartographerObj['groups'][$i]);
					$this->setLayout('group');
					echo $this->loadTemplate();
				?>
				</div>
				<?php
				}
			?>
		</div>
	</body>
</html>