<?php
defined('_JEXEC') or die();
echo $_GET['jsonCB'] . '('.json_encode($this->validate).')';
?>