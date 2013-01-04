<?php
	defined('_JEXEC') or die('Restricted access'); 
	function h($content){
		echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
	}
 echo '<?xml version="1.0" encoding="UTF-8"?>';
?><ColoringBook>
		<Settings>
			<ProjectName><?php 
				h($this->coloringBook->name); 
			?></ProjectName>
			<GATrackingID></GATrackingID>
			<Standalone>1</Standalone>
		</Settings>
		<Skin>
			<BookSize width="<?php 
				h($this->coloringBook->embed_width);
				?>" height="<?php 
				h($this->coloringBook->embed_height);
			?>"/>
			<Preloader><?php h($this->server) ?>/components/com_coloringbooks/swfs/preloader.swf</Preloader>
			<Menu>
        	<Template useEmail="0"><?php h($this->server) ?>/components/com_coloringbooks/swfs/menu_empty.swf</Template>
        	<Size width="<?php 
				h($this->coloringBook->embed_width);
			?>" height="66"/>
            <BackgroundColor></BackgroundColor>
            <BackgoundImage><?php h($this->server) ?>/components/com_coloringbooks/menu/background.png</BackgoundImage>
            <Buttons>
            	<Colors>
                	<UpState><?php h($this->server) ?>/components/com_coloringbooks/menu/standard/colors.png</UpState>
					<OverState><?php h($this->server) ?>/components/com_coloringbooks/menu/hover/colors.png</OverState>
                </Colors>
                <Tools>
                	<UpState><?php h($this->server) ?>/components/com_coloringbooks/menu/standard/tools.png</UpState>
					<OverState><?php h($this->server) ?>/components/com_coloringbooks/menu/hover/tools.png</OverState>
                </Tools>
                <Pictures>
                	<UpState><?php h($this->server) ?>/components/com_coloringbooks/menu/standard/pics.png</UpState>
					<OverState><?php h($this->server) ?>/components/com_coloringbooks/menu/hover/pics.png</OverState>
                </Pictures>
                <Clear>
                	<UpState><?php h($this->server) ?>/components/com_coloringbooks/menu/standard/clear.png</UpState>
					<OverState><?php h($this->server) ?>/components/com_coloringbooks/menu/hover/clear.png</OverState>
                </Clear>
                <Save>
                	<UpState><?php h($this->server) ?>/components/com_coloringbooks/menu/standard/save.png</UpState>
					<OverState><?php h($this->server) ?>/components/com_coloringbooks/menu/hover/save.png</OverState>
                </Save>
            </Buttons>
        </Menu> 
		<BackgroundImage fitSize="1" center="0"></BackgroundImage>
		<BackgroundColor></BackgroundColor>
        <DrawingPanel width="<?php 
				h($this->coloringBook->embed_width);
			?>" height="<?php 
				h($this->coloringBook->embed_height - 66);
			?>" color="">
        	<BackImage widthDifference="30" heightDifference="30"><?php h($this->server) ?>/components/com_coloringbooks/img/box.png</BackImage>
        </DrawingPanel> 
        <Cursors>
        	<Brush><?php h($this->server) ?>/components/com_coloringbooks/swfs/brush.swf</Brush>
            <Eraser><?php h($this->server) ?>/components/com_coloringbooks/img/eraser.png</Eraser>
            <Picker><?php h($this->server) ?>/components/com_coloringbooks/img/picker.png</Picker>
        </Cursors>
        <Tools size1="5" size2="10" size3="15" alpha="1"/></Skin><Images><?php 
	$i = 0;
	foreach($this->coloringBook->pages as $page){
		$i++;
		?><Image>
				<ID><?php h($page->id); ?></ID>
				<Thumb><?php h($this->server.$page->uri_thumb);?></Thumb>
				<Large><?php h($this->server.$page->uri);?></Large>
		</Image><?php
	}
?></Images></ColoringBook>