<?php
/*******************************************************
* title tag
*******************************************************/
/** ===================================================
* Create site title tag.
*
* @param	string $before_tag 	before title
* @param	string $end_tag 	after title
* @return	none
*/
function dp_site_title($before_tag="", $end_tag="", $if_echo = true) {
	global $options;

	$sitename = get_bloginfo('name');
	$separate = " | ";

	if ($options['enable_title_site_name'] == true ) {
		if (is_home()) {
			$sitename = $options['title_site_name_top'];
		} else {
			$sitename = $options['title_site_name'];
		}
		$separate = $options['title_site_name_separate'];
	}

	if ($if_echo) {
		echo dp_create_title($sitename, $separate, $before_tag, $end_tag);
	} else {
		return dp_create_title($sitename, $separate, $before_tag, $end_tag);
	}
}

/*******************************************************
* h2 tag
*******************************************************/
/** ===================================================
* Create h2 title tag.
*
* @param	none
* @return	none
*/
function dp_h2_title($before = '<h2>', $after = '</h2>') {
	global $options;

	$caption = get_bloginfo('name');

	if ($options['enable_h2_title']) {
		$caption = htmlspecialchars_decode($options['h2_title']);
	}
	if ($caption) {
		$caption = $before . $caption . $after;
	} else {
		$caption = '';
	}
	return $caption;
}

/*******************************************************
* create title
*******************************************************/
/** ===================================================
* Create site title tag.
*
* @param	string $before_tag 	before title
* @param	string $end_tag 	after title
* @return	string $return_code HTML tag
*/
function dp_create_title($sitename, $separate, $before_tag="", $end_tag="") {
	$return_code = '';
	$title = '';

	if (is_home()) {
		if (is_paged()) {
			$title = $sitename . $separate
				. 'Page ' .  intval(get_query_var('paged'));
			$sitename = '';
		}
	} else if (is_category()) {
		if (is_paged()) {
			$title = wp_title('', false, 'right') 
				. '( ' . intval(get_query_var('paged')) . ' )' . $separate;
		} else {
			$title = wp_title($separate, false, 'right');
		}
	} else if (is_year()) {
		if (is_paged()) {
			$title =  __('Archive of the year ', 'DigiPress') 
				. get_the_time(__('Y', 'DigiPress')) 
				.'( ' .  intval(get_query_var('paged')) . ' )' 
				. $separate;
		} else {
			$title = __('Archive of the year ', 'DigiPress') 
				. get_the_time(__('Y', 'DigiPress'))
				. $separate;
		}
	} else if (is_month()) {
		if (is_paged()) {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n', 'DigiPress'))
				. '( ' . intval(get_query_var('paged')) . ' )' 
				. $separate;
		} else {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n', 'DigiPress')) 
				. $separate;
		}
	} else if (is_day()) {
		if (is_paged()) {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n/j', 'DigiPress')) 
				. '( ' . intval(get_query_var('paged')) . ' )'
				. $separate;
		} else {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n/j', 'DigiPress'))
				. $separate;
		}
	} else if (is_time()) {
		if (is_paged()) {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n/j', 'DigiPress'))
				. '( ' . intval(get_query_var('paged')) . ' )'
				. $separate;
		} else {
			$title = __('Archive of the ', 'DigiPress') 
				. get_the_time(__('Y/n/j', 'DigiPress'))
				. $separate;
		}
	} else if (is_tag()) {
		if (is_paged()) {
			$title = wp_title(__(' Tagged posts:', 'DigiPress'), false, 'right') 
				. '( ' . intval(get_query_var('paged')) . ' )' . $separate;
		} else {
			$title = wp_title(__(' Tagged posts:', 'DigiPress'), false, 'right') 
				. $separate;
		}
	} else if (is_search()) {
		if (is_paged()) {
			$title = wp_title('', false, 'right') 
				. '( ' . intval(get_query_var('paged')) . ' )' . $separate;
		} else {
			$title = wp_title($separate, false, 'right');
		}
	} else if (is_singular()) {
		if (is_paged()) {
			$title = wp_title('', false, 'right') 
				. '( ' . intval(get_query_var('paged')) . ' )' . $separate;
		} else {
			$title = wp_title($separate, false, 'right');
		}
	} else if (is_404()) {
		$title = __("Not Found.", 'DigiPress') . $separate;
	} else {
		if (is_paged()) {
			$title = wp_title('', false, 'right') 
				. '( ' . intval(get_query_var('paged')) . ' )' . $separate;
		} else {
			$title = wp_title($separate, false, 'right');
		}
	}

	//title HTML tag
	$return_code =  $before_tag . $title . $sitename . $end_tag;
	return $return_code;
}
?>