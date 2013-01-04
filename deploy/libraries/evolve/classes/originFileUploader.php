<?php
/*
 * jQuery File Upload Plugin PHP Example 5.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);

class UploadHandler
{
    private $options;
    function __construct($options=null) {
        $this->options = array(
            //'upload_dir' => dirname(__FILE__).'/files/',
            //'upload_url' => $this->getFullUrl().'/files/',
            'upload_dir' => $_SERVER["DOCUMENT_ROOT"].$_POST['uploadDir'],
            'upload_url' => $_SERVER["DOCUMENT_ROOT"].$_POST['uploadDir'],
            'param_name' => 'files',
        );
	}
	function getFullUrl() {
      	return
        		(isset($_SERVER['HTTPS']) ? 'https://' : 'http://').
        		(isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
        		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
        		(isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] === 443 ||
        		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
        		substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
    
    private function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'].$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'].rawurlencode($file->name);
			return $file;
        }
        return null;
    }
    
    private function get_file_objects() {
        return array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            scandir($this->options['upload_dir'])
        )));
    }

    private function trim_file_name($name, $type) {
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.'.$matches[1];
        }
        return $file_name;
    }
	
    private function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
		$file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        if ($file->name) {
            $file_path = $this->options['upload_dir'].$file->name;
            clearstatcache();
			move_uploaded_file($uploaded_file, $file_path);
            $file_size = filesize($file_path);
            $file->size = $file_size;
        } else {
            $file->error = $error;
        }
        return $file;
    }

    public function post() {
		$upload_handler = new UploadHandler();
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
		if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
				//$upload['name'][$index] = $upload_handler->renameFile($upload['name'][$index]);
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],$upload['name'][$index],$upload['size'][$index],$upload['type'][$index],$upload['error'][$index]
				);
			}
        }
		header('Vary: Accept');
        $json = json_encode($info);
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
		echo $json;
    }
}

$upload_handler = new UploadHandler();
header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':
		$upload_handler->post();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}