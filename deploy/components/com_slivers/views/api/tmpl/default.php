<?php
	defined('_JEXEC') or die('Restricted access');
	function h($content){
		echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
	}
?><?xml version="1.0" encoding="UTF-8"?>
<Config>
	<Backgrounds>
	<?php foreach($this->backgrounds as $background){
			?><Background date="<?php h($background->starts); ?>" src="<?php h($background->flash_uri); ?>"
	                height="<?php h($background->flash_height); ?>" width="<?php h($background->flash_width); ?>" jsAction="ao_headerClick" /><?php
	  } ?>
	</Backgrounds>
    <Buttons><?php
			foreach($this->buttons as $button){
				//the flash cannot handle buttons that aren't meant for the sliver.
				if($button->area == 'sliver'){
					?><Button height="<?php h($button->height); ?>"
										width="<?php h($button->width); ?>"
										posX="<?php h($button->x_offset); ?>"
										posY="<?php h($button->y_offset); ?>"
										action="<?php h($button->action); ?>"
										trackingName="<?php h($button->name.'_'.$button->id); ?>"
										on="<?php h($button->on); ?>"
										url="<?php h($button->url); ?>" /><?php
				}
				}
    ?></Buttons>
    <Tracking account="UA-12310597-3" visualDebug="false" prefix="<?php h($this->sliver->prefix); ?>" />
    <Videos><?php
			foreach($this->videos as $video){
        ?><Video>
					<date><?php h($video->starts) ?></date>
					<height><?php h($video->height); ?></height>
					<width><?php h($video->width); ?></width>
					<autoPlay><?php h($video->autoPlay?'true':'false'); ?></autoPlay>
					<autoPlayOn><?php h($video->autoPlayOn); ?></autoPlayOn>
					<startMuted><?php h($video->startMuted?'true':'false'); ?></startMuted>
					<unmuteOnRollover><?php h($video->unmuteOnRollover?'true':'false'); ?></unmuteOnRollover>
					<volume><?php h($video->volume); ?></volume>
					<controls><?php h($video->controls_uri); ?></controls>
					<posX><?php h($video->posX); ?></posX>
					<posY><?php h($video->posY); ?></posY>
					<source><?php h($video->source_uri); ?></source>
					<thumbnail><?php h($video->thumbnail_uri); ?></thumbnail>
        </Video><?php
			} ?></Videos>
</Config>