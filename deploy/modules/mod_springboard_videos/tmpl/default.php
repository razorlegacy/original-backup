<?php

defined('_JEXEC') or die('Restricted access'); // no direct access

// Include the syndicate function only once
require_once (dirname(__FILE__).DS.'helper.php');

?>

<?php if( $feed != false ) : ?>
	<?php
		//image handling
		$iUrl 	= isset($feed->image->url)   ? $feed->image->url   : null;
		$iTitle = isset($feed->image->title) ? $feed->image->title : null;
	?>
	<div class="feed_wrapper<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if (!is_null( $feed->title ) && $params->get('rsstitle', 1)) : // feed title ?>
			<h3><a href="<?php echo str_replace( '&', '&amp', $feed->link ); ?>" target="_blank"><?php echo $feed->title; ?></a></h3>
		<?php endif; ?> 

		<?php if ($params->get('rssdesc', 1)) : // feed description ?>
		<div class="desc"><?php echo $feed->description; ?></div>
		<?php endif; ?>

		<?php if ($params->get('rssimage', 1) && $iUrl) : // feed image ?>
		<img src="<?php echo $iUrl; ?>" alt="<?php echo @$iTitle; ?>"/>
		<?php endif; ?>

		<?php
			$actualItems = count( $feed->items );
			$setItems    = $params->get('rssitems', 5);
		
			if ($setItems > $actualItems) {
				$totalItems = $actualItems;
			} else {
				$totalItems = $setItems;
			}
		?>

		<ul class="newsfeed<?php echo $params->get( 'moduleclass_sfx'); ?>"  >
			<?php
			$words = $params->def('word_count', 0);
			for ($j = 0; $j < $totalItems; $j ++) {
				$currItem = & $feed->items[$j];
			?>
			<?php
				if ( !is_null( $currItem->get_link() ) ) {
					if ($params->get('data_source') == 'channel_list' && $currItem->get_title() == 'General') {
						continue;
					}
					$uri = JRequest::getURI();
					$juri = & JURI::getInstance($uri);
					$juri->delVar('page');
					$juri->delVar('video_id');
					$juri->delVar('video_title');
					//$current_page_name = JURI::current();
					$current_page_name = ($params->get('relative_path') != '') ? $params->get('relative_path') : $juri->toString();
					
					$data = $currItem->get_item_tags("", 'id');
					if($params->get('data_source') == 'channel_list') {
						$channel_id = (!empty($data[0]['data'])) ? $data[0]['data'] : null;
					}
					else {
						$video_id = (!empty($data[0]['data'])) ? $data[0]['data'] : null;
					}
					
					$data = $currItem->get_item_tags("", 'image');
					$image_source = (!empty($data[0]['data'])) ? $data[0]['data'] : null;
					
					if(isset($channel_id) && $params->get('data_source') == 'channel_list') {
						$url_link = $current_page_name.'?channel_id='.$channel_id;
					}
					else {
						$channel_string = (!empty($url_channel_id)) ? 'channel_id=' . $url_channel_id . '&' : '';
						$url_link = $current_page_name.'?'.$channel_string.'video_id='.$video_id.'&video_title='.getShortTitle($currItem->get_title());
					}
				?>
			<li>
				<?php
					if ($params->get('rssitemimage', 1) && $image_source) {
				?>
				<div class="newsfeed_image">
					<a href="<?php echo $url_link; ?>">
						<img src="<?php echo $image_source; ?>" alt="<?php echo $currItem->get_title(); ?>"/>
					</a>
				</div>
				<?php } ?>
				<div class="newsfeed_item">
					<h4><a href="<?php echo $url_link; ?>"><?php echo $currItem->get_title(); ?></a></h4>
				<?php } else { ?>

				<div class="newsfeed_item">

				<?php }
					// item description
					if ($params->get('rssitemdesc', 1)) {
						// item description
						$text = $currItem->get_description();
						$text = str_replace('&apos;', "'", $text);
						$text = str_replace('%u2019', "'", $text);
	
						// word limit check
						if ($words) {
							$texts = explode(' ', $text);
							$count = count($texts);
							if ($count > $words) {
								$text = '';
								for ($i = 0; $i < $words; $i ++) {
									$text .= ' '.$texts[$i];
								}
								$text .= '...';
							}
						}
					?>
					<div class="newsfeed_description<?php echo $params->get( 'moduleclass_sfx'); ?>"  >
						<?php echo $text; ?>
					</div>
				<?php }
					if ($params->get('data_source') == 'channel_list' && $params->get('rssitemnumvideos')) {
						$num_videos = $currItem->get_item_tags('', 'num_videos');
						$num_videos = $num_videos[0]['data'];
						$video_string = ($num_videos == 1) ? 'video' : 'videos';
						echo '<div class="newsfeed_numvideos'.$params->get( 'moduleclass_sfx').'">('.$num_videos.' '.$video_string.')</div>'."\n";
					}
				?>
				</div>
			</li>
			<?php } ?>
		</ul>
		
		<?php
		if($params->get('view_more')) {
			$menuID = $params->get('view_more');
			$item = JFactory::getApplication()->getMenu()->getItem($menuID);
			$url = JRoute::_($item->link . '&Itemid=' . $item->id);
			echo "<div class='section_readmore'>\n";
				echo "<a href='{$url}'>More Videos</a>\n";
			echo "</div>\n";
		}
		
		?>
	</div>
<?php endif; ?>
