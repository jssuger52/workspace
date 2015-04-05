<?php
function dp_get_archive_style(){
	global $options, $ARCHIVE_STYLE;

	// Archive flag
	$current_archive_flag 	= 'top';

	// Arvhive type flag
	if (!is_home()) {
		$current_archive_flag = 'archive';
	}

	// Archive style
	$archive_style 			= $options[$current_archive_flag.'_post_show_type'];
	$archive_normal_style 	= $options[$current_archive_flag.'_excerpt_type'];

	// Archive type
	$arhive_type = esc_html(get_post_type_object(get_post_type())->name);
	// When custom post type
	if ($arhive_type === 'news' || $arhive_type == $options['news_cpt_slug_id']) {
		$archive_style = 'news';
	}

	// Common style
	switch ( $archive_style ) {
		case 'normal':
			if ($options[$current_archive_flag.'_excerpt_type'] == 'all') {
				$archive_normal_style = 'all';
			} else {
				$archive_normal_style = 'excerpt';
			}
			break;
		case 'gallery':
			$archive_style = 'gallery';
			break;
		case 'portfolio':
			$archive_style = 'portfolio';
			break;
		case 'magazine':
			$archive_style = 'magazine';
			break;
		case 'news':
			$archive_style = 'news';
			break;
		default:
			$archive_style = 'normal';
			$archive_normal_style = 'excerpt';
			break;
	}

	// Check the category display style
	if (is_category()) {
		// Only category page
		if ($options['show_type_cat_normal'] && is_category(explode(',', $options['show_type_cat_normal']))) {
			$archive_style = 'normal';
			$archive_normal_style = 'excerpt';
		} else if ($options['show_type_cat_gallery'] && is_category(explode(',', $options['show_type_cat_gallery']))) {
			$archive_style = 'gallery';
		} else if ($options['show_type_cat_portfolio'] && is_category(explode(',', $options['show_type_cat_portfolio']))) {
			$archive_style = 'portfolio';
		} else if ($options['show_type_cat_magazine'] && is_category(explode(',', $options['show_type_cat_magazine']))) {
			$archive_style = 'magazine';
		}
	}

	
	$ARCHIVE_STYLE = array(
		'current_archive_flag' 	=> $current_archive_flag,
		'archive_style' 		=> $archive_style,
		'archive_normal_style'	=> $archive_normal_style);
}
?>