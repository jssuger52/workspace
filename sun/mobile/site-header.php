<div id="header_container" class="header_container mb-theme">
<header id="header_area">
<?php
if ($options_visual['h1title_as_what'] !== 'image') {
	echo '<h1 class="hd_title_txt"><a href="'.home_url().'/" title="'.get_bloginfo('name').'">'.dp_h1_title().'</a></h1>';
} else {
	$logo_img_url = is_ssl() ? str_replace('http:', 'https:', $options_visual['dp_title_img_mobile']) : $options_visual['dp_title_img_mobile'];
	echo '<h1 class="hd_title_img"><a href="'.home_url().'/" title="'.get_bloginfo('name').'"><img src="'.$logo_img_url.'" alt="'.dp_h1_title().'" /></a></h1>';
}
?>
</header>
<?php
// Menu button
if ($options['mb_slide_menu_position'] == 'right') {
	$sl_menu_align = 'right';
}
?>
<a href="#global_menu_nav" class="sl-menu-btn <?php echo $sl_menu_align; ?> icon-spaced-menu"><span>Menu</span></a>
</div><?php // End of id="header_container"


// Top page
if (is_front_page() && !is_paged() && have_posts() && !isset( $_REQUEST['q']) ) :

	// Flag
	$original_slider = false;
	// Header banner outer tag
	$banner_sec_tag = '<section class="header-banner-outer sl_loading">';
	// Check the title position
	$title_position = $options['header_banner_title_position'];

	// Get header banner image
	if ((bool)$options_visual['use_mobile_header']) {
		if ($options_visual['dp_header_content_type_mobile'] == "none")  {
			return;
		}

		$banner_contents_code = dp_banner_contents_mobile();

	} else {
		if ($options_visual['dp_header_content_type'] == "none")  {
			return;
		}

		$banner_contents_code = dp_banner_contents();
		if ( ($options_visual['dp_header_content_type'] == 2 && $options_visual['dp_slideshow_type'] == 'img_with_url') ) {
			$original_slider = true;
		}
	}

	// Site header contents
	if ( $original_slider ) {
		// Disable header title and widget
		// *********** Display header ************
		echo $banner_sec_tag . $banner_contents_code;
		// Suffix
		echo '</section>';

	} else {
		// CSS class
		$title_position_class = 'pos-c';

		switch ($options['header_banner_title_position']) {
			case 'left':
				$title_position_class = 'pos-l';
				break;
			case 'right':
				$title_position_class = 'pos-r';
				break;
		}

		// H2 title
		if ($options['header_img_h2']) {
			$header_title_code = '<h2 class="hd-bn-h2">'.htmlspecialchars_decode($options['header_img_h2']).'</h2>';
			// H3 title
			if ($options['header_img_h3']) {
				$header_title_code .= '<div class="hd-bn-h3">'.htmlspecialchars_decode($options['header_img_h3']).'</div>';
			}
			$header_title_code = '<header class="'.$title_position_class.'">'.$header_title_code.'</header>';

			// *********** Display header ************
			echo $banner_sec_tag . $banner_contents_code . '<div class="header-banner-container"><div class="header-banner-content clearfix '.$title_position.'">' . $header_title_code;
			// Suffix
			echo '</div></div></section>';

		} else {
			// *********** Display header ************
			echo $banner_sec_tag . $banner_contents_code;
			// Suffix
			echo '</section>';
		}
	}

endif; // end of (is_front_page() && !is_paged())
?>
