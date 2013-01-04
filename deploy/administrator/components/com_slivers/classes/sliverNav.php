<?php
defined('_JEXEC') or die();
/**
 * 
 */
class sliverNav {
	private $active;
	private $navElements = array('general' => array('name' => 'General Settings' ,'next'=>'images','prev'=>'general', 'task' => 'editGeneral'),
		'images'   => array('name' => 'Background Images','next'=>'videos','prev'=>'general', 'task' => 'editScheduledImages'),
		'videos'   => array('name' => 'Videos (optional)'           ,'next'=>'positions','prev'=>'images', 'task' => 'editVideos'),
		'positions'=> array('name' => 'Position Elements','next'=>'final','prev'=>'videos', 'task' => 'editPositions'),
		'final'   => array('name' => 'Done!'           ,'next'=>'final','prev'=>'positions', 'task' => 'displayFinalPage')
		);
	public $sliver_id;
	function __construct($activeNav,$sliver_id){
		if(!$this->setActive($activeNav)) $this->active = 'general';
		$this->sliver_id = $sliver_id;
	}

	public function getNav(){
		$nav = <<<EOD
<div id="submenu-box"><div class="t"><div class="t"><div class="t"></div></div></div>
	<div class="m">
		<ul id="submenu">
EOD;
		foreach($this->navElements as $key => $navEl){
			$nav .= '<li><a '.($key == $this->active ? 'class="active" ': '' ).'href="'.htmlspecialchars('index.php?option=com_slivers&task='.$navEl['task'].'&cid='.$this->sliver_id).'">'.$navEl['name'].'</a></li>';
		}
		$nav .= <<<EOD
		</ul>
		<div class="clr"></div>
	</div>
	<div class="b"><div class="b"><div class="b"></div></div></div>
</div>
EOD;
		return $nav;
	}

	public function setActive($tab){
		if(in_array($tab,array_keys($this->navElements))){
			$this->active = $tab;
			return $this;
		}
		return false;
	}
	public function getActiveTask(){
		return $this->getTask($this->active);
	}

	public function getTask($key){
		return $this->navElements[$key]['task'];
	}

	public function getNext(){
		return $this->getTask($this->navElements[$this->active]['next']);
	}
	public function getPrevious(){
		return $this->getTask($this->navElements[$this->active]['prev']);
	}

}
