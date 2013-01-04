<?php
        $document       =& JFactory::getDocument();
        //$document->setMimeEncoding('application/json');
        $server         = "http://".$_SERVER['HTTP_HOST'];

        $config			= json_decode($this->orochi->content);
        $config->id	= $this->orochi->id;
		$config->title = $this->orochi->title;
		
		$json		= array(
						"config"=>$config,
						"data"=>$this->orochiModel->loadMenuJSON($this->orochi->id)
						//"groups"=>$this->orochiModel->loadGroupsJSON($this->orochi->id)
						);
						
		echo json_encode($json);
?>