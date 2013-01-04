<style>
body {
  text-align: center;
  padding-top: 1em; 
  padding-left: 1em; 
  background-color: #000000; 
  color: #C0C0C0;
} 
 
pre.flf, pre.txt, pre.figlet {
  font-size: 10pt;
  font-family: monospace;
} 
</style>

<pre class="flf">     _____                                                                                          
  __|___  |__  ____    _____    __    _____  ______  _____   ____    _____  __   _  ______  _____   
 |   ___|    ||    \  |     | _|  |_ /     \|   ___||     | |    \  |     ||  |_| ||   ___||     |  
 |   |__     ||     \ |     \|_    _||     ||   |  ||     \ |     \ |    _||   _  ||   ___||     \  
 |______|  __||__|\__\|__|\__\ |__|  \_____/|______||__|\__\|__|\__\|___|  |__| |_||______||__|\__\ 
    |_____|                                                                                         
                                                                                                    </pre>            

																									<pre class="flf">    )                                                                                      
 ( /(          )                    )   (  `                                             )  
 )\())      ( /(                 ( /(   )\))(      )                  (   (      )    ( /(  
((_)\   (   )\())(   `  )    (   )\()) ((_)()\  ( /(  `  )   `  )    ))\  )(    /((   )(_)) 
 _((_)  )\ (_))/ )\  /(/(    )\ (_))/  (_()((_) )(_)) /(/(   /(/(   /((_)(()\  (_))\ ((_)   
| || | ((_)| |_ ((_)((_)_\  ((_)| |_   |  \/  |((_)_ ((_)_\ ((_)_\ (_))   ((_) _)((_)|_  )  
| __ |/ _ \|  _|(_-&lt;| '_ \)/ _ \|  _|  | |\/| |/ _` || '_ \)| '_ \)/ -_) | '_| \ V /  / /   
|_||_|\___/ \__|/__/| .__/ \___/ \__|  |_|  |_|\__,_|| .__/ | .__/ \___| |_|    \_/  /___|  
                    |_|                              |_|    |_|                             </pre>	
<pre class="flf">                                                  (                             
 (  `                            )                  )\ )                       )  
 )\))(   (   (  (  (       )  ( /( (               (()/(     (   (          ( /(  
((_)()\  )\  )\))( )(   ( /(  )\()))\   (    (      /(_)) (  )(  )\  `  )   )\()) 
(_()((_)((_)((_))\(()\  )(_))(_))/((_)  )\   )\ )  (_))   )\(()\((_) /(/(  (_))/  
|  \/  | (_) (()(_)((_)((_)_ | |_  (_) ((_) _(_/(  / __| ((_)((_)(_)((_)_\ | |_   
| |\/| | | |/ _` || '_|/ _` ||  _| | |/ _ \| ' \)) \__ \/ _|| '_|| || '_ \)|  _|  
|_|  |_| |_|\__, ||_|  \__,_| \__| |_|\___/|_||_|  |___/\__||_|  |_|| .__/  \__|  
            |___/                                                   |_|           </pre>
							
<?php
echo "<br>---------------------------------------------------------------------------<br>";
echo "|     Migration script from old Pebblebed Hotspot version to new     |";
echo "<br>---------------------------------------------------------------------------<br>";

//CONNECTION
		$user = "joomla";
		$password = "gieP4gae";
		$db="webservices_cartographer";
		$con = mysql_connect("localhost",$user,$password);
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		@mysql_select_db($db) or die( "Unable to select database");


//SAVE ROW TO #_emc_cartographer
$query = "SELECT * FROM jos_hotspot_campaigns";
$result = mysql_query($query);
$cartographer_count = 0;
$style = isset($_GET['style'])? $_GET['style']:'default';

echo "<br>...-----------------------------------------...<br>";
echo "<br>...start migrating...<br>";
while($row = mysql_fetch_array($result))
 {
	$contentJSON	= array();
	$contentJSON 	= getStyle($style);	
	$contentJSON['name']						=  str_replace("'","''",$row['title']);
	$contentJSON['ga']							= 'UA-12310597-3';
	$contentJSON['tooltip_trigger']		= 'click';
	$contentJSON['css']							= '';
	$contentJSON['icon']						= $row['default_icon'];
	$contentJSON['icon_hover']			= '';
	$content = json_encode($contentJSON);

	$query_cartographer = "INSERT INTO websvc_emc_cartographer (id,name,content,manager,modified_by,timestamp,published) 
										VALUES (".$row['id'].",'".$contentJSON['name']."','".$content."','',NULL,'".$row['created']."','".$row['published']."')";
										
	$cartographer_result = mysql_query($query_cartographer);
	if (!$cartographer_result) {
			echo '... [ Could not query cartographer: ' . mysql_error() .' ] ...';
	}
	echo "<br>...-----------------------------------------...<br>";
	echo "...cartographer #".$cartographer_count."...<br>";
	
	//CREATE DEFAULT GROUP
	$groupJSON = array();
	$groupJSON = getImagesPath($row['id'],$row['background'],"campaign");
	$content_group = json_encode($groupJSON);
	$query_group = "INSERT INTO websvc_emc_cartographer_groups (id,cid,content,ordering)
							VALUES('','".$row['id']."','".$content_group."',NULL)";
	$group_result = mysql_query($query_group);
	
	if (!$group_result) {
		echo '... [ Could not query group: ' . mysql_error() .' ] ...<br>';
	}
	
	$select_group = "SELECT id FROM websvc_emc_cartographer_groups where cid=".$row['id'];
	$group = mysql_fetch_array(mysql_query($select_group));
	
	echo "...cartographer group #".$cartographer_count."...<br>";
	
	//SAVE POINTS
	$query = "SELECT * FROM jos_hotspot_points WHERE cid=".$row['id'];
	$points = mysql_query($query);
	$marker_count=0;
	while($point = mysql_fetch_array($points))
	{
		$pointJSON = array();
		$pointJSON = getImagesPath($row['id'],$point['icon'],"point");
		$pointJSON['title'] = str_replace("'","''",$point['title']);
		$pointJSON['content'] = str_replace("'","''",$point['description']);
		//$pointJSON['icon'] = $point['icon'];
		$content_point = json_encode($pointJSON);
		
		$coordinatesJSON = array();
		$coordinatesJSON['coordX'] = $point['x'];
		$coordinatesJSON['coordY'] = $point['y'];
		$coordinates = json_encode($coordinatesJSON);
		$query_point = "INSERT INTO websvc_emc_cartographer_markers (id,cid,gid,content,coordinates)
								VALUES(".$point['pid'].",".$point['cid'].",".$group['id'].",'".$content_point."','".$coordinates."')";
		$point_result = mysql_query($query_point);
		
		if (!$point_result) {
			echo '... [ Could not query marker: ' . mysql_error() .' ] ...<br>';
		}
	
		echo "...cartographer marker #".$marker_count."...<br>";
		$marker_count++;
	}
	$cartographer_count++;
 }
 
echo "..........";

//Get the correct tooltip's styles
function getStyle($style) {
	$styles	= array();
	switch($style) {
		case 'thefashionspot' :
				$styles['tooltip_style']				= 'thefashionspot';
				$styles['popup_border_hex']	= '#83618D';
				$styles['popup_bg_hex']			= '#FFFFFF';
				$styles['popup_title_hex']		= '#688F93';
				$styles['popup_text_hex']		= '#535859';
				$styles['popup_link_hex']		= '#83618D';
				break;
		case 'craveonline':
				$styles['tooltip_style']				= 'craveonline';
				$styles['popup_border_hex']	= '#000000';
				$styles['popup_bg_hex']			= '#4579C5';
				$styles['popup_title_hex']		= '#FFFFFF';
				$styles['popup_text_hex']		= '#FFFFFF';
				$styles['popup_link_hex']		= '#FFFFFF';
				break;
		case 'momtastic':
				$styles['tooltip_style']				= 'momtastic';
				$styles['popup_border_hex']	= '#FFFFFF';
				$styles['popup_bg_hex']			= '#D4DEE3';
				$styles['popup_title_hex']		= '#0B386C';
				$styles['popup_text_hex']		= '#000000';
				$styles['popup_link_hex']		= '#000000';
				break;
		case 'ringtv':
				$styles['tooltip_style']				= 'ringtv';
				$styles['popup_border_hex']	= '#F4F4F4';
				$styles['popup_bg_hex']			= '#F4F4F4';
				$styles['popup_title_hex']		= '#870D0C';
				$styles['popup_text_hex']		= '#000000';
				$styles['popup_link_hex']		= '#870D0C';
				break;
		case 'superherohype':
				$styles['tooltip_style']				= 'superherohype';
				$styles['popup_border_hex']	= '#FFFFFF';
				$styles['popup_bg_hex']			= '#FFFFFF';
				$styles['popup_title_hex']		= '#0C386C';
				$styles['popup_text_hex']		= '#000000';
				$styles['popup_link_hex']		= '#0C386C';
				break;
		case 'wrestlezone':
				$styles['tooltip_style']				= 'wrestlezone';
				$styles['popup_border_hex']	= '#CCCCCC';
				$styles['popup_bg_hex']			= '#191919';
				$styles['popup_title_hex']		= '#FFFFFF';
				$styles['popup_text_hex']		= '#FFFFFF';
				$styles['popup_link_hex']		= '#C65200';
				break;
		default:
				$styles['tooltip_style']				= 'custom';
				$styles['popup_border_hex']	= '#FFFFFF';
				$styles['popup_bg_hex']			= '#FFFFFF';
				$styles['popup_title_hex']		= '#000000';
				$styles['popup_text_hex']		= '#000000';
				$styles['popup_link_hex']		= '#000000';

	}

	return $styles;
}

//Move the new images path
function getImagesPath($id, $path, $type) {
	$paths	= array();
	$path = substr($path,1);
	if(file_exists($path)) {
		//move the file to the standard cartographer structure
		$pathCartographer = createAssetsFolder($id);
		
		$pathCartographer = $pathCartographer.'/'.basename($path);
			
		rename($path, $pathCartographer);
		
		if($type=="campaign") {
			$paths['uploadDir'] = dirname($pathCartographer).'/';
			$paths['bg_img'] = basename($pathCartographer); 
			list($width, $height) = getimagesize($pathCartographer);
			$paths['bg_width'] = $width;
			$paths['bg_height'] = $height;
		}
		else {
			$paths['icon'] = basename($pathCartographer);
		}
	}
		
	return $paths;
}
		
//Create assets folder
function createAssetsFolder($id) {
	$dir	= "assets/components/com_emc_cartographer/{$id}";
			
	if(!is_dir($dir)) {
		mkdir($dir, 0777, true);
		//return $dir;
	}
	return $dir;
}