<?php defined('_JEXEC') or die('Restricted access');?>

<img id="emcCartographer_bg_<?php echo $this->groupObj->id;?>" class="emcCartographer_bg" src="/assets/components/com_emc_cartographer/<?php echo $this->cartographerObj['config']->id;?>/<?php echo json_decode($this->groupObj->content)->bg_img;?>"/>