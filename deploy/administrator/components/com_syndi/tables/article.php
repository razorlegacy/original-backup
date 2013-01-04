<?php

    defined('_JEXEC') or die('Restricted Access');

    class TableArticle extends JTable {
           public $article_id 	= null;
		   public $articleURL  	= null;
		   public $timestamp 	= null;
           public $title 		= null;
		   public $alias		= null;
		   public $image 		= null;
		   public $content		= null;
		   public $tab_id      	= null;
		   public $ordering		= null;

          
           function __construct(&$db){
                 parent::__construct('#__syndi_article', 'article_id', $db);
           }
    }
?>