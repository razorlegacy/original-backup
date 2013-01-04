<?php // no direct access
defined('_JEXEC') or die('Restricted access');
	function h($content) {
		echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
	}
?><!--[if lte IE 8]><link href="/administrator/components/com_slivers/css/ie.css" rel="stylesheet" type="text/css" /><![endif]--><?php
	echo $this->nav->getNav();
?><form action="index.php" method="post" name="adminForm" id="finalform">
	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" id="option"/>
	<input type="hidden" name="task" value="save"/>
	<input type="hidden" id="sliver_id" name="sliver_id" value="<?php echo $this->sliver_id; ?>"/>
	<input type="hidden" name="cid[]" value="<?php echo $this->sliver_id; ?>"/>
	<h2>Sliver Built!</h2>
	<p style="font-size: 14pt">Ok you're done. Now just copy the link below and send it to trafficking. If you have a single click through just send that link and tell them to use it as the click tag. If you have more than one send all of them and ask them to set one of them as the click tag (you will use this as your "dfp link") and send back click tags for the rest. You can put these in as "raw links".</p>
	<p><label>Send to Trafficking: </label><a href="<?php h($this->embed_link); ?>"><?php echo $this->embed_link ?></a></p>
	<p style="font-size: 14pt">Google Analytics for this unit are stored in the Sliver unit GA ID. Categories refer to the campaign name, actions to the type of action eg. click-out, open sliver, etc. Labels contain the button name you provided.</p>
	<p style="font-size: 14pt">Video Analytics are handled by springboard and can be obtained through them.</p>
</form>
