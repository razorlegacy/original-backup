<?php

/*------------------------------------------------------------------------
# Copyright (C) 2005-2010 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 


class JCKAuthenticate
{

	function check()
    {
		  
		/* Load Joomla's required classes */
		
		jimport('joomla.database.table');
		//jimport('joomla.environment.uri');
			
			
		$sesscookies = $_REQUEST;
	   
	
		$storage = & JTable::getInstance('session');
	   
		$tmpUser  = new stdclass;
		
		if(!empty($sesscookies ))
		{
			foreach( $sesscookies as $k=>$v)
			{
				$result = $storage->load($v);
						
				if($result && $storage->userid)
				{
					$tmpUser = &JFactory::getUser($storage->userid);
					if($tmpUser->gid > 18) //Is there a valid user logged in with sufficient privileges
					{
						$juser = $tmpUser; 
						break;
					}	
				}
			}
			unset($tmpUser);	
		}
		
		return isset($juser);

	}
		
}