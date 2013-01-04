<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomImages/trunk/helper.php $
// $Id: helper.php 1963 2010-03-19 14:55:13Z aha $
/**
* Module JoomImages 1.5
* by JoomGallery::Project Team
* based on module for PonyGallery ML by Benjamin Malte Meier 10/08/2007"
* @package JoomGallery
* @Copyright JoomGallery team and b2m
* @ All rights reserved
* @ Joomla Open Source is Free Stuff
* @ Released under GnuGPL License.
**/

/// no direct access
defined('_JEXEC') or die('Restricted access');

class modJoomImagesHelper extends joominterface
{

  //own class variable because db->escaped strips the ""
  var $scrollmousecode;

  /**
   * entry function
   *
   * @param object $params - backend parameters
   * @param object $modObject - interface object
   * @return object - picture objects
   */
  function fillObject(&$params,&$moduleid)
  {
    $doc = &JFactory::getDocument();

    //read the parameters
    $this->getParams($params,$moduleid);

    // if 'openbox' setted include js and css to override setting of gallery
    // avoid double include of same files, only valid in standard view
    if ($this->getConfig('openinbox')!=0 && $this->getConfig('slideshowthis')==0)
    {
      $openinbox=$this->getConfig('openinbox');
      // check if already setted in gallery
      // thickbox
      if ($openinbox == 5 && $this->_jg_config->jg_detailpic_open != 5)
      {
        $doc->addScript(_JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/thickbox3/js/jquery-latest.pack.js');
        $doc->addScript(_JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/thickbox3/js/thickbox.js');
        $doc->addStyleSheet(_JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/thickbox3/css/thickbox.css');
        $script = '
          var joomgallery_image = "'.JText::_('JGS_PICTURE',true).'";
          var joomgallery_of = "'.JText::_('JGS_OF',true).'";
          var joomgallery_close = "'.JText::_('JGS_CLOSE',true).'";
          var joomgallery_prev = "'.JText::_('JGS_PREVIOUS',true).'";
          var joomgallery_next = "'.JText::_('JGS_NEXT',true).'";
          var joomgallery_press_esc = "'.JText::_('JGS_ESC',true).'";
          var tb_pathToImage = "'._JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/thickbox3/images/loadingAnimation.gif";';
          $doc->addScriptDeclaration($script);
          $this->_jg_config->jg_detailpic_open=$this->getConfig('openinbox');
      }
      // slimbox
      else if ($openinbox == 6 && $this->_jg_config->jg_detailpic_open != 6)
      {
        // loads mootools only, if it hasn't already been loaded
        JHTML::_('behavior.mootools');
        $doc->addScript(_JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/slimbox/js/slimbox.js');
        $doc->addStyleSheet(_JOOM_LIVE_SITE.'components/com_joomgallery/assets/js/slimbox/css/slimbox.css');
        $script = '
          var resizeSpeed = '.$this->_jg_config->jg_lightbox_speed.';
          var joomgallery_image = "'.JText::_('JGS_PICTURE',true).'";
          var joomgallery_of = "'.JText::_('JGS_OF',true).'";';
        $doc->addScriptDeclaration($script);
        $this->_jg_config->jg_detailpic_open=$this->getConfig('openinbox');
      }
    }

    //get the images
    if($this->cmttest("sort"))
    {
      if($this->getConfig('sorting')=="commentrand")
      {
        $objects = $this->getdbComments("rand()");
      }
      else
      {
        $objects = $this->getdbComments($this->getConfig('sorting'));
      }
    }
    else
    {
      $objects = $this->getdbImages();
    }

    //*** Slideshow ***
    if($this->getConfig('slideshowthis') == 1)
    {
      //include javascripts
      JHTML::_('behavior.mootools');
      $doc->addScript(JURI::base().'modules/mod_joomimg/assets/slideshow.js');
    }
    else
    {
      //create and include the dynamic css for default view
      //according to backend settings
      $this->renderCSS();
    }
    //include common css
    $doc->addStyleSheet(JURI::base().'modules/mod_joomimg/assets/mod_joomimg.css');
    return $objects;
  }

  /**
   * get the params setted in module backend
   *
   * @param object $params - backend parameters
   */
  function getParams(&$params,&$moduleid){
    //get the parameters and add them to the config
    $this->addConfig('itemid',$params->get('itemid', 0 ));
    if ($this->getConfig('itemid')!=0)
    {
      $this->addConfig('itemidtxt','&amp;Itemid='.$this->getConfig('itemid'));
    }
    else
    {
      $this->addConfig('itemidtxt',$this->getJoomId());
    }
    $this->addConfig('limit',$params->get('limit', 4 ));
    $this->addConfig('img_per_row',$params->get('img_per_row', 2 ));
    $this->addConfig('sorting',$params->get( 'sorting', 'rand()' ));
    $this->addConfig('resultbytime',$params->get( 'resultbytime', 0 ));
    $this->addConfig('cats',$params->get( 'cats', '' ));
    $this->addConfig('showorhidecats',$params->get( 'showorhidecats', '1' ));
    $this->addConfig('dynamiccats',$params->get( 'dynamiccats', 0 ));
    $this->addConfig('crop_img',$params->get( 'crop_img', 0 ));
    $this->addConfig('crop_sizewidth',$params->get( 'crop_sizewidth', 50 ));
    $this->addConfig('crop_sizeheight',$params->get( 'crop_sizeheight', 150 ));
    $this->addConfig('piclink',$params->get( 'piclink', 0 ));
    $this->addConfig('openinbox',$params->get( 'openinbox', 0 ));
    $this->addConfig('show_empty_message',$params->get( 'show_empty_message', 1 ));
    $this->addConfig('image_position',$params->get( 'image_position', 1 ));
    $this->addConfig('auto_resize',$params->get( 'auto_resize', 0 ));
    $this->addConfig('auto_resize_max',$params->get( 'auto_resize_max', 100 ));
    $this->addConfig('imgwidth',$params->get( 'imgwidth', 0 ));
    $this->addConfig('imgheight',$params->get( 'imgheight', 0 ));
    $this->addConfig('showtext',$params->get( 'showtext', 1 ));
    $this->addConfig('showtitle',$params->get( 'showtitle', 1 ));
    $this->addConfig('strtitlewrap',$params->get( 'strtitlewrap', 0 ));
    $this->addConfig('showdescription',$params->get( 'showdescription', 0 ));
    $this->addConfig('strdescount',$params->get( 'strdescount', 0 ));
    $this->addConfig('strdeswrap',$params->get( 'strdeswrap', 0 ));
    $this->addConfig('showuser',$params->get( 'showuser', 0 ));
    $this->addConfig('showcatg',$params->get( 'showcatg', 0 ));
    $this->addConfig('showhits',$params->get( 'showhits', 0 ));
    $this->addConfig('showvotesum',$params->get( 'showvotesum', 0 ));
    $this->addConfig('showvotes',$params->get( 'showvotes', 0 ));
    $this->addConfig('showimgdate',$params->get( 'showimgdate', 0 ));
    $this->addConfig('showcmtdate',$params->get( 'showcmtdate', 0 ));
    $this->addConfig('showcmttext',$params->get( 'showcmttext', 0 ));
    $this->addConfig('showcmtcount',$params->get( 'showcmtcount', 0 ));
    $this->addConfig('strcmtcount',$params->get( 'strcmtcount', 0 ));
    $this->addConfig('strcmtwrap',$params->get( 'strcmtwrap', 0 ));
    $this->addConfig('showcmtmore',$params->get( 'showcmtmore', 0 ));
    $this->addConfig('scrollthis',$params->get( 'scrollthis', 0 ));
    $this->addConfig('scrolldirection',$params->get( 'scrolldirection', 'left' ));
    $this->addConfig('scrollheight',$params->get( 'scrollheight', 250 ));
    $this->addConfig('scrollwidth',$params->get( 'scrollwidth', 230 ));
    $this->addConfig('scrollamount',$params->get( 'scrollamount', 1 ));
    $this->addConfig('scrolldelay',$params->get( 'scrolldelay', 10 ));
    $this->scrollmousecode=($params->get( 'scrollmouse', 1 )==1) ? "onmouseover=\"this.stop()\" onmouseout=\"this.start()\"" : "";
    $this->addConfig('dir_hor',$params->get( 'dir_hor', 'left' ));
    $this->addConfig('dir_vert',$params->get( 'dir_vert', 'top' ));
    $this->addConfig('sectiontableentry',$params->get( 'sectiontableentry', 0 ));

    $this->addConfig('slideshowthis',$params->get( 'slideshowthis', 0 ));

    if(  $this->getConfig('showtext')       == 1
      && $this->getConfig('showtitle')       == 0
      && $this->getConfig('showdescription') == 0
      && $this->getConfig('showuser')        == 0
      && $this->getConfig('showcatg')        == 0
      && $this->getConfig('showhits')        == 0
      && $this->getConfig('showvotesum')     == 0
      && $this->getConfig('showvotes')       == 0
      && $this->getConfig('showimgdate')     == 0
      && $this->getConfig('showcmtdate')     == 0
      && $this->getConfig('showcmttext')     == 0
      && $this->getConfig('showcmtcount')    == 0 )
    {
      $this->addConfig('showtext',0);
    }
    $this->addConfig('imagetype',$params->get('imagetype',0));
    $this->addConfig('piclinkslideshow',$params->get('piclinkslideshow',0));
    $this->addConfig('showCaption',$params->get('showCaption',1));
    $this->addConfig('showTitleCaption',$params->get('showTitleCaption',1));
    $this->addConfig('heightCaption',$params->get('heightCaption',45));
    $this->addConfig('width',$params->get('width',400));
    $this->addConfig('height', $params->get('height',300));
    $this->addConfig('imageDuration', $params->get('imageDuration',9000));
    $this->addConfig('transDuration', $params->get('transDuration',2000));
    $this->addConfig('transType', $params->get('transType','combo'));
    $this->addConfig('transition', $params->get('transition','Expo.easeOut'));
    $this->addConfig('pan', $params->get('pan',50));
    $this->addConfig('zoom', $params->get('zoom',50));
    $this->addConfig('loadingDiv', $params->get('loadingDiv',1));
    $this->addConfig('imageResize', $params->get('imageResize',1));
    $this->addConfig('titleSize', $params->get('titleSize','13px'));
    $this->addConfig('titleColor', $params->get('titleColor','#fff'));
    $this->addConfig('descSize', $params->get('descSize','11px'));
    $this->addConfig('descColor', $params->get('descColor','#ccc'));

    $this->addConfig('csstag',"joomimg".$moduleid."_");

    //CSS border
    $this->addConfig('border',$params->get('border',0));
    $this->addConfig('borderwidth',$params->get('borderwidth','2px'));
    $this->addConfig('borderstyle',$params->get('borderstyle','solid'));
    $this->addConfig('bordercolor',$params->get('bordercolor','#000'));
    $this->addConfig('borderpadding',$params->get('borderpadding','2px'));
  }


  /**
   * assemble the query for reading the picture data from database
   * without comments
   *
   * @return object - picture objects
   */
  function getdbImages()
  {
    $database = & JFactory::getDBO();
    $user = & JFactory::getUser();
    $limit=$this->getConfig('limit');
    $sorting=$this->getConfig('sorting');

    if (stristr($sorting,'n.ndate'))
    {
      if ($this->getJConfig('jg_nameshields') == 0 )
      {
       return null;
      }
      elseif (!$user->get('aid') && !$this->getJConfig('jg_nameshields_unreg'))
      {
       return null;
      }
    }

    $query  = "SELECT p.id as picid, p.catid, p.imgthumbname, p.imgfilename, p.imgdate\n"
              .", p.imgtitle, p.imgtext,p.imgauthor,p.owner, p.imgcounter, p.imgvotes\n"
              .", (p.imgvotesum/p.imgvotes) AS vote, c.cid AS ccid, c.name AS cattitle,c.catpath as catpath\n";
    if($this->cmttest("cmttext"))
    {
      $query .= ", count(co.cmtid) AS cmtcount,co.userid as cmtuserid, co.cmttext, co.cmtdate, co.cmtname, co.cmtid as commentid\n";
    }
    $query .= "\n FROM #__joomgallery as p\n"
             ." JOIN #__joomgallery_catg as c ON c.cid=p.catid\n";
    if (stristr($sorting,'n.ndate'))
    {
      $query .= "\n JOIN #__joomgallery_nameshields as n ON n.npicid=p.id\n";
    }
    if($this->cmttest("cmttext"))
    {
      $query .= " JOIN #__joomgallery_comments as co ON co.cmtpic=p.id\n";
    }
    $query .= " WHERE c.published='1' AND c.access<=".$user->get('aid')."\n"
             ." AND p.published='1' AND p.approved='1'\n";
    if($this->getConfig('dynamiccats') && $this->checkifincat())
    {
      $query .= " AND p.catid = ".$this->getactcat()."\n";
    }
    if($this->getConfig('cats') != "")
    {
      $query .= " AND p.catid";
      $query .= ($this->getConfig('showorhidecats')==1) ? " IN" : " NOT IN";
      $query .= " (".$this->getConfig('cats').")\n";
    }
    //timespan filter
    if($this->getConfig('resultbytime') != 0)
    {
      $query .= $this->getSQLtimestring($this->getConfig('resultbytime'));
    }

    if($this->cmttest("cmttext")){
      $query .= " AND co.published='1' AND co.approved='1'\n"
    		   ." GROUP BY co.cmtpic\n";
    }
    $query .= " ORDER BY ".$sorting."\n";

    if(!empty($limit)) {
        $database->setQuery($query,0,$limit);
    }
    else
    {
        $database->setQuery($query);
    }

    $objects=$database->loadObjectList("picid");

    if ($this->getConfig('showcmtdate') || $this->getConfig('showcmttext'))
    {
      $this->getlastComments($objects);
    }
    return $objects;
   }

   /**
    * assemble the query for reading the picture data from database
    * with comments and comment count
    *
    * @param string $sorting - ORDER in DB
    * @param unknown_type $count
    * @return unknown
    */
  function getdbComments($sorting)
  {
    $database = & JFactory::getDBO();
    $user = & JFactory::getUser();
    $limit=$this->getConfig('limit');

    $cmtdate="co.cmtdate";
    if ($sorting == "co.cmtdate ASC")
    {
      $cmtdate = "MAX(co.cmtdate)";
      $sorting = "cmtdate ASC";
    }
    else if ($sorting == "co.cmtdate DESC")
    {
      $cmtdate = "MAX(co.cmtdate)";
      $sorting = "cmtdate DESC";
    }

    $query  = "SELECT co.cmttext,".$cmtdate." as cmtdate, co.cmtname,co.userid as cmtuserid,co.cmtid as commentid, p.id as picid, p.catid\n"
             .",p.imgthumbname, p.imgfilename, p.imgdate, p.imgtitle, p.imgtext,p.imgauthor,p.owner, p.imgcounter, p.imgvotes\n"
             .",(p.imgvotesum/p.imgvotes) AS vote, c.name AS cattitle,c.catpath as catpath\n"
             .",co.cmtpic AS id, count(co.cmtid) AS cmtcount\n"
             ."FROM #__joomgallery_comments as co\n"
             ."JOIN #__joomgallery as p ON co.cmtpic=p.id\n"
             ."JOIN #__joomgallery_catg as c ON c.cid=p.catid\n"
             ."WHERE c.published='1' AND c.access<=".$user->get('aid')."\n"
             ."AND p.published='1' AND p.approved='1'\n";

    //check the actual category shown
    if($this->getConfig('dynamiccats') && $this->checkifincat())
    {
      $query .= " AND p.catid = ".$this->getactcat();
    }

  //timespan filter
  if($this->getConfig('resultbytime') != 0)
  {
    $query .= $this->getSQLtimestring($this->getConfig('resultbytime'));
  }

    //specific cat(s) to ex-/include
    if($this->getConfig('cats') != "")
    {
      $query .= " AND p.catid";
      $query .= ($this->getConfig('showorhidecats')==1) ? " IN" : " NOT IN";
      $query .= " (".$this->getConfig('cats').")";
    }
    $query .= "AND co.published='1' AND co.approved='1'\n"
            . "GROUP BY co.cmtpic\n"
            . "ORDER BY ".$sorting."\n";

    if($limit != "")
    {
      $query .= "LIMIT ".$limit;
    }
    $database->setQuery( $query );
    $objects = $database->loadObjectList("picid");

    //get the date and/or text from last comment if one of the options activated
    //and pictures existent
    if ($this->getConfig('showcmtdate') || $this->getConfig('showcmttext'))
    {
      $this->getlastComments($objects);
    }
    //get all picture ids
    return $objects;
  }

 /**
 * create the where clause for timespan dependent query
 *
 * @param integer $option $this->getConfig('resultbytime')
 * @return string where clause
 */
  function getSQLtimestring ($option)
  {
    switch ($option)
    {
      //actual day
      case 1:
        $timequery = " AND p.imgdate >= CURRENT_DATE()\n";
        break;
      //actual week
      case 2:
        $startWeek = mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N')-1)*3600*24);
        $timequery = " AND p.imgdate >= FROM_UNIXTIME($startWeek)\n";
        break;
      //actual month
      case 3:
        $startMonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $timequery = " AND p.imgdate >= FROM_UNIXTIME($startMonth)\n";
        break;
      //actual year
      case 4:
        $startYear = mktime(0, 0, 0, 1, 1, date('Y'));
        $timequery = " AND p.imgdate >= FROM_UNIXTIME($startYear)\n";
        break;
      //last 24 hours
      case 5:
        $timequery = " AND FROM_UNIXTIME(p.imgdate) >= (NOW() - INTERVAL 24 HOUR)\n";
        break;
      //last 7 days
      case 6:
        $timequery = " AND FROM_UNIXTIME(p.imgdate) >= (NOW() - INTERVAL 7 DAY)\n";
        break;
      //last 30 days
      case 7:
        $timequery = " AND FROM_UNIXTIME(p.imgdate) >= (NOW() - INTERVAL 30 DAY)\n";
        break;
      //last 12 months
      case 8:
        $timequery = " AND FROM_UNIXTIME(p.imgdate) >= (NOW() - INTERVAL 12 MONTH)\n";
        break;
      default:
        $timequery= '';
        break;
    }
    return $timequery;
  }

  /**
   * assemble the html code for text fields of pictures
   *
   * @param object $obj - picture object
   * @return string - html code
   */
  function showtext($obj)
  {
    $database = & JFactory::getDBO();
    $user = & JFactory::getUser();
    $csstag=$this->getConfig("csstag");
    if($this->getConfig('showtext')==1)
    {
      $output = "";
      if($this->getConfig('showtitle') == 1)
      {
        if($this->getConfig('piclink')==1)
        {
          $link = JRoute::_('index.php?option=com_joomgallery'.$this->getConfig('itemidtxt').'&func=viewcategory&catid='.$obj->catid);
        }
        else
        {
          if (($this->getJConfig('jg_showdetailpage')==0 &&
               $user->get('aid')!=0 ) ||
               $this->getJConfig('jg_showdetailpage')==1 )
          {
            $link = Joom_OpenImage($this->getJConfig('jg_detailpic_open'), $obj->picid, $obj->catpath, $obj->catid, $obj->imgfilename, $obj->imgtitle, $obj->imgtext);
            if ($this->getConfig('itemid')!=0)
            {
              $link=preg_replace('/[I|i]temid=[0-9]*/','Itemid='.$this->getConfig('itemid'),$link,1);
            }
            if($this->getJConfig('jg_detailpic_open')==0)
            {
              $link .= "#joomimg";
            }
          }
          else
          {
            $link = "javascript:alert('".JText::_('JGS_ALERT_NO_DETAILVIEW_FOR_GUESTS',true)."')";
          }
          $link = str_replace("lightbox[joomgallery]","lightbox[".$csstag."2]",$link);
          $link = str_replace("rel=\"joomgallery\"","rel=\"".$csstag."2\"",$link);
        }
        $output .="<a href=\"".$link;
        $output .="\" class=\"".$csstag."name\">\n".$obj->imgtitle ."\n</a><br />\n";
      }
      if($this->getConfig('showuser') == 1)
      {
        $output .= "<span class=\"".$csstag."user\">".JText::_('JGS_AUTHOR').' '.Joom_GetDisplayName($obj->owner)."</span><br />\n";
      }
      if($this->getConfig('showcatg') == 1)
      {
        $catlink=JRoute::_('index.php?option=com_joomgallery'.$this->getConfig('itemidtxt').'&func=viewcategory&catid='.$obj->catid);
        $output .= JText::_('JGS_CATEGORY').":\n"
                ."<a href=\"".$catlink."\" class=\"".$csstag."cat\" title=\"".$obj->cattitle."\">\n"
                .$obj->cattitle."\n</a><br />\n";
      }
      if($this->getConfig('showdescription') == 1 && $obj->imgtext !='')
      {
        $output .= "<span class=\"".$csstag."description\">".JText::_('JGS_DESCRIPTION').": ".$obj->imgtext."</span><br />\n";
      }
      if($this->getConfig('showimgdate') == 1)
      {
        $output .= "<span class=\"".$csstag."imgdate\">".JText::_('JGS_UPLOAD_DATE').":<br /> "
                . strftime($this->getJConfig('jg_dateformat'), $obj->imgdate )."</span><br />\n";
      }
      if($this->getConfig('showhits') == 1)
      {
        $output .= "<span class=\"".$csstag."hits\">".JText::_('JGS_HITS').": ".$obj->imgcounter."</span><br />\n";
      }
      if($this->getConfig('showvotesum') == 1)
      {
        $output .= "<span class=\"".$csstag."votes\">".JText::_('JGS_RATING').": ";
        if($obj->vote=="")
        {
          $output .= JText::_('JGS_NO_RATINGS');
        }
        else
        {
          $output .= number_format( $obj->vote, 2, ",", "." );
          if($this->getConfig('showvotes') == 1) {
            $output .= " (".$obj->imgvotes.")";
          }
        }
        $output .= "<br /></span>\n";
      }
      if($this->getConfig('showcmtcount') == 1)
      {
        $count = $obj->cmtcount;
        if (($this->getJConfig('jg_showdetailpage')==0 && $user->get('aid')!=0 )
             || $this->getJConfig('jg_showdetailpage')==1 )
        {
          $output .= "<a href=\"".JRoute ::_("index.php?option=com_joomgallery&amp;func=detail".$this->getConfig('itemidtxt')."&amp;id=".$obj->picid).'#joomcomments'."\" class=\"".$csstag."cmtcount\">".JText::_('JGS_NUMBER_OF_COMMENTS').": ".$count."</a><br />\n";
        }
        else
        {
          $output .= "<a href=\"javascript:alert('".JText::_('JGS_ALERT_NO_DETAILVIEW_FOR_GUESTS',true)."')\" class=\"".$csstag."cmtcount\" >".JText::_('JGS_NUMBER_OF_COMMENTS').": ".$count."</a><br />\n";
        }
      }
      if($this->getConfig('showcmtdate') == 1 && $obj->cmtdate != NULL)
      {
        $output .= "<span class=\"".$csstag."cmtdate\">".JText::_('JGS_LAST_COMMENT_DATE').": <br />"
                . strftime( $this->getJConfig('jg_dateformat'), $obj->cmtdate )."</span><br />\n";
      }
      if($this->getConfig('showcmttext') == 1 && $obj->cmtdate != NULL)
      {
        $cmtname=$obj->cmtname;
        $userid=$obj->cmtuserid;
        if ($userid != 0)
        {
          $query = "SELECT username
              FROM #__users
              WHERE id = '$userid'";
          $database->setQuery($query);
          $cmtname = $database->loadResult();
        }

        if ($this->getJConfig('jg_combuild') && $userid !=0)
        {
          $userlink=Joom_GetDisplayName($userid);
          $output .= "<span class=\"".$csstag."cmttext\">".JText::_('JGS_LAST_COMMENT_BY')." ".$userlink;
        }
        else
        {
          $output .= "<span class=\"".$csstag."cmttext\">".JText::_('JGS_LAST_COMMENT_BY')." ".$cmtname;
        }
        $output .= ":<br />\n&quot; ".$this->decodetext($obj->cmttext);
        if ($this->getConfig('showcmtmore') == 1 && $this->getConfig('strcmtcount') > 0) {
          $output .= "&nbsp;&#0133;<a href=\"".JRoute::_("index.php?option=com_joomgallery&amp;func=detail".$this->getConfig('itemidtxt')."&amp;id=".$obj->picid)."#joomcomments"."\">".JText::_('READMORE')."</a>\n";
        }
        $output .= " &quot;\n</span>\n";
      }
    } else {
      $output = "";
    }
    return $output;
  }

  /**
   * read the last comment of a picture
   *
   * @param array $objects
   */
  function getlastComments($objects)
  {
    $database = & JFactory::getDBO();
    if (count($objects))
    {
      $picids='(';
      $sep='';
      foreach ($objects as $obj)
      {
        $picids .= $sep.$obj->picid;
        $sep=',';
      }
      $picids.=')';

      $query = "SELECT co.cmtid,co.cmtpic,co.cmttext,co.cmtdate,co.userid,co.cmtname \n"
               ."FROM #__joomgallery_comments AS co\n"
               ."LEFT JOIN #__joomgallery_comments AS co2\n"
               ."ON co.cmtpic = co2.cmtpic\n"
               ."AND co.cmtdate < co2.cmtdate\n"
               ."WHERE co2.cmtpic IS NULL\n"
               ."AND co.cmtpic IN $picids";
      $database->setQuery( $query );
      $commobjects = $database->loadObjectList();

      //and fill object with last comment
      foreach ($commobjects as $commobj)
      {
        $objects[$commobj->cmtpic]->cmttext=$commobj->cmttext;
        $objects[$commobj->cmtpic]->cmtdate=$commobj->cmtdate;
        $objects[$commobj->cmtpic]->cmtname=$commobj->cmtname;
        $objects[$commobj->cmtpic]->cmtuserid=$commobj->userid;
        $objects[$commobj->cmtpic]->commentid=$commobj->cmtid;
      }
    }
  }


  /**
   * check the backend for activated settings according comments to choose
   * the right DB function or to add the query in getdbImages()
   *
   * @param int $only_comments 1=check for comment sorts in DB
   * @return bool
   */
  function cmttest($mode)
  {
    if ($mode=="sort")
    {
      if( $this->getConfig('sorting')=="cmtcount ASC"
         || $this->getConfig('sorting')=="cmtcount DESC"
         || $this->getConfig('sorting')=="co.cmtdate ASC"
         || $this->getConfig('sorting')=="co.cmtdate DESC"
         || $this->getConfig('sorting')=="commentrand") {
         return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      if ($this->getConfig("showcmtdate")
          || $this->getConfig("showcmttext")
          || $this->getConfig("showcmtcount")
          || $this->getConfig("showcmtcount")){
          return true;
      }
      else
      {
        return false;
      }
    }
  }


  /**
   * check if in joomgallery category or detail view
   *
   * @return bool
   */
  function checkifincat()
  {
    //get some request variables
    $option    = JRequest::getVar('option', '' );
    $func      = JRequest::getVar('func', '' );
    $catid     = JRequest::getInt('catid',0);
    $id        = JRequest::getInt('id',0);

    if($option == "com_joomgallery")
    {
      //category view
      if ($func=="viewcategory" && $catid !=0)
      {
        return true;
      }
      //detail view
      if ($func="detail" && $id != 0)
      {
        return true;
      }
    }
    return false;
  }


  /**
   * return the actual category
   *
   * @param int $cid - category id
   * @return bool - category id
   */
  function getactcat()
  {
    $database = & JFactory::getDBO();
    $user = & JFactory::getUser();
    //get some request variables
    $func      = $database->getEscaped(trim(JRequest::getVar( 'func', '' )));
    $catid     = JRequest::getInt('catid',0);
    $id        = JRequest::getInt('id',0);

    if ($func=="viewcategory" && $catid !=0)
    {
      return $catid;
    }

    if($func=="detail" && $id!=0 )
    {
      $query  = "SELECT p.catid FROM #__joomgallery as p"
               ." LEFT JOIN #__joomgallery_catg as c ON c.cid=p.catid"
               . " WHERE c.published='1' AND c.access<=".$user->get('aid')
               ." AND p.published='1' AND p.approved='1' AND p.id = ".$id
               ." LIMIT 1";
      $database->setQuery( $query );
      return $database->loadResult();
    }
    else
    {
      return 0;
    }
  }


  function renderCSS()
  {
    $containerwidth=floor(100/$this->getConfig("img_per_row"));
    $csstag=$this->getConfig("csstag");

    $dirhoriz="text-align:".$this->getConfig("dir_hor")."!important;\n";
    $dirvert="vertical-align:".$this->getConfig("dir_vert")."!important;\n";
    $csscont="float:left;\n";

    switch ($this->getConfig("image_position"))
    {
      case 0:
        //no image
        $cssimg ="";
        $csstxt = $dirhoriz.$dirvert;
        break;
      case 1:
        //image above text
        $cssimg = "display:block;\n";
        $cssimg .= $dirhoriz.$dirvert;
        $csstxt = "clear:both;".$dirhoriz.$dirvert;
        break;
      case 2:
        //image left from text
        $cssimg = "float:left;\n";
        $csstxt = "float:left;\n";
        $cssimg .= $dirhoriz.$dirvert;
        $csstxt .= $dirhoriz.$dirvert;
        break;
      case 3:
        //image right from text
        $cssimg = "float:right;\n";
        $csstxt = "float:right;\npadding-right:0.5em;\n";
        $cssimg .= $dirhoriz.$dirvert;
        $csstxt .= $dirhoriz.$dirvert;
        break;
      default:
        //image below text
        $cssimg = $dirhoriz.$dirvert;
        $csstxt = $dirhoriz.$dirvert;
        break;
    }

    //CSS for border if image displayed and 'border' = yes
    if ($this->getConfig("image_position") != 0 && $this->getConfig("border") ==1 )
    {
      $cssborder="border:"
        .$this->getConfig("borderwidth")
        ." "
        .$this->getConfig("borderstyle")
        ." "
        .$this->getConfig("bordercolor")
        .";\npadding:".$this->getConfig("borderpadding")
        .";";
    }
    else
    {
      $cssborder="";
    }


    $css="";
    //Container
    $css .= ".".$csstag."imgct {\n"
        . "width:".$containerwidth."% !important;\n"
        . $csscont
        ."}\n";

    //pic
    if (!empty($cssimg))
    {
      $css .= ".".$csstag."img {\n"
        . $cssimg
        ."}\n";

      //border for img
      if (!empty($cssborder))
      {
        $css .= ".".$csstag."img img{\n"
          . $cssborder
          ."}\n";
      }
    }

    //text
    if (!empty($csstxt))
    {
      $css .= ".".$csstag."txt {\n"
           . $csstxt
           ."}\n";
    }

    //define height/width of images if setted
    //not when auto_resize activated
    if (!$this->getConfig('auto_resize') && !$this->getConfig('crop_img'))
    {
      if ($this->getConfig('imgwidth') != 0
          || $this->getConfig('imgheight')!= 0)
      {
        $imgcss="";
        if ($this->getConfig('imgwidth') != 0)
        {
          $imgcss .="\nwidth:".$this->getConfig('imgwidth')."px;";
        }
        if ($this->getConfig('imgheight') != 0)
        {
          $imgcss .="\nheight:".$this->getConfig('imgheight')."px;";
        }

        $css .= ".".$csstag."img img {\n"
             . $imgcss
             ."}\n";
      }
    }

    $document = &JFactory::getDocument();
    $document->addStyleDeclaration($css);
  }


  function decodetext($text,$newlength=0,$wrap=0,$more=0)
  {
    //Remove whitespace at start and end of the text
    $text = trim($text);
    $newlength = ($newlength!=0) ? $newlength-1 : 0;
    $smiley=Joom_GetSmileys();

    //Define replace tags
    $replace1  = array("[url]","[/url]","[email]","[/email]");
    $replace21 = array("[b]","[i]","[u]");
    $replace22 = array("[/b]","[/i]","[/u]");
    $replace2  = array_merge($replace21, $replace22);
    $replace3  = array("<b>","<i>","<u>","</b>","</i>","</u>");

    //replace url and emailtags because we do not show them in our modules
    foreach($replace1 as $replace)
    {
      $text = str_replace($replace,"",$text);
    }
    $textlength = strlen($text);
    //if text has to be in a range we abridge him
    if($newlength > 0 && $newlength < $textlength)
    {
      $add = "";

      //replace simple html-tags with bb_code
      for($i=0;$i<count($replace3);$i++)
      {
        $text = str_replace($replace3[$i],$replace2[$i],$text);
      }

      //replace smilies with shorttags or remove them
      if($this->getJConfig('jg_smiliesupport'))
      {
        $count=0;
        $smileshort = array();
        foreach ( $smiley as $i=>$sm )
        {
          $text = str_replace ($i, "{".$count."}", $text);
          $smileshort[$count]["short"] = $i;
          $smileshort[$count]["long"]  = $sm;
          $count++;
        }
      }
      else
      {
        foreach ( $smiley as $i=>$sm )
        {
          $text = str_replace ($i, "", $text);
        }
      }
      $textlength = strlen($text);
    }
    //remove any html because it is too complicated to handle them
    //except the <br /> coming from an former allowed wordwrap
    if ( $wrap > 0 )
    {
      $text = strip_tags($text,"<br>");
    }
    else
    {
      $text = strip_tags($text);
    }
    //if wrap is activated count the containing <br />
    // and add their length to $newlength
    if ($wrap > 0)
    {
      $countbrstr=substr($text,0,$newlength);
      //count the <br />
      $countbr=substr_count($countbrstr,'<br />');
      if ($countbr > 0)
      {
        $newlength = $newlength + ($countbr*6);
      }
    }
    $textlength = strlen($text);

    // slice if needful
    if ($newlength != 0 && $textlength > ($newlength+1))
    {
      //Check a sliced <br />
      if (($textlength-6) > 0 && ($newlength-6) > 0)
      {
        $strposfound=strpos($text,'<br />',$newlength-6);
      }
      else
      {
        $strposfound = 0;
      }
      if ($strposfound > 0 && $strposfound < $newlength)
      {
        $newlength=$strposfound; //slice before the begin of the <br />
      }
      else
      {
        //check a sliced bbcode tag and shorten newlength
        foreach($replace2 as $replace)
        {
          $replacelength=strlen($replace);
          if ($textlength > ($newlength-$replacelength) && ($newlength-$replacelength) > 0)
          {
            $strposfound=strpos($text,$replace,$newlength-$replacelength);
          }
          else
          {
            $strposfound = 0;
          }
          if($strposfound > 0 && $strposfound < $newlength)
          {
            $newlength=$strposfound;
            break;
          }
        }
        //check a sliced smilie tag and shorten newlength
        if (isset($smileshort))
        {
          for($i=0;$i<count($smileshort);$i++)
          {
            $replacelength=strlen($i)+2;
            if ($textlength > ($newlength-$replacelength) && ($newlength-$replacelength) > 0)
            {
              $strposfound=strpos($text,"{".$i."}",$newlength-$replacelength);
            }
            else
            {
              $strposfound = 0;
            }
            if($strposfound > 0 && $strposfound < $newlength)
            {
              $newlength=$strposfound;
              break;
            }
          }
        }
      }
      //slice the text
      $text=substr($text,0,$newlength);
    }


    //Adding mising tags at the end of the text
    if ( $this->getJConfig('jg_bbcodesupport'))
    {
      $prioarr=array();
      //builds an array for the priority in replacing
      $countreplace=count($replace21);
      for($i=0;$i < $countreplace;$i++)
      {
        //check if there is an unbalance
        //of opening and closing tags
        $countopen=substr_count($text,$replace21[$i]);
        $countclose=substr_count($text,$replace22[$i]);
        $diff = $countopen-$countclose;
        $found = -1;
        while ($diff > 0)
        {
          $found=strpos($text,$replace21[$i],$found+1);
          $prioarr[$found]=$replace22[$i]; //add the closing tag
          $diff--;
        }
      }
      if (count($prioarr))
      {
        //reverse the array to begin with the last element
        arsort($prioarr);
        foreach($prioarr as $key => $value)
        {
          $add .= $value;
        }
      }
    }
    //abridge text and add missing tags
    if (!empty($add))
    {
      $text = $text.$add;
    }
    //If text was sliced add the ellipsis
    if( $newlength > 0 && $textlength > $newlength && $more == 0)
    {
      $text .= "...";
    }

    //decoding bb_code or remove tags
    if ( $this->getJConfig('jg_bbcodesupport'))
    {
      //including common.joomgallery.php for decoding bb_code function
      if(!function_exists('Joom_BBDecode'))
      {
        include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomgallery'.DS.'common.joomgallery.php');
      }
      $text = Joom_BBDecode( $text );
    }
    else
    {
      foreach($replace2 as $replace)
      {
        $text = str_replace($replace,"",$text);
      }
    }

    //decoding smilies or remove them
    if ( $this->getJConfig('jg_smiliesupport'))
    {
      foreach ( $smiley as $i=>$sm )
      {
        $text = str_replace ($i, "<img src=\"".$sm."\""." alt=\"".$i."\" />", $text);
      }
      if (isset($smileshort))
      {
        for($i=0;$i<count($smileshort);$i++)
        {
          $text = str_replace ("{".$i."}", "<img src=\"".$smileshort[$i]['long']."\" border=\"0\" alt=\"".$smileshort[$i]['short']."\" title=\"".$smileshort[$i]['short']."\" />", $text);
        }
      }
    }
    else
    {
      foreach ( $smiley as $i=>$sm )
      {
        $text = str_replace ($i, "", $text);
      }
      if (isset($smileshort))
      {
        for($i=0;$i<count($smileshort);$i++)
        {
          $text = str_replace ("{".$i."}", "", $text);
        }
      }
    }
    return $text;
  }
}