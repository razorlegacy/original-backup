<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$db = JFactory::getDBO();
$db->setQuery('SELECT params from #__menu WHERE id LIKE "'.$_GET['Itemid'].'"');
$result = $db->loadAssoc();
if ($result === null) {
    JError::raiseError(500, 'Error reading db');
} 
$cid = $_GET['cid'];
//print_r($cid);
?>
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="700" height="700">
  <param name="movie" value="/components/com_bracket/views/bracket/tmpl/bracket.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="opaque" />
  <param name="swfversion" value="6.0.65.0" />
  <param name="flashvars" value="cid=<?php echo $cid; ?>" />
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you donÕt want users to see the prompt. -->
  <!-- <param name="expressinstall" value="js/expressInstall.swf" /> -->
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="/components/com_bracket/views/bracket/tmpl/bracket.swf" width="700" height="700">
      <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="6.0.65.0" />
    <!-- <param name="expressinstall" value="js/expressInstall.swf" /> -->
    <param name="flashvars" value="cid=<?php echo $cid; ?>" />
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
</div>