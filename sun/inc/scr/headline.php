<?php 
function dp_headline($echo = true) {
	global $IS_MOBILE_DP, $options;

	if ($options['headline_type'] == 1) return;

	$main_title = '';
	$ticker_id 	= '';
	$code 		= '';

	if ($options['headline_type'] === '2') {
		$code = '<section id="headline-sec"><div id="headline-sec-inner"><h1 class="headline-static-title">'.htmlspecialchars_decode($options['headline_static_text']).'</h1></div></section>';
	} else if ($options['headline_type'] === '3') {

		// Main Title
		$main_title = ( $options['headline_slider_main_title'] && !$IS_MOBILE_DP ) ? '<div class="headline_main_title"><h1>'.htmlspecialchars_decode($options['headline_slider_main_title']).'</h1></div>' : '';

		// For ticker
		$ticker_id = ($options['headline_slider_fx'] === '2') ? ' id="headline-ticker" ' : '';

		if ($options['headline_slider_type'] === '1') {
			// *******************
			// target : post
			// *******************
			global $post;

			// Query
			$posts = get_posts( array(
								'numberposts'	=> $options['headline_slider_num'],
								'meta_key'		=> 'is_headline',
								'meta_value'	=> array('true',true),
								'orderby'		=> $options['headline_slider_order'] // post_date or rand
								)
			);
			// Loop query posts
			foreach( $posts as $post ) {
				setup_postdata($post);

				if ($options['headline_slider_date']) {
					$code .= '<li class="slide"><a href="'.get_permalink().'"><time datetime="'. get_the_time('c').'" pubdate="pubdate">'.get_the_date().'</time> : '.get_the_title().'</a></li>';
				} else {
					$code .= '<li class="slide"><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
				}
			}
			// Reset query
			wp_reset_postdata();

		} else {
			// *******************
			// target : text
			// *******************
			
			// into array
			$slides = array();

			for ($i = 1; $i < 6; $i++) {
				if ($options['headline_slider_text'.$i]) {
					$slides[] = htmlspecialchars_decode($options['headline_slider_text'.$i]);
				}
			}
			// Shuffle
			if ($options['headline_slider_shuffle']) shuffle($slides);
			// Get headline
			foreach ($slides as $slide) {
				$code .= '<li class="slide">'.$slide.'</li>';
			}
		}

		// html
		$code = '<section id="headline-sec"><div id="headline-sec-inner">'.$main_title.'<div class="headline-slider"><ul'.$ticker_id.' class="slides">'.$code.'</ul></div></div></section>';
	}

	if ($echo) {
		echo $code;
	} else {
		return $code;
	}
}

?>