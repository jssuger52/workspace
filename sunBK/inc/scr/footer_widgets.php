<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 * @subpackage DigiPress
 */
function dp_get_footer() {
	global $options_visual;
	$theme_location 	= 'footer_menu_ul';
	$only_menu_class 	= '';

	// Check
	if (!has_nav_menu($theme_location) 
		&& !is_active_sidebar( 'footer-widget1' ) 
		&& !is_active_sidebar( 'footer-widget2' )
		&& !is_active_sidebar( 'footer-widget3' ) 
		&& !is_active_sidebar( 'footer-widget4' ) ) {
		return;
	}

	if (has_nav_menu($theme_location) 
		&& !is_active_sidebar( 'footer-widget1' ) 
		&& !is_active_sidebar( 'footer-widget2' )
		&& !is_active_sidebar( 'footer-widget3' ) 
		&& !is_active_sidebar( 'footer-widget4' ) ) {
		$only_menu_class 	= ' class="footer-no-widget"';
	}
?>
<div id="ft-widget-container"<?php echo $only_menu_class; ?>>
<div id="ft-widget-content">
<?php
	// 1st Column
	if ( is_active_sidebar( 'footer-widget1' ) ) : ?>
<div id="ft-widget-area1" class="ft-widget-area clearfix">
<?php dynamic_sidebar( 'footer-widget1' ); ?>
</div>
<?php 
	endif; 
	// 2nd Column
	if ( is_active_sidebar( 'footer-widget2' ) ) : ?>
<div id="ft-widget-area2" class="ft-widget-area clearfix">
<?php dynamic_sidebar( 'footer-widget2' ); ?>
</div>
<?php 
	endif;
	// 3rd Column
	if ( is_active_sidebar( 'footer-widget3' ) ) : ?>
<div id="ft-widget-area3" class="ft-widget-area clearfix">
<?php dynamic_sidebar( 'footer-widget3' ); ?>
</div>
<?php 
	endif;
	// 4th Column
	if ( is_active_sidebar( 'footer-widget4' ) ) : ?>
<div id="ft-widget-area4" class="ft-widget-area clearfix">
<?php dynamic_sidebar( 'footer-widget4' ); ?>
</div>
<?php 
	endif;

	// *******************************
	// Custom Menu
	// *******************************
	function footer_menu_fallback() {
		return;
	}
	if ( function_exists('wp_nav_menu' )) {
		if (has_nav_menu($theme_location)) {
			wp_nav_menu(array(
				'theme_location'	=> $theme_location,
				'container'			=> 'ul',
				'menu_id'			=> $theme_location,
				'depth'				=> 1,
				'fallback_cb'		=> 'footer_menu_fallback',
				'walker'			=> new description_walker()
			));
		}
	}
?>
</div>
</div>
<?php } ?>