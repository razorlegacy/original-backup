<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$assets		= "{$_SERVER['DOCUMENT_ROOT']}/assets/components/com_emc_origin/{$this->id}/";
	$json		= array();
	$directorySize	= '';
	$directory	= new RecursiveDirectoryIterator($assets);
	$i=0;
	foreach(new RecursiveIteratorIterator($directory) as $filepath=>$fileObj) {
		//array_push($json['files'], $fileObj->getFilename());
		list($width, $height)		= getimagesize($fileObj);
		$json['files'][$i]['name']	= $fileObj->getFilename();
		$json['files'][$i]['type']	= pathinfo($filepath, PATHINFO_EXTENSION);
		$json['files'][$i]['width']	= $width;
		$json['files'][$i]['height']= $height;
		$directorySize += $fileObj->getSize();
		$i++;
		//echo pathinfo($filepath, PATHINFO_EXTENSION);
	}
	
	$json['totalSize']	= $directorySize/1000;
	echo json_encode($json);
	//print_r($json);
?>