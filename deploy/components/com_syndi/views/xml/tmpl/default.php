<?php
        $document       =& JFactory::getDocument();
        $document->setMimeEncoding('text/xml');
        $server         = "http://".$_SERVER['HTTP_HOST'];
       
        $output         = '';
        $output         .= '<?xml version="1.0" encoding="UTF-8"?>';
        $output                 .= "<data>";
        $output                         .= "<config>";
        $output                                 .= "<name>{$this->syndi->name}</name>";
        $output                         .= "</config>";
		$output                         .= "<header_link>{$this->syndi->headerUrl}</header_link>";
		$output                         .= "<articles>";
		
		foreach( $this->syndiTabs as $tab ) {
			switch($tab) {
				case 'article' :   $syndiArticles        = $this->syndiModel->loadArticles();
										break;
										
				case 'image':	$syndiImages		= $this->syndiModel->loadImages();
										break;
										
				case 'qa':			$syndiQas				= $this->syndiModel->loadQas();
										break;
					
				case 'video':		$syndiVideos			= $this->syndiModel->loadVideos();
										break;
			}
		
		
		}
		if($syndiArticles) {
			foreach($syndiArticles as $article) {
					$output                         .= "<article id='{$article->article_id}' alias='{$article->alias}' tab='{$article->tab_id}'>";
					$output                                 .= "<title><![CDATA[{$article->title}]]></title>";
					$output                                 .= "<content><![CDATA[{$article->content}]]></content>";
					$output                                 .= "<url><![CDATA[{$article->articleURL}]]></url>";
					$output                                 .= "<image><![CDATA[$server{$article->image}]]></image>";
					$output                         .= "</article>";
			}
        }
		$output  						.= "</articles>";
		
		$output                         .= "<images>";
		if($syndiImages) {
			foreach($syndiImages as $image) {
                    $output                         .= "<image id='{$image->image_id}' tab='{$image->tab_id}'>";
                    $output                                 .= "<image><![CDATA[$server{$image->image}]]></image>";
					$output                                 .= "<click_through_url><![CDATA[{$image->clickURL}]]></click_through_url>";
                    $output                         .= "</image>";
            }
		}
        $output                         .= "</images>";
		
		$output                         .= "<qas>";
		if($syndiQas) {
			foreach($syndiQas as $qa) {
                    $output                         .= "<qa id='{$qa->qa_id}' tab='{$qa->tab_id}'>";
                    $output                                 .= "<question><![CDATA[{$qa->question}]]></question>";
					$output                                 .= "<answer><![CDATA[{$qa->answer}]]></answer>";
                    $output                         .= "</qa>";
            }
		}
        $output                         .= "</qas>";
		
		$output                         .= "<videos>";
		if($syndiVideos) {
			foreach($syndiVideos as $video) {
                    $output                         .= "<video id='{$video->video_id}' tab='{$video->tab_id}'>";
                    $output                                 .= "<video_clip><![CDATA[{$video->videoURL}]]></video_clip>";
					$output                                 .= "<screen_shot><![CDATA[{$video->screenURL}]]></screen_shot>";
                    $output                         .= "</video>";
            }
		}
        $output                         .= "</videos>";
		
        $output                 .= "</data>";
       
        echo $output;
?>