<?php 
/* ------------------------------------------
   This template is for mobile device!!!!!!!
 ------------------------------------------*/
include (TEMPLATEPATH.'/'.DP_MOBILE_THEME_DIR.'/header.php');

// Header flag
$has_header_class = " no-header clearfix";
if ( is_home() && !is_paged() ) {
	if ($options_visual['dp_header_content_type'] !== "none" ) {
		$has_header_class = " clearfix";
	}
}
?>
<body id="main-body" <?php body_class("mb-theme"); ?>>
<div id="wrapper" class="wrapper">
<?php
// **********************************
// Site header
// **********************************
include_once(TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/site-header.php");

// **********************************
// Site container
// **********************************
if (is_home() && !is_paged() &&  !isset( $_REQUEST['q']) ) :
	// ************ Show headline ************
	dp_headline();
?>
<div id="container" class="container top<?php echo $has_header_class; ?>">
<?php 
else :
	$page_title = dp_current_page_title(false);
	if ($page_title) {
		echo '<section id="headline-sec"><div id="headline-sec-inner"><h1>'.$page_title.'</h1></div></section>';
	}
?>
<div id="container" class="container mb-theme clearfix">
<?php 
endif;

// **********************************
// Container widget
// **********************************
if (is_active_sidebar('widget-top-container-mobile')) : ?>
<div id="top-container-widget" class="clearfix">
<?php dynamic_sidebar( 'widget-top-container-mobile' ); ?>
</div>
<?php 
endif;

// **********************************
// Main content
// ********************************** ?>
<div id="content" class="content">
<?php

// **********************************
// Main content
// **********************************
// show posts
if (have_posts()) :
	include (TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/index-content.php");
else :
	// Not found...
	include_once(TEMPLATEPATH."/".DP_MOBILE_THEME_DIR.'/not-found.php');
endif;	// End of have_posts()
?>
</div><?php // end of #content

// **********************************
// Breadcrumb
// **********************************
if (is_home() && is_paged())  {
	echo '<div id="dp_breadcrumb_div">'.dp_breadcrumb(false).'</div>';	
}
?>
</div><?php // end of #container

// **********************************
// Footer area
// **********************************
include (TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/footer.php");

// **********************************
// Slider Menu
// **********************************
include (TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/global-menu.php");
?>
</div><?php // end of #wrapper

// **********************************
// WordPress footer
// **********************************
wp_footer();
// Javascript for sns
js_for_sns_objects();
?>
</body>
</html>