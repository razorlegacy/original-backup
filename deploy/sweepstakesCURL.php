<?php

/*
if($_POST) {
	//$url	= "http://webservices.evolvemediacorp.com/index.php?option=com_sweepstakes&view=xml&format=raw&sid=20";
	$url	= "http://{$_SERVER['SERVER_NAME']}/index.php?format=raw";
	$entry	= array();
	foreach($_POST as $key=>$value) {
		$entry[$key]	= urlencode($value);
	}
	
	$ch		= curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $entry);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$result	= curl_exec($ch);
	curl_close($ch);	

	print_r($result);
}
*/

?>
<html>
	<head>
		<title>Sweepstakes Test</title>
	</head>
	<body>



<form action="http://webservices.evolvemediacorp.com/index.php?format=raw" method='POST'>
<ul>
<li><label>E-mail</label><input type='text' name='text_0'/></li>
</ul>
<input type='hidden' name='option' value='com_sweepstakes'/>
<input type='hidden' name='controller' value='sweepstakes'/>
<input type='hidden' name='task' value='entrant_save'/>
<input type='hidden' name='sid' value='21' />
<input type='submit' name='submit' value='Submit'/>
</form>
		
	</body>
</html>