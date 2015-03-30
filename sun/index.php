<?php 
get_header(); 
// float flag
// $fixed_class = $options['disable_menu_float'] ? '' : ' pos_fixed';

$mobile_flag_class 	= $IS_MOBILE_DP ? 'mb' : '';

// Header flag
$has_header_class = "main-wrap no-header";
if ( is_home() && !is_paged() ) {
	if ($options_visual['dp_header_content_type'] !== "none" ) {
		$has_header_class = "main-wrap";
	}
}
?>
<body id="main-body" <?php body_class($mobile_flag_class); ?>>
<?php
// **********************************
// Site header
// **********************************
include_once(TEMPLATEPATH . "/site-header.php");
?>
<div id="main-wrap" class="<?php echo $has_header_class; ?>">
<?php 
// **********************************
// Site container
// **********************************
if (is_home() && !is_paged() &&  !isset( $_REQUEST['q']) ) :
	// ************ Show headline ************
	dp_headline();
?>
<div id="container" class="container top clearfix">
<?php 
else :
	$page_title = dp_current_page_title(false);
	if ($page_title) {
		echo '<section id="headline-sec"><div id="headline-sec-inner"><h1 class="headline-static-title">'.$page_title.'</h1></div></section>';
	}
?>
<div id="container" class="container clearfix">
<?php 
endif;

// **********************************
// Container widget
// **********************************
if (is_active_sidebar('widget-top-container')) : ?>
<div id="top-container-widget" class="clearfix">
<?php dynamic_sidebar( 'widget-top-container' ); ?>
</div>
<?php 
endif;

// **********************************
// Main content
// **********************************
// Check column
if ( $COLUMN_NUM == 1 ) : 
?>
<div id="content" class="content one-col">
<?php 
else : 
?>
<div id="content" class="content two-col <?php echo $SIDEBAR_FLOAT; ?>">
<?php 
endif;

// **********************************
// Content widget
// **********************************
if (is_active_sidebar('widget-top-content')) : ?>
<div id="top-content-widget" class="clearfix">
<?php dynamic_sidebar( 'widget-top-content' ); ?>
</div>
<?php 
endif;

include (TEMPLATEPATH . "/index-top.php");
// show posts
if (have_posts()) :
	include (TEMPLATEPATH . "/index-under.php");
	// ***********************************
	// Content bottom widget
	// ***********************************
	if (is_active_sidebar('widget-top-content-bottom')) : 
?>
<div id="top-content-bottom-widget" class="clearfix">
<?php dynamic_sidebar( 'widget-top-content-bottom' ); ?>
</div>
<?php 
	endif;
else :
	// Not found...
	include_once(TEMPLATEPATH .'/not-found.php');
endif;	// End of have_posts()
?>
</div><?php // end of #content

// **********************************
// Sidebar
// **********************************
if ( $COLUMN_NUM != 1 ) get_sidebar();
?>
</div><?php // end of #container ?>
</div><?php // end of #main-wrap


// **********************************
// Breadcrumb
// **********************************
if (is_home() && is_paged())  {
	echo '<div id="dp_breadcrumb_div">'.dp_breadcrumb(false).'</div>';	
}
?>
<?php get_footer(); ?>
</body>
</html>