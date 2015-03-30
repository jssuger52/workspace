<?php 
/* ------------------------------------------
   This template is for mobile device!!!!!!!
 ------------------------------------------*/
include (TEMPLATEPATH.'/'.DP_MOBILE_THEME_DIR.'/header.php');
// Header flag
$has_header_class = "clearfix";
//For thumbnail size
$width = 600;
$height = 420;

// Common Patameters
$show_eyecatch_first 	= $options['show_eyecatch_first'];
$next_prev_in_same_cat 	= $options['next_prev_in_same_cat'];
?>
<body id="main-body" <?php body_class("mb-theme"); ?>>
<div id="wrapper" class="wrapper">
<?php
// **********************************
// Site header
// **********************************
include_once(TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/site-header.php");
?>
<div id="main-wrap" class="<?php echo $has_header_class; ?>">
<?php
// **********************************
// Page title
// **********************************
$page_title = dp_current_page_title(false);
if ($page_title) {
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1>'.$page_title.'</h1></div></section>';
}
?>
<div id="container" class="container mb-theme clearfix">
<?php

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
		$width_f 	= 760;
		$height_f	= 620;
		
		$image_id_f		= get_post_thumbnail_id();
		$image_data_f	= wp_get_attachment_image_src($image_id_f, array($width_f, $height_f), true);
		$image_url_f 	= is_ssl() ? str_replace('http:', 'https:', $image_data_f[0]) : $image_data_f[0];
		$img_tag_f	= '<img src="'.$image_url_f.'" class="wp-post-image aligncenter" alt="'.strip_tags(get_the_title()).'"  />';
		echo '<div class="single-eyecatch-container">' . $img_tag_f . '</div>';
	}

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
		if ( $postFormat !== 'quote' && !$hide_title ) : 
?> 
<header>
<h1 class="entry-title single-title<?php echo $titleIconClass; ?>"><span><?php echo $post_title; ?></span></h1>
<?php
		// header meta
		showPostMetaForSingleTop();
?>
</header>
<?php 
		endif;	// End of ( $postFormat !== 'quote' && !$hide_title )
?>
<?php
		// ***********************************
		// Single header widget
		// ***********************************
		if (($postType === 'post') && is_active_sidebar('under-post-title-mobile') && !post_password_required()) : 
?>
<div id="single-header-widget" class="clearfix"><?php dynamic_sidebar( 'under-post-title-mobile' ); ?></div>
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
		if ( $postType === 'post' && is_active_sidebar('bottom-of-post-mobile') && !post_password_required()) : 
?>
<div id="single-footer-widget" class="clearfix entry"><?php dynamic_sidebar( 'bottom-of-post-mobile' ); ?></div>
<?php
		endif;
		
		// Meta
		showPostMetaForSingleBottom();
?>
</article>
<?php 
		// ***********************************
		// Related posts
		// ***********************************
		dp_get_related_posts();
		// Similar posts plugin...
		if (function_exists('similar_posts')) {
			echo '<aside class="similar-posts">';
			similar_posts();
			echo '</aside>';
		}
		// ***********************************
		// Comments
		// ***********************************
		comments_template();
	endwhile;	// End of (have_posts())
else :	// have_posts()

	// ***********************************
	// Not found...
	// ***********************************
	include_once(TEMPLATEPATH .'/not-found.php');

endif;	// End of have_posts()

?>
</div><?php // end of #content


// **********************************
// Breadcrumb
// ********************************** ?>
<div id="dp_breadcrumb_div"><?php echo dp_breadcrumb(false); ?></div>
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