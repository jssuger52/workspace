<?php 
get_header(); 
// Header flag
$has_header_class = "main-wrap no-header";

$mobile_flag_class 	= $IS_MOBILE_DP ? 'mb' : '';

//For thumbnail size
$width = 800;
$height = 600;

// Common Patameters
$show_eyecatch_first 	= $options['show_eyecatch_first'];
$next_prev_in_same_cat 	= $options['next_prev_in_same_cat'];
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
// Page title
// **********************************
$page_title = dp_current_page_title(false);
if ($page_title) {
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1 class="headline-static-title">'.$page_title.'</h1></div></section>';
}
?>
<div id="container" class="container clearfix">
<?php

// show posts
if (have_posts()) :
	// Get post type
	$postType = get_post_type();
	// Post format
	$postFormat 		= get_post_format();

	$title_icon_class 	= postFormatIcon($postFormat);
	$post_title 		=  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');
	$hide_title 		= get_post_meta(get_the_ID(), 'dp_hide_title', true);
	$show_eyecatch_force 	= get_post_meta(get_the_ID(), 'dp_show_eyecatch_force', true);
	$eyecatch_on_container 	= get_post_meta(get_the_ID(), 'dp_eyecatch_on_container', true);

	// **********************************
	// Show eyecatch on container 
	// **********************************
	if ( has_post_thumbnail() && $show_eyecatch_force && $eyecatch_on_container ) {
		$width_f 	= 960;
		$height_f	= 720;
		
		$image_id_f		= get_post_thumbnail_id();
		$image_data_f	= wp_get_attachment_image_src($image_id_f, array($width_f, $height_f), true);
		$image_url_f 	= is_ssl() ? str_replace('http:', 'https:', $image_data_f[0]) : $image_data_f[0];
		$img_tag_f	= '<img src="'.$image_url_f.'" class="wp-post-image aligncenter" alt="'.strip_tags(get_the_title()).'"  />';
		echo '<div class="single-eyecatch-container">' . $img_tag_f . '</div>';
	}


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

	// ***********************************
	// Article area start
	// ***********************************
	while (have_posts()) : the_post(); 

		// Count Post View
		if (function_exists('dp_count_post_views')) {
			dp_count_post_views(get_the_ID(), true);
		}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
<?php
		// ***********************************
		// Post title
		// ***********************************
		if ( !$hide_title ) : 
?>
<header>
<h1 class="entry-title single-title<?php echo $titleIconClass; ?>"><span><?php echo $post_title; ?></span></h1>
<?php
		// header meta
		showPostMetaForSingleTop();
?>
</header>
<?php 
		endif; 	// End of 

		// ***********************************
		// Single header widget
		// ***********************************
		if ( is_active_sidebar('widget-post-header') && !post_password_required()) : 
?>
<div id="single-header-widget" class="clearfix"><?php dynamic_sidebar( 'widget-post-header' ); ?></div>
<?php 
		endif;	// End of widget

		// ***********************************
		// Main entry
		// *********************************** ?>
<div class="entry entry-content">
<?php
		// ***********************************
		// Show eyecatch image
		// ***********************************
		if ( $show_eyecatch_force && !$eyecatch_on_container ) {
			if ( $COLUMN_NUM == 1 ) {
				$width 	= 960;
				$height	= 720;
			}
			$image_id	= get_post_thumbnail_id();
			$image_data	= wp_get_attachment_image_src($image_id, array($width, $height), true);
			$image_url 	= is_ssl() ? str_replace('http:', 'https:', $image_data[0]) : $image_data[0];
			$img_tag	= '<img src="'.$image_url.'" width="'.$width.'" class="wp-post-image aligncenter" alt="'.strip_tags(get_the_title()).'"  />';
			echo '<div class="al-c">' . $img_tag . '</div>';
		}

		// Content
		the_content();
		// ***********************************
		// Paged navigation
		// ***********************************
		$link_pages = wp_link_pages(array(
										'before' => '', 
										'after' => '', 
										'next_or_number' => 'number', 
										'echo' => '0'));
		if ( $link_pages != '' ) {
			echo '<nav class="navigation"><div class="dp-pagenavi clearfix">';
			if ( preg_match_all("/(<a [^>]*>[\d]+<\/a>|[\d]+)/i", $link_pages, $matched, PREG_SET_ORDER) ) {
				foreach ($matched as $link) {
					if (preg_match("/<a ([^>]*)>([\d]+)<\/a>/i", $link[0], $link_matched)) {
						echo "<a class=\"page-numbers\" {$link_matched[1]}><span>{$link_matched[2]}</span></a>";
					} else {
						echo "<span class=\"current\">{$link[0]}</span>";
					}
				}
			}
			echo '</div></nav>';
		}
?>
</div><?php 	// End of class="entry"

		// ***********************************
		// Single footer widget
		// ***********************************
		if ( is_active_sidebar('widget-post-footer') && !post_password_required()) : 
?>
<div id="single-footer-widget" class="clearfix entry"><?php dynamic_sidebar( 'widget-post-footer' ); ?></div>
<?php
		endif;
		
		// Meta
		showPostMetaForSingleBottom();
?>
</article>
<?php 
	endwhile;	// End of (have_posts())

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
	?>
	</div><?php // end of #content

	// **********************************
	// Sidebar
	// **********************************
	if ( $COLUMN_NUM != 1 ) :
		get_sidebar();
	endif;

else :	// have_posts()

	// ***********************************
	// Not found...
	// ***********************************
	?>
	<div id="content" class="content one-col">
	<?php
		include_once(TEMPLATEPATH .'/not-found.php');
	?>
	</div><?php // end of #content

endif;	// End of have_posts()

?>
</div><?php // end of #container ?>
</div><?php // end of #main-wrap


// **********************************
// Breadcrumb
// **********************************
echo '<div id="dp_breadcrumb_div">'.dp_breadcrumb(false).'</div>';	

// Footer
get_footer(); 
?>
</body>
</html>