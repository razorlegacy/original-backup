<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	header ("Content-Type:text/xml");
	
	$output	= "";
	$output	.= "<?xml version='1.0' encoding='UTF-8'?>\r\n";
	if ($_GET['returnType'] == 'config') {
		$output	.= "	<Bracket>\r\n";
		$output	.=	"		<ServerDate>".date('Y-m-d H:i:s')."</ServerDate>\r\n";
		$output	.=	"		<Settings>\r\n";
		$output	.=	"			<ProjectName>{$this->bracketInfo->name}</ProjectName>\r\n";
		$output	.=	"			<GATrackingID>{$this->bracketInfo->ga_tracking_id}</GATrackingID>\r\n";
		$output	.=	"		</Settings>\r\n";
		$output	.=	"		<Skin>\r\n";
		if ($this->bracketInfo->background_image != '') {
			$output	.=	"			<BackgroundImage>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->background_image}</BackgroundImage>\r\n";
		} else {
			$output	.=	"			<BackgroundImage></BackgroundImage>\r\n";
		} 
		$output	.=	"			<BackgroundColor>".str_replace("#","",$this->bracketInfo->background_color)."</BackgroundColor>\r\n";
		$output	.=	"			<Preloader>http://".$_SERVER["HTTP_HOST"]."/components/com_bracket/views/bracket/tmpl/swfs/preloader.swf</Preloader>\r\n";
		$output	.=	"			<NetLine color='".str_replace("#","",$this->bracketInfo->netline_color)."' thickness='{$this->bracketInfo->netline_thickness}' loseColor='".str_replace("#","",$this->bracketInfo->netline_losecolor)."'></NetLine>\r\n";		
		$output	.=	"			<IntroScreen width='{$this->bracketInfo->introscreen_width}' height='{$this->bracketInfo->introscreen_height}'>\r\n";
		if ($this->bracketInfo->introscreen_background_image != '') {
			$output	.=	"				<Background>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->introscreen_background_image}</Background>\r\n";
		} else {
			$output	.=	"				<Background></Background>\r\n";
		} 
		$output	.=	"				<StartButton x='{$this->bracketInfo->introscreen_start_button_xpos}' y='{$this->bracketInfo->introscreen_start_button_ypos}'>\r\n";
		if ($this->bracketInfo->introscreen_upstate_image != '') {
			$output	.=	"					<UpState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->introscreen_upstate_image}</UpState>\r\n";
		} else {
			$output	.=	"					<UpState></UpState>\r\n";
		} 
		if ($this->bracketInfo->introscreen_overstate_image != '') {
			$output	.=	"					<OverState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->introscreen_overstate_image}</OverState>\r\n";
		} else {
			$output	.=	"					<OverState></OverState>\r\n";
		} 
		$output	.=	"				</StartButton>\r\n";
		$output	.=	"			</IntroScreen>\r\n";	
		$output	.=	"			<WinnerScreen width='{$this->bracketInfo->winnerscreen_width}' height='{$this->bracketInfo->winnerscreen_height}'>\r\n";
		if ($this->bracketInfo->winnerscreen_background_image != '') {
			$output	.=	"				<Background>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->winnerscreen_background_image}</Background>\r\n";
		} else {
			$output	.=	"				<Background></Background>\r\n";
		}
		$output	.=	"				<WinnerImage x='{$this->bracketInfo->winnerscreen_winner_image_xpos}' y='{$this->bracketInfo->winnerscreen_winner_image_ypos}' width='{$this->bracketInfo->winnerscreen_winner_image_width}' height='{$this->bracketInfo->winnerscreen_winner_image_height}'/>\r\n";
		$output	.=	"				<CloseButton x='{$this->bracketInfo->winnerscreen_close_button_xpos}' y='{$this->bracketInfo->winnerscreen_close_button_ypos}'>\r\n";
		if ($this->bracketInfo->winnerscreen_upstate_image != '') {
			$output	.=	"					<UpState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->winnerscreen_upstate_image}</UpState>\r\n";
		} else {
			$output	.=	"					<UpState></UpState>\r\n";
		}
		if ($this->bracketInfo->winnerscreen_overstate_image != '') {
			$output	.=	"					<OverState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->winnerscreen_overstate_image}</OverState>\r\n";
		} else {
			$output	.=	"					<OverState></OverState>\r\n";
		}		
		$output	.=	"				</CloseButton>\r\n";
		$output	.=	"				<PercentageText font='{$this->bracketInfo->winnerscreen_percentagetext_font_family}' size='{$this->bracketInfo->winnerscreen_percentagetext_font_size}' color='{$this->bracketInfo->winnerscreen_percentagetext_font_color}' x='{$this->bracketInfo->winnerscreen_percentagetext_xpos}' y='{$this->bracketInfo->winnerscreen_percentagetext_ypos}' bold='{$this->bracketInfo->winnerscreen_percentagetext_bold}'/>\r\n";
		$output	.=	"				<NameText font='{$this->bracketInfo->winnerscreen_nametext_font_family}' size='{$this->bracketInfo->winnerscreen_nametext_font_size}' color='".str_replace("#","",$this->bracketInfo->winnerscreen_nametext_font_color)."' x='{$this->bracketInfo->winnerscreen_nametext_xpos}' y='{$this->bracketInfo->winnerscreen_nametext_ypos}' bold='{$this->bracketInfo->winnerscreen_nametext_bold}'/>\r\n";		
		$output	.=	"			</WinnerScreen>\r\n";
		$output	.=	"			<CompareScreen width='{$this->bracketInfo->comparescreen_width}' height='{$this->bracketInfo->comparescreen_height}'>\r\n";
		if ($this->bracketInfo->comparescreen_background_image != '') {
			$output	.=	"				<Background>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->comparescreen_background_image}</Background>\r\n";
		} else {
			$output	.=	"				<Background></Background>\r\n";
		}
		$output	.=	"				<CloseButton x='{$this->bracketInfo->comparescreen_close_button_xpos}' y='{$this->bracketInfo->comparescreen_close_button_ypos}'>\r\n";
		if ($this->bracketInfo->comparescreen_upstate_image != '') {
			$output	.=	"					<UpState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->comparescreen_upstate_image}</UpState>\r\n";
		} else {
			$output	.=	"					<UpState></UpState>\r\n";
		}
		if ($this->bracketInfo->comparescreen_overstate_image != '') {
			$output	.=	"					<OverState>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->comparescreen_overstate_image}</OverState>\r\n";
		} else {
			$output	.=	"					<OverState></OverState>\r\n";
		}			
		$output	.=	"				</CloseButton>\r\n";
		$output	.=	"				<RoundLabelText font='{$this->bracketInfo->comparescreen_roundlabeltext_font_family}' size='{$this->bracketInfo->comparescreen_roundlabeltext_font_size}' color='".str_replace("#","",$this->bracketInfo->comparescreen_roundlabeltext_font_color)."' x='{$this->bracketInfo->comparescreen_roundlabeltext_xpos}' y='{$this->bracketInfo->comparescreen_roundlabeltext_ypos}' bold='{$this->bracketInfo->comparescreen_roundlabeltext_bold}'/>\r\n";
		$output	.=	"				<NameText font='{$this->bracketInfo->comparescreen_nametext_font_family}' size='{$this->bracketInfo->comparescreen_nametext_font_size}' color='".str_replace("#","",$this->bracketInfo->comparescreen_nametext_font_color)."' x='{$this->bracketInfo->comparescreen_nametext_xpos}' y='{$this->bracketInfo->comparescreen_nametext_ypos}' bold='{$this->bracketInfo->comparescreen_nametext_bold}'/>\r\n";
		$output	.=	"				<DescriptionText font='{$this->bracketInfo->comparescreen_descriptiontext_font_family}' size='{$this->bracketInfo->comparescreen_descriptiontext_font_size}' color='".str_replace("#","",$this->bracketInfo->comparescreen_descriptiontext_font_color)."' x='{$this->bracketInfo->comparescreen_descriptiontext_xpos}' y='{$this->bracketInfo->comparescreen_descriptiontext_ypos}' bold='{$this->bracketInfo->comparescreen_descriptiontext_bold}'/>\r\n";
		$output	.=	"			</CompareScreen>\r\n";				
		$output	.=	"			<Font>\r\n";
		$output	.=	"				<FontFamily>{$this->bracketInfo->font_family}</FontFamily>\r\n";
		$output	.=	"				<FontColor>".str_replace("#","",$this->bracketInfo->font_color)."</FontColor>\r\n";
		$output	.=	"				<FontBackColor>".str_replace("#","",$this->bracketInfo->font_back_color)."</FontBackColor>\r\n";
		$output	.=	"				<FontSize>{$this->bracketInfo->font_size}</FontSize>\r\n";
		$output	.=	"				<Bold>{$this->bracketInfo->font_bold}</Bold>\r\n";
		$output	.=	"			</Font>\r\n";
		$output	.=	"			<Box>\r\n";
		$output	.=	"				<BoxBorderColor>".str_replace("#","",$this->bracketInfo->box_border_color)."</BoxBorderColor>\r\n";
		$output	.=	"				<BoxBorderThickness>{$this->bracketInfo->box_border_thickness}</BoxBorderThickness>\r\n";
		$output	.=	"				<BoxGradientColor1>".str_replace("#","",$this->bracketInfo->box_gradient_color1)."</BoxGradientColor1>\r\n";
		$output	.=	"				<BoxGradientColor2>".str_replace("#","",$this->bracketInfo->box_gradient_color2)."</BoxGradientColor2>\r\n";
		$output	.=	"				<BoxGradientAngle>{$this->bracketInfo->box_gradient_angle}</BoxGradientAngle>\r\n";
		$output	.=	"				<BoxRoundness>{$this->bracketInfo->box_roundness}</BoxRoundness>\r\n";
		$output	.=	"				<BoxOverBorderColor>".str_replace("#","",$this->bracketInfo->box_over_border_color)."</BoxOverBorderColor>\r\n";
		$output	.=	"				<BoxLoseFillColor>".str_replace("#","",$this->bracketInfo->box_lose_fill_color)."</BoxLoseFillColor>\r\n";
		$output	.=	"				<DefaultImages>\r\n";
		if ($this->bracketInfo->default_box_image != '') {
			$output	.=	"					<BoxImage>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->default_box_image}</BoxImage>\r\n";
		} else {
			$output	.=	"					<BoxImage></BoxImage>\r\n";
		}		
		if ($this->bracketInfo->default_winner_image != '') {
			$output	.=	"					<WinnerImage>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketInfo->default_winner_image}</WinnerImage>\r\n";
		} else {
			$output	.=	"					<WinnerImage></WinnerImage>\r\n";
		}	
		$output	.=	"				</DefaultImages>\r\n";								
		$output	.=	"			</Box>\r\n";
		$output	.=	"		</Skin>\r\n";
		$output	.=	"		<Options>\r\n";
		$output	.=	"			<ShowInfoScreen>{$this->bracketInfo->show_info_screen}</ShowInfoScreen>\r\n";
		$output	.=	"			<ShowWinnerScreen>{$this->bracketInfo->show_winner_screen}</ShowWinnerScreen>\r\n";
		$output	.=	"			<UseOneImage>{$this->bracketInfo->use_one_image}</UseOneImage>\r\n";
		$output	.=	"			<AlowMultipleVotes>{$this->bracketInfo->allow_multiple_votes}</AlowMultipleVotes>\r\n";
		$output	.=	"		</Options>\r\n";
		$output	.=	"		<Periods>\r\n";
		$j = 1;
		for ($i = 0; $i < 5; $i++) {
			if ($i == 4) {
				$bracketCloseDate = $this->bracketDates[$i]['date'];
			} else {
				$output	.=	"			<Period id='{$j}' from='{$this->bracketDates[$i]['date']}' to='".BracketModelBracket::MySQLDateOffset($this->bracketDates[$j]['date'],0,0,-1)." 23:59:59' />\r\n";
				$j++;
			}
		}
		$output	.=	"		</Periods>\r\n";
		$output	.=	"		<CloseDate>{$bracketCloseDate}</CloseDate>\r\n";
		$output	.=	"		<Contestants>\r\n";
		for ($k = 0; $k < 16; $k++) {
			$output	.=	"			<Contestant>\r\n";
			$output	.=	"				<ID>{$this->bracketEntries[$k]['id']}</ID>\r\n";
			$output	.=	"				<Position>{$this->bracketEntries[$k]['position']}</Position>\r\n";
			$output	.=	"				<Name>{$this->bracketEntries[$k]['name']}</Name>\r\n";
			$output	.=	"				<Description>{$this->bracketEntries[$k]['description']}</Description>\r\n";
			$output	.=	"				<Images>\r\n";
			$output	.=	"					<GeneralRounds>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketEntries[$k]['image_relpath']}</GeneralRounds>\r\n";
			$output	.=	"					<Finalist>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketEntries[$k]['finalist_relpath']}</Finalist>\r\n";
			$output	.=	"					<Winner>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketEntries[$k]['winner_relpath']}</Winner>\r\n";
			$output	.=	"					<Hover>http://".$_SERVER["HTTP_HOST"]."/assets/components/com_bracket/".$_GET['cid']."/{$this->bracketEntries[$k]['hover_relpath']}</Hover>\r\n";
			$output	.=	"				</Images>\r\n";
			$output	.=	"			</Contestant>\r\n";
		}
		$output	.=	"		</Contestants>\r\n";
		$output	.= "	</Bracket>";
	} elseif ($_GET['returnType'] == 'bracketlist') {
		
		$output	.= "<data>\r\n";
		for ($i = 0; $i < 16; $i++) {
			$output	.= "	<person>\r\n";
			$output	.= "		<id>{$this->bracketVotes[$i]['entry_id']}</id>\r\n";
			$output	.= "		<period1>{$this->bracketVotes[$i]['period1']}</period1>\r\n";
			$output	.= "		<period2>{$this->bracketVotes[$i]['period2']}</period2>\r\n";
			$output	.= "		<period3>{$this->bracketVotes[$i]['period3']}</period3>\r\n";
			$output	.= "		<period4>{$this->bracketVotes[$i]['period4']}</period4>\r\n";
			$output	.= "	</person>\r\n";
		}
		$output	.= "</data>\r\n";
	
	}
	echo $output;
	die();
?>
