<div id="global_menu">
<?php
// Default menu
function show_wp_global_menu_list() { 
	// Global scope
	global $IS_MOBILE_DP;
?>
<nav id="global_menu_nav"><ul id="global_menu_ul">
<li <?php if (is_home()) { echo 'class="current_page_item"'; } ?>><span class="gnav-bd"></span><a href="<?php echo home_url(); ?>" title="HOME" class="icon-home"><?php _e('HOME',''); ?></a></li>
<li><span class="gnav-bd"></span><a href="<?php echo get_feed_link(); ?>" target="_blank" title="feed" class="icon-rss">RSS</a></li>
</ul></nav>
<?php
} //End Function

// Custom Menu
if (function_exists('wp_nav_menu')) {
	echo '<nav id="global_menu_nav">';
	wp_nav_menu(array(
		'theme_location'	=> 'global_menu_ul',
		'container'			=> '',
		'before_only_parent'=> $IS_MOBILE_DP ? '' : '<span class="gnav-bd"></span>',
		'menu_id'			=> 'global_menu_ul',
		'menu_class'		=> $IS_MOBILE_DP ? 'mb' : '',
		'fallback_cb'		=> 'show_wp_global_menu_list',
		'walker'			=> new description_walker()
	));
	echo '</nav>';

} else {
	// Fixed Page List
	show_wp_global_menu_list();
}

// SNS icons
if ($options['show_global_menu_sns']) {
	$facebook_list_code = $options['global_menu_fb_url'] ? '<li><a href="' . $options['global_menu_fb_url'] . '" title="Share on Facebook" target="_blank" class="icon-facebook"><span>Facebook</span></a></li>' : '';

	$twitter_list_code = $options['global_menu_twitter_url'] ? '<li><a href="' . $options['global_menu_twitter_url'] . '" title="Follow on Twitter" target="_blank" class="icon-twitter"><span>Twitter</span></a></li>' : '';

	$gplus_list_code = $options['global_menu_gplus_url'] ? '<li><a href="' . $options['global_menu_gplus_url'] . '" title="Google+" target="_blank" class="icon-gplus"><span>Google+</span></a></li>' : '';

	$rss_feed_code = $options['rss_to_feedly'] ? '<li><a href="http://cloud.feedly.com/#subscription%2Ffeed%2F'.urlencode(get_feed_link()).'" target="blank" title="Follow on feedly" class="icon-feedly"><span>Follow on feedly</span></a></li>' : '<li><a href="'. get_feed_link() .'" title="Subscribe Feed" target="_blank" class="icon-rss"><span>RSS</span></a></li>' ;

	echo '<div id="fixed_sns"><ul>'.$facebook_list_code.$twitter_list_code.$gplus_list_code.$rss_feed_code.'</ul></div>';
}

// Search form 
if ($options['show_global_menu_search']) {
?>
<div id="hd_searchform"<?php if ($IS_MOBILE_DP) echo ' class="mb"'; ?>>
<?php
	if ($options['show_floating_gcs']) {
		// Google Custom Search
		echo '<div id="dp_hd_gcs"><gcse:searchbox-only></gcse:searchbox-only></div>';
	} else {
		// Default search form
		get_search_form();
	}
?>
</div>
<?php 
}	// End of $options['show_global_menu_search']
?>
<div id="expand_float_menu" class="icon-spaced-menu"><span>Menu</span></div>
</div>