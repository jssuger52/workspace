<?php
// Class
$menu_mobile_class 	= $IS_MOBILE_DP ? ' mb' : '';
$menu_float_class 	= 'header_container pos_fixed';
// $menu_float_class 	= empty($options['disable_menu_float']) ? 'header_container' : 'header_container pos_fixed';
if ($menu_mobile_class || $menu_float_class) {
	$menu_float_class = ' class="'.$menu_float_class.$menu_mobile_class.'"';
}

echo '<div id="header_container"'.$menu_float_class.'>';

// Widget
if (is_active_sidebar('widget-header-toggle-content')) :
?>
<section id="header-toggle-content" class="clearfix">
<div id="header-toggle-content-inner">
<?php dynamic_sidebar( 'widget-header-toggle-content' ); ?>
</div>
<div id="header-toggle-btn" class="icon-plus"><span>Toggle</span></div>
</section>
<?php
endif;
?>
<header id="header_area">
<div id="header_content" class="clearfix">
<hgroup>
<?php
if ($options_visual['h1title_as_what'] !== 'image') {
	echo '<h1 class="hd_title_txt"><a href="'.home_url().'/" title="'.get_bloginfo('name').'">'.dp_h1_title().'</a></h1>';
} else {
	$logo_img_url = is_ssl() ? str_replace('http:', 'https:', $options_visual['dp_title_img']) : $options_visual['dp_title_img'];
	echo '<h1 class="hd_title_img"><a href="'.home_url().'/" title="'.get_bloginfo('name').'"><img src="'.$logo_img_url.'" alt="'.dp_h1_title().'" /></a></h1>';
}
?>
<?php echo dp_h2_title('<h2>', '</h2>'); ?>
</hgroup>
<?php
include (TEMPLATEPATH . "/global-menu.php");
?>
</div>
</header>
</div>
<?php
// Top page
if (is_front_page() && !is_paged() && have_posts() && !isset( $_REQUEST['q']) ) :

	if ($options_visual['dp_header_content_type'] == "none")  return;

	// Check the half mode
	if ($options_visual['header_half_mode']) {
		$header_half_class = ' half';
	} else {
		$header_half_class = '';
	}

	// Check the display position
	if (isset($options['disable_menu_float']) && isset($options_visual['dp_header_img_fixed'])) {
		$header_fixed_class = ' img_fixed';
	}
	else if (!isset($options['disable_menu_float']) && isset($options_visual['dp_header_img_fixed'])) {
		$header_fixed_class = ' menu_img_fixed';
	}
	else if (!isset($options['disable_menu_float']) && !isset($options_visual['dp_header_img_fixed'])) {
		$header_fixed_class = ' menu_fixed';
	} else {
		$header_fixed_class = '';
	}
	// Header banner outer tag
	$banner_sec_tag = '<section class="header-banner-outer sl_loading'.$header_fixed_class.$header_half_class.'">';
	// Get header banner image
	$banner_contents_code = dp_banner_contents();

	// Check the title position
	$title_position = $options['header_banner_title_position'];
	// Site header contents
	if ( ($options_visual['dp_header_content_type'] == 2 && $options_visual['dp_slideshow_type'] == 'img_with_url') ) {
		// Disable header title and widget
		// *********** Display header ************
		echo $banner_sec_tag . $banner_contents_code;
		// Suffix
		echo '</section>';

	} else {
		// CSS class
		$title_position_class = 'pos-c';
		$half_class = $options_visual['header_half_mode'] ? ' half' : '';

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
			echo $banner_sec_tag . $banner_contents_code . '<div class="header-banner-container'.$header_fixed_class.'"><div class="header-banner-content clearfix '.$title_position.$half_class.'">' . $header_title_code;

			// **********************************
			// Header widget
			// **********************************
			if (is_active_sidebar('widget-site-header') && !$IS_MOBILE_DP ) {
				echo '<div class="dp-widget-site-hd '.$title_position_class.$half_class.'">';
				dynamic_sidebar( 'widget-site-header' );
				echo '</div>';
			}
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
