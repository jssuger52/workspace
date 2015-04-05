<?php 
/* ------------------------------------------
   This template is for mobile device!!!!!!!
 ------------------------------------------*/
include (TEMPLATEPATH.'/'.DP_MOBILE_THEME_DIR.'/header.php');

// Header flag
$has_header_class = "clearfix";

$date_code 			= ''; 

// Counter
$i = 0;

//For thumbnail size
$width = 680;
$height = 480;

// SNS count
$hatebuNumberCode 	= '';
$tweetCountCode		= '';
$fbLikeCountCode	= '';

// ***********************************
// Get archive style (/inc/scr/get_archive_style.php)
extract($ARCHIVE_STYLE);
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
// Hits count
$found_title = '';
if (is_search() && !isset( $_REQUEST['q'])) {
	if ($wp_query->found_posts !== 0) {
		$found_title = '<div class="found-title"><span>' . $wp_query->found_posts . __(' posts has found.', 'DigiPress') . '</span></div>';
	} else {
		$found_title = '<div class="found-title"><span>'.__('Nothing Found.','DigiPress').'</span></div>';
	}
}
// Page title
$page_title = dp_current_page_title(false);
if ($page_title) {
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1>'.$page_title.'</h1>'.$found_title.'</div></section>';
}
?>
<div id="container" class="container mb-theme clearfix">
<?php 

// Check the query
if (isset( $_REQUEST['q']) ) : 

	// **********************************
	// Main content
	// ********************************** ?>
	<div id="content" class="content">
<?php
	// **********************************
	// Google Custom Search
	// **********************************
?>
<gcse:searchresults-only></gcse:searchresults-only>
	</div><?php // End of #content

else :
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
	if (have_posts()) :

		// Main Content start
		if ( $archive_style == 'gallery' || $archive_style == 'portfolio' ) :

			// ***********************************
			// Appeal image View
			// ***********************************
	?>
	<section id="loop-section" class="app-image mb-theme clearfix">
	<div class="loop-div mb-theme clearfix">
	<?php

		$titleStrCount = 60;

		//Loop each post
		while (have_posts()) : the_post();

			// Post format
			$postFormat = get_post_format($post->ID);
			// Get icon class each post format
			$titleIconClass = postFormatIcon($postFormat);

			// *************************************
			// For media icon
			if (!$postFormat) {
				$titleIconClass = 'icon-zoom-in';
			}
			// *************************************
			// YouTube embed player
			if ($videoID) {
				$titleIconClass = 'icon-video-play';
			}

			// Media icon code
			$media_icon_code = '<div class="loop-media-icon"><a href="'.get_permalink().'"><span class="'.$titleIconClass.'"></span></a></div>';

			
			// ************* SNS sahre number *****************
			// hatebu
			if ($options['hatebu_number_after_title_'.$current_archive_flag]) {
				$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
			}
			// Count tweets
			if ($options['tweet_number_after_title_'.$current_archive_flag]) {
				$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
			}
			// Count Facebook Like 
			if ($options['likes_number_after_title_'.$current_archive_flag]) {
				$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
			}
			/***
			 * Filter hook
			 */
			$sns_insert_content = apply_filters( 'dp_archive_insert_sns_content', get_the_ID() );
			if ($sns_insert_content == get_the_ID() || !is_string($sns_insert_content)) {
				$sns_insert_content = '';
			}
			// Whole share code
			$sns_share_code = ($options['hatebu_number_after_title_'.$current_archive_flag] || $options['tweet_number_after_title_'.$current_archive_flag] || $options['likes_number_after_title_'.$current_archive_flag] || !empty($sns_insert_content) ) ? '<div class="loop-share-num">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.$sns_insert_content.'</div>' : '';
			// ************* SNS sahre number *****************
			
			// even of odd
			$evenOddClass = (++$i % 2 === 0) ? 'evenpost' : 'oddpost';

			//Fix post title
			$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');
			
			// Title		
			if (mb_strlen($post_title, 'UTF-8') > $titleStrCount) $post_title = mb_substr($post_title, 0, $titleStrCount, 'UTF-8') . '...'; 
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article <?php echo $evenOddClass . ' ' . $firstPostClass . ' ' . $lastPostClass; ?>">
	<div class="loop-post-thumb app-image"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo show_post_thumbnail($width, $height); ?></a></div>
	<div class="loop-article-content">
	<header><h1 class="entry-title loop-title app-image"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	<?php
			if ($postFormat === 'quote'): // Check the post format 
				_e('Quote', 'DigiPress');
			else :
				echo $post_title;
			endif;
	?>
	</a></h1></header>
	<?php echo $media_icon_code; ?>
	</div><?php // loop-article-content ?>
	<footer><div class="meta-div app-image"><?php 
		showPostMetaForArchiveMobile(); 
		echo $sns_share_code;
	?></div></footer>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php
		endwhile;
	?>
	</div>
	</section>
	<?php

		elseif ( $archive_style === 'normal' || $archive_style === 'magazine' ) : 
		// ***********************************
		// Normal blog View
		// ***********************************
	?>
	<section id="loop-section" class="blog mb-theme clearfix">
	<?php 
			// Thumbnail size
			$width = 680;
			$height = 600;
	?>
	<div class="loop-div mb-theme clearfix">
	<?php
			//Loop each post
			while (have_posts()) : the_post();
				// Post format
				$postFormat = get_post_format($post->ID);
				// Get icon class each post format
				$titleIconClass = postFormatIcon($postFormat);
				// Append icon class attribute
				$titleIconClass2 = $titleIconClass ? ' class="'.$titleIconClass.'"' : '';

				// ************* SNS sahre number *****************
				// hatebu
				if ($options['hatebu_number_after_title_'.$current_archive_flag]) {
					$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
				}
					
				// Count tweets
				if ($options['tweet_number_after_title_'.$current_archive_flag]) {
					$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
				}

				// Count Facebook Like 
				if ($options['likes_number_after_title_'.$current_archive_flag]) {
					$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
				}
				/***
				 * Filter hook
				 */
				$sns_insert_content = apply_filters( 'dp_archive_insert_sns_content', get_the_ID() );
				if ($sns_insert_content == get_the_ID() || !is_string($sns_insert_content)) {
					$sns_insert_content = '';
				}
				// Whole share code
				$sns_share_code = ($options['hatebu_number_after_title_'.$current_archive_flag] || $options['tweet_number_after_title_'.$current_archive_flag] || $options['likes_number_after_title_'.$current_archive_flag] || !empty($sns_insert_content) ) ? '<div class="loop-share-num">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.$sns_insert_content.'</div>' : '';
				// ************* SNS sahre number *****************
				
				// Post title
				$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');

				// even of odd
				$evenOddClass = (++$i % 2 === 0) ? ' evenpost' : ' oddpost';
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article clearfix <?php echo $evenOddClass; ?>">
	<div class="loop-post-thumb blog"><?php echo $media_icon_code; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo show_post_thumbnail($width, $height); ?></a></div>
	<div class="loop-info-right">
	<div class="meta-div app-image"><?php showPostMetaForArchiveMobile(); ?></div>
	<header><h1 class="entry-title loop-title blog"><a href="<?php the_permalink() ?>"<?php echo $titleIconClass2; ?> rel="bookmark" title="<?php the_title_attribute(); ?>">
	<?php
				if ($postFormat === 'quote'): // Check the post format 
					_e('Quote', 'DigiPress');
				else :
					echo $post_title;
				endif;
	?>
	</a></h1>
	</header>
	<?php echo $sns_share_code; ?>
	</div>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php
			endwhile;
	?>
	</div>
	</section>
	<?php 

		elseif ($archive_style === 'news') : 
		// ***********************************
		// "News" custom post type 
		// ***********************************
	?>
	<section id="loop-section" class="news clearfix">
	<?php 
			// Main title
			if ($options[$current_archive_flag.'_posts_list_title'] && !is_paged()) {
				echo '<header class="loop-sec-header"><h1>'.$options[$current_archive_flag.'_posts_list_title'].'</h1></header>';
			}
	?>
	<div class="loop-div mb-theme clearfix">
	<?php
			//Loop each post
			while (have_posts()) : the_post();
				// Post format
				$postFormat = get_post_format($post->ID);
				// even of odd
				$evenOddClass = (++$i % 2 === 0) ? 'evenpost' : 'oddpost';
				//Fix post title
				$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');
		?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article <?php echo $evenOddClass; ?>">
	<header><h1 class="entry-title loop-title news"><a href="<?php the_permalink() ?>" rel="bookmark"><?php echo $post_title; ?></a></h1></header>
	<footer><div class="meta-div portfolio"><?php showPostMetaForArchive(false); ?></div></footer>
	</article>
	<?php
			endwhile;
	?>
	</div>
	</section>
	<?php
		endif;	// end of $archive_style

		// ***********************************
		// Navigation
		// ***********************************
		if ( $options['autopager_mb'] ) : ?>
	<nav class="navigation clearfix"><div class="nav_to_paged"><?php next_posts_link($options['navigation_text_to_2page_'.$current_archive_flag]) ?></div></nav>
	<?php 
		else: // Paged 
			if (function_exists('wp_pagenavi')) : 
	?>
	<nav class="navigation clearfix"><?php wp_pagenavi(); ?></nav>
	<?php 
			else : 
		?>
	<nav class="navigation clearfix">
	<?php 
				if ($options['pagenation']) :
						dp_pagenavi();
				else : 
	?>
	<div class="navialignleft"><?php previous_posts_link(__('<span class="nav-arrow icon-left-open"><span>PREV</span></span>', '')) ?></div>
	<div class="navialignright"><?php next_posts_link(__('<span class="nav-arrow icon-right-open"><span>NEXT</span></span>', '')) ?></div>
	<?php 
				endif; 	// end of $options['pagenation']
	?>
	</nav>
	<?php 
			endif;	// end of function_exists('wp_pagenavi')
		endif;	// $options['autopager'] || (is_front_page() && !is_paged())

	else :	// have_posts()
		// ***********************************
		// Not found...
		// ***********************************
		include_once(TEMPLATEPATH."/".DP_MOBILE_THEME_DIR.'/not-found.php');
	endif;	// End of have_posts()
	?>
</div><?php // end of #content

endif; // isset( $_REQUEST['q']


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