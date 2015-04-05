<?php
/** ===================================================
* Echo slider Javascript
*
* @return	
*/
function make_slider_js($params = array(
								'navigation_class'	=> 'hd-slide-nav' )) {
	global $options, $options_visual, $IS_MOBILE_DP;

	extract($params);
	
	$transition		= 'transition:"'.$options_visual['dp_slideshow_effect'].'",';
	$duration  		= 'duration:'.$options_visual['dp_slideshow_speed'].',';
	$transitionSpeed = 'transitionSpeed:'.$options_visual['dp_slideshow_transition_time'].',';

	$progressColor 	= 'progressColor:"'.$options_visual['base_link_color'].'",';
	$controlColor 	= 'controlBackgroundColor:"'.$options_visual['base_link_color'].'",';
	$navigationColor = 'navigationColor:"'.$options_visual['base_link_color'].'",navigationHoverColor:"'.$options_visual['base_link_hover_color'].'",';

	$pauseOnHover 	= 'pauseOnHover:false,';
	$control 		= 'showControl:false,';
	$navigation 	= 'showNavigation:false,';
	$showProgress 	= 'showProgress:false,';
	$onReady 		= 'onReady:hdSlideshowOnReady';

	// Control button
	if ($options_visual['dp_slideshow_control_button'] && !IS_MOBILE_DP()) {
		$control = 'showControl:true,'.$controlColor;
	}
	// Navigation
	if (!$IS_MOBILE_DP) {
		switch ($options_visual['dp_slideshow_pagination']) {
			case 'none':
				$navigation = 'showNavigation:false,';
				break;
			case 'number':
				$navigation = 'showNavigation:true,navigationType:"number",positionNavigation:"in-center-bottom",'.$navigationColor;
				break;
			case 'circle':
				$navigation = 'showNavigation:true,navigationType:"circle",positionNavigation:"in-center-bottom",'.$navigationColor;
				break;
			case 'square':
				$navigation = 'showNavigation:true,navigationType:"square",positionNavigation:"in-center-bottom",'.$navigationColor;
				break;
			case 'thumb':
				$navigation = 'showNavigation:false,classNavigation:"'.$navigation_class.'",';
				break;
		}
	}

	// Pause on hover 
	if ($options_visual['dp_slideshow_hover_pause'] ) {
		$pauseOnHover 	= 'pauseOnHover:true,';
	}
	// Disable function
	if ( $options_visual['dp_slideshow_type'] == 'header_img' && !empty($options['header_img_h2']) ) {
		$pauseOnHover 	= 'pauseOnHover:false,';
		$control 		= 'showControl:false,';
		$navigation 	= 'showNavigation:false,classNavigation:undefined,';

	}

	// Progress bar
	if ($options_visual['dp_slideshow_progress_bar'] && !IS_MOBILE_DP()) {
		$showProgress 	= 'showProgress:true,'.$progressColor;
	}
	
	// Js
	$js_code =
'<script>
j$(document).ready(function(){
	j$("#hd-slideshow").DrSlider({'.
		$transition.$duration.$transitionSpeed.$pauseOnHover.$control.$navigation.$showProgress.$onReady.'
	});
});
</script>';
	$js_code = str_replace(array("\r\n","\r","\n","\t"), '', $js_code);
	return $js_code;
}


/** ===================================================
* Echo slider Javascript for Mobile theme
*
* @return	
*/
function make_slider_js_mobile($params = array(
								'navigation_class'	=> 'hd-slide-nav' )) {
	global $options_visual;

	extract($params);
	
	$transition		= 'transition:"'.$options_visual['dp_slideshow_effect_mobile'].'",';
	$duration  		= 'duration:'.$options_visual['dp_slideshow_speed_mobile'].',';
	$transitionSpeed = 'transitionSpeed:'.$options_visual['dp_slideshow_transition_time_mobile'].',';

	$pauseOnHover 	= 'pauseOnHover:false,';
	$control 		= 'showControl:false,';
	$navigation 	= 'showNavigation:false,classNavigation:undefined,';
	$showProgress 	= 'showProgress:false,';
	$onReady 		= 'onReady:hdSlideshowOnReady';
	
	// Js
	$js_code =
'<script>
j$(document).ready(function(){
	j$("#hd-slideshow").DrSlider({'.
		$transition.$duration.$transitionSpeed.$pauseOnHover.$control.$navigation.$showProgress.$onReady.'
	});
});
</script>';
	$js_code = str_replace(array("\r\n","\r","\n","\t"), '', $js_code);
	return $js_code;
}

/** ===================================================
* Create slideshow source
*
*/
function dp_slideshow_source( $params = array(
								'width' 	=> 980, 
								'height' 	=> 650,
								'navigation_class'	=> 'hd-slide-nav',
								'control_class' 	=> 'hd-slide-control' )) {
	global $options, $options_visual, $IS_MOBILE_DP;
	extract($params);

	// Thumbnail size
	if ($IS_MOBILE_DP) {
		$width 	= 680;
		$height = 480;
	}

	$type 		= $options_visual['dp_slideshow_type'];
	$num 		= $options_visual['dp_number_of_slideshow'];
	$orderby 	= $options_visual['dp_slideshow_orderby'];

	$data_link 	= '';
	$data_img 	= '';
	$caption 	= '';

	$slideshow_code 	= '';
	$navigation_code 	= '';
	$control_code 		= '';

	switch ($type) {
		case 'post':
			global $post;
			// Query
			$posts = get_posts( array(
									'numberposts'	=> $num,
									'meta_key'		=> 'is_slideshow',
									'meta_value'	=> array("true", true),
									'orderby'		=> $orderby // or rand
									)
			);

			// title animation params
			$title_time 	= $options_visual['slideshow_post_title_time'];
			$title_start_x 	= $options_visual['slideshow_post_title_start_pos_x'];
			$title_start_y 	= $options_visual['slideshow_post_title_start_pos_y'];
			$title_end_x 	= $options_visual['slideshow_post_title_end_pos_x'];
			$title_end_y 	= $options_visual['slideshow_post_title_end_pos_y'];
			$title_fx 		= $options_visual['slideshow_post_title_fx'];
			
			// Moving position
			$data_pos 	= '';
			if ($title_fx == 'move') {
				$data_pos = '[\''.$title_start_y.'%\', \''.$title_start_x.'%\', \''.$title_end_y.'%\', \''.$title_end_x.'%\']';
			} else {
				$data_pos = '[\''.$title_start_y.'%\', \''.$title_start_x.'%\']';
			}
			// mobile
			if ($IS_MOBILE_DP) {
				$data_pos = "['25%','2%']";
				$title_fx = "fadein";
			}

			// Loop query posts
			foreach( $posts as $post ) : setup_postdata($post);
				// Reset
				$data_link 	= '';
				$data_img 	= '';
				$data_bg 	= '';
				$caption 	= '';

				$slide_img_url 	= get_post_meta(get_the_ID(), 'slideshow_image_url');

				if ($slide_img_url[0]) {
					// Add image
					$data_img 	= is_ssl() ? str_replace('http:', 'https:', $slide_img_url[0]) : $slide_img_url[0];
					// Thumbnail
					if ($options_visual['dp_slideshow_pagination'] == 'thumb') {
						$data_thumb .= '<img src="'.$data_img.'" />';
					}
				} else {
					if(has_post_thumbnail()) {
						$image_id = get_post_thumbnail_id();
						$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true); 
						// Add image
						$data_img = $image_url[0];
						// Thumbnail
						if ($options_visual['dp_slideshow_pagination'] == 'thumb') {
							$data_thumb .= '<img src="'.$image_url[0].'" />';
						}
					} else {
						preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"]/i', get_post(get_the_ID())->post_content, $imgurl);
						if ($imgurl[1][0]) {
							// Add image
							$data_img = is_ssl() ? str_replace('http:', 'https:', $imgurl[1][0]) : $imgurl[1][0];
							// Thumbnail
							if ($options_visual['dp_slideshow_pagination'] == 'thumb') {
								$data_thumb .= '<img src="'.$data_img.'" />';
							}
						} else {
							$strPattern	=	'/(\.gif|\.jpg|\.jpeg|\.png)$/';
							
							if ($handle = opendir(DP_THEME_DIR . '/img/slideshow')) {
								$image;
								$cnt = 0;
								while (false !== ($file = readdir($handle))) {
									if ($file != "." && $file != "..") {
										//Image file only
										if (preg_match($strPattern, $file)) {
											$image[$cnt] = DP_THEME_URI . '/img/slideshow/'.$file;
											//count
											$cnt ++;
										}
									}
								}
								closedir($handle);
							}
							if ($cnt > 0) {
								$randInt = rand(0, $cnt - 1);
								// Add image
								$data_img = is_ssl() ? str_replace('http:', 'https:', $image[$randInt]) : $image[$randInt];
								// Thumbnail
								if ($options_visual['dp_slideshow_pagination'] == 'thumb') {
									$data_thumb .= '<img src="'.$image[$randInt].'" />';
								}
							}
						}
					}
				}

				//Titile
				$caption = get_the_title();
				// Link
				$data_link = get_permalink();
				
				// ********** Slideshow code **********
				$slideshow_code .= '<div class="hd-slide-item-div" data-lazy-background="'.$data_img.'"><h3 class="hd-slide-post-title" data-pos="'.$data_pos.'" data-duration="'.$title_time.'" data-effect="'.$title_fx.'"><a href="'.$data_link.'">'.$caption.'</a></h3></div>';
			endforeach;
			// Reset Query
			wp_reset_postdata();
			break;

		case 'header_img':
			$arrImages = array();

			$data_img 	= '';
			$data_thumb = '';

			// Get images
			$images = dp_get_uploaded_images("header");
			$images = $images[0];
			$cnt = count($images);

			if (0 < $cnt && $cnt <= $num) {
				$arrImages = $images;
			} else if ($cnt > $num) {
				for ($i=0; $i < 7; $i++) { 
					array_push($arrImages, $images[$i]);	
				}
			}

			// Loop each images
			foreach ($arrImages as $value) {
				$slideshow_code .= '<img data-lazy-src="'.$value.'" />';
				$data_thumb .= '<img src="'.$value.'" />';
			}
			break;

		case 'img_with_url':
			$data_img 	= '';
			$data_thumb = '';
			$content 	= '';

			for ($i = 1; $i < 6; $i++) { 
				if ($options_visual['slideshow_img'.$i]) {
					// Image
					$data_img = $options_visual['slideshow_img'.$i];
					// Thumbnail
					if ($options_visual['dp_slideshow_pagination'] == 'thumb') {
						$data_thumb .= '<img src="'.$options_visual['slideshow_img'.$i].'" />';
					} else {
						$data_thumb = '';
					}
					// Content
					if ($options_visual['slideshow_caption'.$i] && !$IS_MOBILE_DP) {
						$content = htmlspecialchars_decode($options_visual['slideshow_caption'.$i]);
					} else {
						$content = '';
					}
					// ********** Slideshow code **********
					$slideshow_code .= '<div class="hd-slide-item-div" data-lazy-background="'.$data_img.'">'.$content.'</div>';
				}
			}
			break;
	}

	// Thumbnail
	if ( !$IS_MOBILE_DP ) {
		if ( ($type == 'header_img' && empty($options['header_img_h2'])) || $type == 'img_with_url') {
			if ( ($options_visual['dp_slideshow_pagination'] == 'thumb') && !($options_visual['dp_slideshow_type'] == 'header_img' && $options['header_img_h2']) ) {
				$navigation_code = '<div class="'.$navigation_class.'">'.$data_thumb.'</div>';
			}
		}
	}

	// Display
	return array(
			'slideshow_code' 	=> $slideshow_code,
			'navigation_code' 	=> $navigation_code);
}


/** ===================================================
* Create slideshow source for mobile theme
*
*/
function dp_slideshow_source_mobile( $params = array(
								'width' 	=> 680, 
								'height' 	=> 480,
								'navigation_class'	=> 'hd-slide-nav',
								'control_class' 	=> 'hd-slide-control' )) {
	global $options_visual;
	extract($params);
	$num 		= $options_visual['dp_number_of_slideshow_mobile'];

	$data_link 	= '';
	$data_img 	= '';
	$caption 	= '';

	$slideshow_code 	= '';
	$navigation_code 	= '';
	$control_code 		= '';

	$arrImages = array();
	$data_img 	= '';
	$data_thumb = '';

	// Get images
	$images = dp_get_uploaded_images("header/mobile");
	$images = $images[0];
	$cnt = count($images);

	if (0 < $cnt && $cnt <= $num) {
		$arrImages = $images;
	} else if ($cnt > $num) {
		for ($i=0; $i < 7; $i++) { 
			array_push($arrImages, $images[$i]);	
		}
	}

	// Loop each images
	foreach ($arrImages as $value) {
		$slideshow_code .= '<img data-lazy-src="'.$value.'" />';
	}

	// Display
	return $slideshow_code;
}



/** ===================================================
* Show the Banner Contents
*
* @return	none
*/
function dp_banner_contents() {
	global $options,$options_visual;
	//Get options
	$type			= $options_visual['dp_header_content_type'];
	$half_class 	= $options_visual['header_half_mode'] ? ' half' : '';
	$banner_contents	= '';

	// Top page
	switch ($type) {
		case 1:	// Header image
			if ($options_visual['dp_header_img'] === 'random') {

				// Get images
				$images = dp_get_uploaded_images("header");
				$images = $images[0];
				$cnt = count($images);

				if ($cnt > 0) {
					//show image
					$rnd = rand(0, $cnt - 1);
					$banner_contents = '<img src="'.$images[$rnd].'" width="100%" />';
				} else {
					$banner_contents = '<img src="'.DP_THEME_URI.'/img/header/header1.jpg" width="100%" />';
				}
			} else {
				if ($options_visual['dp_header_img'] === 'none' || !$options_visual['dp_header_img']) {
					$banner_contents = '<img src="'.DP_THEME_URI.'/img/header/header1.jpg" />';
				} else {
					$banner_contents = '<img src="'.$options_visual['dp_header_img'].'" />';
				}
			}
			$banner_contents = '<div class="header-banner-inner hd-img"><div class="img-filter-div">'.$banner_contents.'<div class="img-mask"></div></div></div>';
			break;

		case 2:	// Slideshow (custom image and link)
			$slideshow_content = dp_slideshow_source();
			
			$slideshow_type_class = '';
			if ($options_visual['dp_slideshow_type'] != 'header_img') {
				$slideshow_type_class = ' slideshow-type-data';
			}
			// Slideshow source
			$banner_contents = '<div class="header-banner-inner hd-slideshow"><div id="hd-slideshow" class="img-filter-div hd-slideshow'.$slideshow_type_class.$half_class.'">'.$slideshow_content['slideshow_code'].'</div>'.$slideshow_content['navigation_code'].'</div>';
			break;
	}

	// Display
	return $banner_contents;
}


/** ===================================================
* Show the Banner Contents for Mobile theme
*
* @return	none
*/
function dp_banner_contents_mobile() {
	global $options,$options_visual;
	//Get options
	$type			= $options_visual['dp_header_content_type_mobile'];
	$banner_contents	= '';

	// Top page
	switch ($type) {
		case 1:	// Header image
			if ($options_visual['dp_header_img_mobile'] === 'random') {

				// Get images
				$images = dp_get_uploaded_images("header/mobile");
				$images = $images[0];
				$cnt = count($images);

				if ($cnt > 0) {
					//show image
					$rnd = rand(0, $cnt - 1);
					$banner_contents = '<img src="'.$images[$rnd].'" width="100%" />';
				} else {
					$banner_contents = '<img src="'.DP_THEME_URI.'/img/header/header1.jpg" width="100%" />';
				}
			} else {
				if ($options_visual['dp_header_img_mobile'] === 'none' || !$options_visual['dp_header_img_mobile']) {
					// Normal header image
					$banner_contents = '<img src="'.DP_THEME_URI.'/img/header/header1.jpg" />';
				} else {
					// Normal header image
					$banner_contents = '<img src="'.$options_visual['dp_header_img_mobile'].'" />';
				}
			}
			$banner_contents = '<div class="header-banner-inner hd-img"><div class="img-filter-div">'.$banner_contents.'<div class="img-mask"></div></div></div>';
			break;

		case 2:	// Slideshow (custom image and link)
			$slideshow_content = dp_slideshow_source_mobile();
			// Slideshow source
			$banner_contents = '<div class="header-banner-inner hd-slideshow"><div id="hd-slideshow" class="img-filter-div hd-slideshow">'.$slideshow_content.'</div></div>';
			break;
	}

	// Display
	return $banner_contents;
}
?>