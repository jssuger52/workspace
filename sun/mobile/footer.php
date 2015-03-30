<?php 
// ****************************
// Container bottom widget
// ****************************
if (is_active_sidebar('widget-bottom-container-mobile') && !is_404()) : 
?>
<div id="container_footer">
<div id="content_footer" class="clearfix">
<?php dynamic_sidebar( 'widget-bottom-container-mobile' ); ?>
</div>
</div>
<?php 
endif; 
?>
<footer id="footer">
<?php 
// ****************************
// Footer widget
// ****************************
if ( is_active_sidebar( 'footer-mobile' ) ) {
	echo '<div id="ft-widget-content">';
	dynamic_sidebar( 'footer-mobile' );
	echo '</div>';
}

// ****************************
// Custom Menu
// ****************************
function footer_menu_fallback() {
	return;
}
$theme_location = 'footer_menu_mobile';
if (function_exists('wp_nav_menu') && has_nav_menu($theme_location)) : ?>
<div id="footer_menu_div">
<?php
	wp_nav_menu(array(
		'theme_location'	=> $theme_location,
		'container'			=> 'ul',
		'menu_id'			=> $theme_location,
		'depth'				=> 1,
		'fallback_cb'		=> 'footer_menu_fallback',
		'walker'			=> new description_walker()
	));
?>
</div>
<?php
endif;

// ****************************
// Copyright
// ****************************?>
<div id="footer-bottom">&copy; <?php 
global $options;
if ($options['blog_start_year'] !== '') {
	echo $options['blog_start_year'] . '-' . date('Y');
} else {
	echo date('Y');
} ?> <a href="<?php echo home_url(); ?>/"><small><?php bloginfo('name'); ?></small></a>
</div>
</footer>
<a href="#main-body" id="gototop" class="icon-up-open" title="Return Top"><span>Return Top</span></a>