<nav id="global_menu_nav">
<div class="global_menu_div">
<?php
// **********************************
// Default menu
// **********************************
function show_wp_global_menu_list_mb() { 
?>
<ul id="global_menu_ul" class="mb-theme">
<li <?php if (is_home()) { echo 'class="current_page_item"'; } ?>><a href="<?php echo home_url(); ?>" title="HOME" class="icon-home"><?php _e('HOME',''); ?></a></li>
<li><a href="<?php echo get_feed_link(); ?>" target="_blank" title="feed" class="icon-rss">RSS</a></li>
</ul>
<?php
} //End Function



// **********************************
// Custom Menu
// **********************************
if (function_exists('wp_nav_menu')) {
	wp_nav_menu(array(
		'theme_location'	=> 'top_menu_mobile',
		'container'			=> '',
		'before_only_parent'=> '',
		'menu_id'			=> 'global_menu_ul',
		'menu_class'		=> 'mb-theme',
		'fallback_cb'		=> 'show_wp_global_menu_list_mb',
		'walker'			=> new description_walker()
	));

} else {
	// Fixed Page List
	show_wp_global_menu_list();
}

// **********************************
// Search form 
// **********************************
if ($options['show_global_menu_search']) {
?>
<div id="hd_searchform" class="hd_searchform mb-theme">
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

// **********************************
// SNS icons
// **********************************
if ($options['show_global_menu_sns']) {
	$facebook_list_code = $options['global_menu_fb_url'] ? '<li><a href="' . $options['global_menu_fb_url'] . '" title="Share on Facebook" target="_blank" class="icon-facebook"><span>Facebook</span></a></li>' : '';

	$twitter_list_code = $options['global_menu_twitter_url'] ? '<li><a href="' . $options['global_menu_twitter_url'] . '" title="Follow on Twitter" target="_blank" class="icon-twitter"><span>Twitter</span></a></li>' : '';

	$gplus_list_code = $options['global_menu_gplus_url'] ? '<li><a href="' . $options['global_menu_gplus_url'] . '" title="Google+" target="_blank" class="icon-gplus"><span>Google+</span></a></li>' : '';

	$rss_feed_code = $options['rss_to_feedly'] ? '<li><a href="http://cloud.feedly.com/#subscription%2Ffeed%2F'.urlencode(get_feed_link()).'" target="blank" title="Follow on feedly" class="icon-feedly"><span>Follow on feedly</span></a></li>' : '<li><a href="'. get_feed_link() .'" title="Subscribe Feed" target="_blank" class="icon-rss"><span>RSS</span></a></li>' ;

	echo '<div id="fixed_sns"><ul>'.$facebook_list_code.$twitter_list_code.$gplus_list_code.$rss_feed_code.'</ul></div>';
}
?>
</div>
</nav>
