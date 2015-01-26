	<script>
		jssor_slider_starter = function (containerId) {
			var _CaptionTransitions = [];
			_CaptionTransitions["L"] = { $Duration: 900, x: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["R"] = { $Duration: 900, x: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["T"] = { $Duration: 900, y: 0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["B"] = { $Duration: 900, y: -0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["ZMF|10"] = { $Duration: 900, $Zoom: 11, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 };
			_CaptionTransitions["RTT|10"] = { $Duration: 900, $Zoom: 11, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseOutQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} };
			_CaptionTransitions["RTT|2"] = { $Duration: 900, $Zoom: 3, $Rotate: 1, $Easing: { $Zoom: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad }, $Opacity: 2, $Round: { $Rotate: 0.5} };
			_CaptionTransitions["RTTL|BR"] = { $Duration: 900, x: -0.6, y: -0.6, $Zoom: 11, $Rotate: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} };
			_CaptionTransitions["CLIP|LR"] = { $Duration: 900, $Clip: 15, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic }, $Opacity: 2 };
			_CaptionTransitions["MCLIP|L"] = { $Duration: 900, $Clip: 1, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };
			_CaptionTransitions["MCLIP|R"] = { $Duration: 900, $Clip: 2, $Move: true, $Easing: { $Clip: $JssorEasing$.$EaseInOutCubic} };

			var options = {
				$FillMode: 2,						//[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
				$AutoPlay: true,					//[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
				$AutoPlayInterval: 10000,				//[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
				$PauseOnHover: 1,					//[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

				$ArrowKeyNavigation: true,				//[Optional] Allows keyboard (arrow key) navigation or not, default value is false
				$SlideEasing: $JssorEasing$.$EaseOutQuint,		//[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
				$SlideDuration: 800,					//[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
				$MinDragOffsetToSlide: 20,				//[Optional] Minimum drag offset to trigger slide , default value is 20
				//$SlideWidth: 600,					//[Optional] Width of every slide in pixels, default value is width of 'slides' container
				//$SlideHeight: 300,					//[Optional] Height of every slide in pixels, default value is height of 'slides' container
				$SlideSpacing: 0,					//[Optional] Space between each slide in pixels, default value is 0
				$DisplayPieces: 1,					//[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
				$ParkingPosition: 0,					//[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
				$UISearchMode: 1,					//[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
				$PlayOrientation: 1,					//[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
				$DragOrientation: 1,					//[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

				$CaptionSliderOptions: {				//[Optional] Options which specifies how to animate caption
					$Class: $JssorCaptionSlider$,			//[Required] Class to create instance to animate caption
					$CaptionTransitions: _CaptionTransitions,	//[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
					$PlayInMode: 1,					//[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
					$PlayOutMode: 3					//[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
				},

				$BulletNavigatorOptions: {				//[Optional] Options to specify and enable navigator or not
					$Class: $JssorBulletNavigator$,			//[Required] Class to create navigator instance
					$ChanceToShow: 2,				//[Required] 0 Never, 1 Mouse Over, 2 Always
					$AutoCenter: 1,					//[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
					$Steps: 1,					//[Optional] Steps to go for each navigation request, default value is 1
					$Lanes: 1,					//[Optional] Specify lanes to arrange items, default value is 1
					$SpacingX: 8,					//[Optional] Horizontal space between each item in pixel, default value is 0
					$SpacingY: 8,					//[Optional] Vertical space between each item in pixel, default value is 0
					$Orientation: 1,				//[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
					$Scale: false,					//Scales bullets navigator or not while slider scale
				},

				$ArrowNavigatorOptions: {				//[Optional] Options to specify and enable arrow navigator or not
					$Class: $JssorArrowNavigator$,			//[Requried] Class to create arrow navigator instance
					$ChanceToShow: 1,				//[Required] 0 Never, 1 Mouse Over, 2 Always
					$AutoCenter: 2,					//[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
					$Steps: 1					//[Optional] Steps to go for each navigation request, default value is 1
				}
			};

			var jssor_slider = new $JssorSlider$(containerId, options);

		};
	</script>
	<div id="slider_container">
		<!-- Loading Screen -->
		<div u="loading" style="position: absolute; top: 0px; left: 0px;">
			<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
				top: 0px; left: 0px; width: 100%; height: 100%;">
			</div>
			<div style="position: absolute; display: block; background: url(<?php echo fileurl('lib/skins/thunder/images/loading.gif');?>) no-repeat center center;
				top: 0px; left: 0px; width: 100%; height: 100%;">
			</div>
		</div>
		<!-- Slides Container -->
		<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 970px;
			height: 450px; overflow: hidden;">
			<div>
				<img u="image" src="<?php echo fileurl('lib/skins/thunder/images/slider/1.jpeg');?>" />
				<!--<img src="../img/new-site/c-phone.png" style="position: absolute; width: 445px; height: 300px; top: 100px; left: 600px; background-color: transparent;" />-->
				<!--<div style="position: absolute; width: 480px; height: 120px; top: 30px; left: 30px; padding: 5px;
					text-align: left; line-height: 60px; text-transform: uppercase; font-size: 50px;
					color: #FFFFFF;">Touch Swipe Slider
				</div>
				<div style="position: absolute; width: 480px; height: 120px; top: 300px; left: 30px; padding: 5px;
					text-align: left; line-height: 36px; font-size: 30px;
					color: #FFFFFF;">
					Build your slider with anything, includes image, content, text, html, photo, picture
				</div>-->
			</div>
			<div>
				<img u="image" src="<?php echo fileurl('lib/skins/thunder/images/slider/2.jpeg');?>" />
				<!--<img src="../img/new-site/c-phone.png" style="position: absolute; width: 445px; height: 300px; top: 100px; left: 600px; background-color: transparent;" />-->
				<!--<div style="position: absolute; width: 480px; height: 120px; top: 30px; left: 30px; padding: 5px;
					text-align: left; line-height: 60px; text-transform: uppercase; font-size: 50px;
					color: #FFFFFF;">Touch Swipe Slider
				</div>
				<div style="position: absolute; width: 480px; height: 120px; top: 300px; left: 30px; padding: 5px;
					text-align: left; line-height: 36px; font-size: 30px;
					color: #FFFFFF;">
					Build your slider with anything, includes image, content, text, html, photo, picture
				</div>-->
			</div>
		</div>

		<!-- Bullet Navigator Skin Begin -->
		<style>
			/* jssor slider bullet navigator skin 21 css */
			/*
			.jssorb21 div           (normal)
			.jssorb21 div:hover     (normal mouseover)
			.jssorb21 .av           (active)
			.jssorb21 .av:hover     (active mouseover)
			.jssorb21 .dn           (mousedown)
			*/
			.jssorb21 div, .jssorb21 div:hover, .jssorb21 .av
			{
				background: url(<?php echo fileurl('lib/skins/thunder/images/b21.png');?>) no-repeat;
				overflow:hidden;
				cursor: pointer;
			}
			.jssorb21 div { background-position: -5px -5px; }
			.jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
			.jssorb21 .av { background-position: -65px -5px; }
			.jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
		</style>
		<!-- bullet navigator container -->
		<div u="navigator" class="jssorb21" style="position: absolute; bottom: 26px; left: 6px;">
			<!-- bullet navigator item prototype -->
			<div u="prototype" style="POSITION: absolute; WIDTH: 19px; HEIGHT: 19px; text-align:center; line-height:19px; color:White; font-size:12px;"></div>
		</div>
		<!-- Bullet Navigator Skin End -->

		<!-- Arrow Navigator Skin Begin -->
		<style>
			/* jssor slider arrow navigator skin 21 css */
			/*
			.jssora21l              (normal)
			.jssora21r              (normal)
			.jssora21l:hover        (normal mouseover)
			.jssora21r:hover        (normal mouseover)
			.jssora21ldn            (mousedown)
			.jssora21rdn            (mousedown)
			*/
			.jssora21l, .jssora21r, .jssora21ldn, .jssora21rdn
			{
				position: absolute;
				cursor: pointer;
				display: block;
				background: url(<?php echo fileurl('lib/skins/thunder/images/a21.png');?>) center center no-repeat;
				overflow: hidden;
			}
			.jssora21l { background-position: -3px -33px; }
			.jssora21r { background-position: -63px -33px; }
			.jssora21l:hover { background-position: -123px -33px; }
			.jssora21r:hover { background-position: -183px -33px; }
			.jssora21ldn { background-position: -243px -33px; }
			.jssora21rdn { background-position: -303px -33px; }
		</style>
		<!-- Arrow Left -->
		<span u="arrowleft" class="jssora21l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
		</span>
		<!-- Arrow Right -->
		<span u="arrowright" class="jssora21r" style="width: 55px; height: 55px; top: 123px; right: 8px">
		</span>
		<!-- Arrow Navigator Skin End -->
		<a style="display: none" href="http://www.jssor.com">bootstrap carousel</a>
	</div>
	<script>
		jssor_slider_starter('slider_container');
	</script>
	
<div id="mainbox">
<?php

	// Show the News module, call the function ShowNewsFront
	//	This is in the modules/Frontpage folder
	
	MainController::Run('News', 'ShowNewsFront', 5);
?>
</div>
<div id="sidebar">
	<h3>Recent Reports</h3>
	
	<?php MainController::Run('PIREPS', 'RecentFrontPage', 5); ?>

	<h3>Newest Pilots</h3>
	
	<?php MainController::Run('Pilots', 'RecentFrontPage', 5); ?>
	
	<h3>Users Online</h3>
	<p><i>There have been <?php echo count($usersonline)?> user(s), and <?php echo count($guestsonline);?> guest(s) online in the past <?php echo Config::Get('USERS_ONLINE_TIME')?> minutes.</i></p>
	
	<?php
	/* $usersonline also has the list of users -
		really simple example
		
		Or if you're not on the frontpage:
		$usersonline = StatsData::UsersOnline();
		
	
	foreach($usersonline as $pilot)	
	{
		echo "{$pilot->firstname} {$pilot->lastname}<br />";
	}
	*/
	?>
	
</div>