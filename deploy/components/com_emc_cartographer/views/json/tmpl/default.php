<?php
        $document       =& JFactory::getDocument();
		$document->setMimeEncoding('application/json');
		
		echo json_encode($this->cartographerObj);
?>