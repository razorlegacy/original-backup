<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class OriginModelQuery extends JModel {
        public $_originDB	= null;
        private $_states	= array('default', 'expand');	

        function __construct() {
			parent::__construct();
			$this->_originDB    = $this->getDBO();
        }
        
        /**
        * Origin object
        **/
        function loadOrigin($id, $date = '') {
        	//Config
        	$query		= "SELECT * FROM #__emc_origin WHERE id='{$id}'";
        	$this->_originDB->setQuery($query);
        	$config		= $this->_originDB->loadObject();

        	//Content
        	$query		= "SELECT * FROM #__emc_origin_schedule WHERE oid = '{$id}'";
        	$query		.= (!empty($date))? " AND ('{$date}' BETWEEN start_date AND end_date)": "";
        	$query		.= " ORDER BY -start_date DESC";
        	$this->_originDB->setQuery($query);
            $scheduleObj = $this->_originDB->loadObjectList();
            
            foreach($scheduleObj as $key=>$value) {
            	
            	//$scheduleObj[$key]->content     = $this->getOriginContent($value->id);
            	foreach($this->_states as $state) {
	            	$query	= "SELECT * FROM #__emc_origin_content WHERE sid = '{$value->id}' AND state = '{$state}'";
	            	$this->_originDB->setQuery($query);
	            	$scheduleObj[$key]->content[$state]	= $this->_originDB->loadObjectList();
            	}
            }
            
            $content = $scheduleObj;
	        return array("config"=>$config, "content"=>$content);
        }
        
        /**
		* Gets a complete Origin unit
		**/
		function getOrigin($id) {
			//Config
			$query = "SELECT * FROM #__emc_origin WHERE id='{$id}'";
			$this->_originDB->setQuery($query);
			$config = $this->_originDB->loadObject();
			
			//Content
			$query  = "SELECT 
							#__emc_origin_schedule.id AS schedule_id, 
							IFNULL(#__emc_origin_schedule.start_date, '') AS start_date, 
							IFNULL(#__emc_origin_schedule.end_date, '') AS end_date, 
							IFNULL(#__emc_origin_content.state, '') AS content_state, 
							IFNULL(#__emc_origin_content.content, '') AS content_data, 
							IFNULL(#__emc_origin_content.config, '') AS content_config, 
							IFNULL(#__emc_origin_content.render, '') as content_render,
							IFNULL(#__emc_origin_content.id, '') as content_id
						FROM #__emc_origin_schedule  
						LEFT JOIN #__emc_origin_content 
						ON #__emc_origin_schedule.id = #__emc_origin_content.sid 
						WHERE #__emc_origin_schedule.oid = '{$id}' 
						GROUP BY schedule_id, content_state, content_id";
			$this->_originDB->setQuery($query);
			$content  = $this->_originDB->loadObjectList();
			
			$sid = null;
			$skey = 0;
			for($i=0; $i<=count($content); $i++) {
				if($i==count($content)) {
					$schedule[$skey]['initial_desktop'] 	= $content_initial_desktop;
					$schedule[$skey]['triggered_desktop'] 	= $content_triggered_desktop;
				}
				else {
					if( $sid == $content[$i]->schedule_id) {
						${'content_'.$content[$i]->content_state}[] = array('id'=>$content[$i]->content_id, 'content_data'=>json_decode($content[$i]->content_data), 'content_config'=>json_decode($content[$i]->content_config), 'content_render'=>$content[$i]->content_render);
					}
					else {
						if($sid!=null) {
							$schedule[$skey]['initial_desktop'] = $content_initial_desktop;
							$schedule[$skey]['triggered_desktop'] 	= $content_triggered_desktop;
							$skey++;
						}
						
						$start_date		= ($content[$i]->start_date === '')? '': date('m/d/Y', strtotime($content[$i]->start_date));
						$end_date		= ($content[$i]->end_date === '')? '':date('m/d/Y', strtotime($content[$i]->end_date));
						
						$schedule[$skey] = array (
									'id'=>$content[$i]->schedule_id,
									'start_date'=>$start_date,
									'end_date'=>$end_date
									);
						$sid = $content[$i]->schedule_id;
						$content_initial_desktop = array();
						$content_triggered_desktop = array();
						${'content_'.$content[$i]->content_state}[] = array('id'=>$content[$i]->content_id, 'content_data'=>json_decode($content[$i]->content_data), 'content_config'=>json_decode($content[$i]->content_config), 'content_render'=>$content[$i]->content_render);
					}
				}
		
			}
			$origin  = array("config"=>$config, "content"=> (Object)$schedule);
			return $origin;
		 }
        /*
function getOrigin($id) {
			//Config
			$query = "SELECT * FROM #__emc_origin WHERE id='{$id}'";
			$this->_originDB->setQuery($query);
			$config = $this->_originDB->loadObject();
			
			//Content
			$query  = "SELECT 
							#__emc_origin_schedule.id AS schedule_id, 
							IFNULL(#__emc_origin_schedule.start_date, '') AS start_date, 
							IFNULL(#__emc_origin_schedule.end_date, '') AS end_date, 
							IFNULL(#__emc_origin_content.state, '') AS content_state, 
							IFNULL(#__emc_origin_content.content, '') AS content_data, 
							IFNULL(#__emc_origin_content.config, '') AS content_config 
						FROM #__emc_origin_schedule  
						LEFT JOIN #__emc_origin_content 
						ON #__emc_origin_schedule.id = #__emc_origin_content.sid 
						WHERE #__emc_origin_schedule.oid = '{$id}' 
						GROUP BY schedule_id, content_state, content_data";
			$this->_originDB->setQuery($query);
			$content  = $this->_originDB->loadObjectList();
			
			$sid = null;
			$skey = 0;
			for($i=0; $i<=count($content); $i++) {
				if($i==count($content)) {
					$schedule[$skey]['default'] = $content_default;
					$schedule[$skey]['expand'] 	= $content_expand;
				}
				else {
					if( $sid == $content[$i]->schedule_id) {
						${'content_'.$content[$i]->content_state}[] = array('content_data'=>$content[$i]->content_data, 'content_config'=>$content[$i]->content_config);
					}
					else {
						if($sid!=null) {
							$schedule[$skey]['default'] = $content_default;
							$schedule[$skey]['expand'] 	= $content_expand;
							$skey++;
						}
						$schedule[$skey] = array (
									'id'=>$content[$i]->schedule_id,
									'start_date'=>$content[$i]->start_date,
									'end_date'=>$content[$i]->end_date
									);
						$sid = $content[$i]->schedule_id;
						$content_default = array();
						$content_expand = array();
						${'content_'.$content[$i]->content_state}[] = array('content_data'=>$content[$i]->content_data, 'content_config'=>$content[$i]->content_config);
					}
				}
		
			}
			$origin  = array("config"=>$config, "content"=> (Object)$schedule);
			return $origin;
		 }
*/
		 
		 function getContent($cid) {
		 	$query = "SELECT * FROM #__emc_origin_content WHERE id='{$cid}'";
			$this->_originDB->setQuery($query);
			return $this->_originDB->loadObject();
		 }
        
        
        
        
        
        
       
	   /**
		 * Pulls an individual Origin record
		 */
		 function getOriginRow($id) {
                 $query = 'SELECT * FROM #__emc_origin'.
							   ' WHERE id='.$id;
	
				 $this->_originDB->setQuery($query);

                 $origin = $this->_originDB->loadObject();

				return $origin;

        }
		
    	 /**
        * Get origin object
        */
        function getOriginObj($origin){
			$json  = array("config"=>$origin, "content"=> $this->getOriginSchedules($origin->id));
			return $json;
        }
       
        function getOriginSchedules($oid) {
            $query			= "SELECT  *
            					FROM #__emc_origin_schedule 
            					WHERE oid = '{$oid}' ORDER BY -start_date DESC";
    		$this->_originDB->setQuery($query);
            $scheduleObj	= $this->_originDB->loadObjectList();
           
            foreach($scheduleObj as $key=>$value) {
            	$scheduleObj[$key]->content     = $this->getOriginContent($value->id);
            }

        	return $scheduleObj;
        }
       
        function getOriginContent($sid) {
        	$contentObj['default']  = $this->getOriginContentState($sid, 'default');
        	$contentObj['expand']  	= $this->getOriginContentState($sid, 'expand');
        	return $contentObj;    
        }
       
        function getOriginContentState($sid, $state) {
        	$query				= "SELECT *
        							FROM #__emc_origin_content 
        							WHERE sid = '{$sid}' AND state='{$state}'" ;
        	$this->_originDB->setQuery($query);
        	$contentStateObj	= $this->_originDB->loadObjectList();
        	return $contentStateObj;       
        }
         
         
        //Is this used?                              
        function getSchedulesJOIN($oid) {
        	$query				= "SELECT #__emc_origin_schedule.* , #__emc_origin_content.* 
        						FROM #__emc_origin_schedule LEFT JOIN #__emc_origin_content ON #__emc_origin_schedule.id=#__emc_origin_content.sid 
        						WHERE #__emc_origin_schedule.oid = '{$oid}' ORDER BY #__emc_origin_schedule.start_date ";
			$this->_originDB->setQuery($query);
			$contentsObj		= $this->_originDB->loadObjectList();
			return $contentsObj;           
        }
		
}