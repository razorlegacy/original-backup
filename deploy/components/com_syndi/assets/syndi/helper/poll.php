<!DOCTYPE HTML>
<?php
	$host			= $_SERVER['HTTP_HOST'];
	$poll_id		= $_GET['poll_id'];
	$standalone		= $_GET['standalone'];
?>
<html>
	<head>
		<script type="text/javascript">
			window.onload = function() {
			    if (parent) {
			        var oHead = document.getElementsByTagName("head")[0];
			        var arrStyleSheets = parent.document.getElementsByTagName("style");
			        for (var i = 0; i < arrStyleSheets.length; i++)
			            oHead.appendChild(arrStyleSheets[i].cloneNode(true));
			    }
			}
		</script>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi_iframe.min.css" />
		<?php
		if($standalone) {
		?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi_standalone.css" />
		<?php
		}
		?>
	</head>
	<body id="emcSyndi_iframe">
		<script type="text/javascript" charset="utf-8" src="http://static.polldaddy.com/p/<?php echo $poll_id;?>.js"></script>
	</body>
</html>