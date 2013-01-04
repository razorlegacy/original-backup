<?php
        $document       =& JFactory::getDocument();
        //$document->setMimeEncoding('application/json');
        $server         = "http://".$_SERVER['HTTP_HOST'];

        $config					= json_decode($this->syndi->config);
        $config->sid			= $this->syndi->sid;
        $config->syndi_name		= $this->syndi->syndi_name;
        $config->syndi_bg		= $this->syndi->syndi_bg;
        		
		$json		= array(
						"config"=>$config,
						"tabs"=>$this->syndiModel->loadTabsJSON($this->syndi->sid)
						);
		echo json_encode($json);
?>