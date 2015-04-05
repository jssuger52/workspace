<?php 
get_header(); 
// float flag
// $fixed_class = $options['disable_menu_float'] ? '' : ' pos_fixed';

$mobile_flag_class 	= $IS_MOBILE_DP ? 'mb' : '';

// Header flag
$has_header_class = "main-wrap no-header";

$excerpt_length = 0;
$media_icon_code 		= '';
$modal_code 			= '';
$media_icon_nav_url 	= '';
$date_code 				= ''; 
$desc 					= '';

// Counter
$i = 0;

//For thumbnail size
$width = 800;
$height = 600;

// SNS count
$hatebuNumberCode 	= '';
$tweetCountCode		= '';
$fbLikeCountCode	= '';

// ***********************************
// Get archive style (/inc/scr/get_archive_style.php)
extract($ARCHIVE_STYLE);
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
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1 class="headline-static-title">'.$page_title.'</h1>'.$found_title.'</div></section>';
}

?>
<div id="container" class="container clearfix">
<?php 

// Check the query
if (isset( $_REQUEST['q'] ) ) : 

	// **********************************
	// Main content
	// **********************************
	// Check column
	if ( $COLUMN_NUM == 1 ) : ?>
	<div id="content" class="content one-col">
	<?php 
	else : 
	?>
	<div id="content" class="content two-col <?php echo $SIDEBAR_FLOAT; ?>">
	<?php 
	endif;

	// **********************************
	// Google Custom Search
	// **********************************
?>
<gcse:searchresults-only></gcse:searchresults-only>
	</div><?php // End of #content

else :

	// **********************************
	// Default Search
	// **********************************
	// show posts
	if (have_posts()) :

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
		if ( $COLUMN_NUM == 1 ) : ?>
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

		if ($archive_style == 'normal') : ?>
	<section id="loop-section" class="normal clearfix">
	<?php
			// Main title
			if ($options[$current_archive_flag.'_posts_list_title'] && !is_paged()) {
				echo '<header class="loop-sec-header"><h1>'.$options[$current_archive_flag.'_posts_list_title'].'</h1></header>';
			}

			// ***********************************
			// Normal View
			// ***********************************
			// loop block
			if ($COLUMN_NUM === 1) :
	?>
	<div class="loop-div one-col">
	<?php
			else : 
	?>
	<div class="loop-div two-col">
	<?php
			endif;

			//Loop each post
			while (have_posts()) : the_post();

				// Post format
				$postFormat = get_post_format($post->ID);
				// Post type
				$postType = get_post_type();

				// Video ID(YouTube only)
				$videoID = get_post_meta($post->ID, 'item_video_id', true);

				// Get icon class each post format
				$titleIconClass = postFormatIcon($postFormat);
				// Append icon class attribute
				$titleIconClass2 = $titleIconClass ? ' class="'.$titleIconClass.'"' : '';

				// *************************************
				// For media icon and modal window
				$media_icon_nav_url = get_permalink();
				if ($postFormat === 'image' || $postFormat === 'gallery') {
					$media_target_class = ' media-modal';
					$media_icon_nav_url = show_post_thumbnail($width, $height, get_the_ID(), false);
					$modal_code = '<div class="modal-window"><div class="modal-body"><img src="'.$media_icon_nav_url.'" class="modal-item-image" alt="modal image" /><div class="icon-cross-circled modal-close"><span>Close</span></div></div></div>';
				} else if (!$postFormat) {
					$media_target_class = '';
					$titleIconClass = 'icon-zoom-in';
					$modal_code = '';
				} else {
					$media_target_class = '';
					$modal_code = '';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************
				// YouTube embed player
				if ($videoID) {
					$media_target_class = ' media-modal';
					$titleIconClass = 'icon-video-play';
					$modal_code = '<div class="modal-window emb-video"><div class="modal-body"><div class="emb_video"><iframe width="640" height="360" src="http://www.youtube.com/embed/'.$videoID.'?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allowfullscreen id="'.$videoID.'" allowscriptaccess="always"></iframe></div></div></div>';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************


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

				// Check the first or last
				$firstPostClass = dp_is_first() ? 'first-post' : '';
				$lastPostClass = dp_is_last() ? 'last-post': '';
				// even of odd
				$evenOddClass = (++$i % 2 === 0) ? 'evenpost' : 'oddpost';
				// Additional class
				//$arrPostClass = array($evenOddClass, $lastPostClass);
				
				
				if ( $archive_normal_style === 'all' ) : 
				// ***********************************
				// Show all content in Normal View
				// ***********************************
				
				// Post date for all
				if ( $options['show_pubdate_on_meta'] ) {
					$date_code = '<div class="post-header-date"><time datetime="'. get_the_date('c').'" pubdate="pubdate" class="updated"><span class="date-year">'.get_the_date('Y').'</span><span class="date-month">'.get_the_date('n').'</span>/<span class="date-day">'.get_the_date('j').'</span></time></div>';
				}
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry post loop-article normal-all clearfix <?php echo $evenOddClass . ' ' . $firstPostClass . ' ' . $lastPostClass; ?>">
	<?php 
				// Check the post format 
				if ($postFormat === 'quote'): 
	?>
	<header><?php echo $date_code; ?><h1 class="entry-title <?php echo $titleIconClass; ?>"><?php _e('Quote', 'DigiPress'); ?></h1></header>
	<?php 
				elseif ($postFormat === 'status') :
	?>
	<div class="clearfix"><header class="inline-blk"><?php echo $date_code; ?><h1 class="entry-title mg8px-btm ft12px mg6px-top"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="ft12px" title="<?php _e('Articles of this user', 'DigiPress'); ?>"><?php the_author_meta( 'display_name' ); ?></a></h1><h2 class="ft14px"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo get_the_date(); ?></h2></a></header>
	<div class="fl-l"><?php echo get_avatar($comment,$size='50'); ?></div></div>
	<?php 
				else : // else $postFormat
	?>
	<header><?php echo $date_code; ?><h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="<?php echo $titleIconClass; ?>"><?php echo $post_title; ?></a><?php echo $sns_share_code; ?></h1></header>
	<?php 
				endif; // End of if $postFormat
	?>
	<div class="entry-summary entry">
	<?php 
			// Show eyecatch image
			if(has_post_thumbnail() && $options['show_eyecatch_first'] && ($postType === 'post')) {
				$width 	= 630;
				$height	= 630;
				if ($COLUMN_NUM === 1) {
					$width 	= 960;
					$height	= 930;
				}
				$image_id	= get_post_thumbnail_id();
				$image_data	= wp_get_attachment_image_src($image_id, array($width, $height), true);
				$image_url	= is_ssl() ? str_replace('http:', 'https:', $image_data[0]) : $image_data[0];
				$img_tag	= '<img src="'.$image_url.'" width="'.$width.'" class="wp-post-image aligncenter" alt="'.get_the_title().'"  />';
				echo '<div class="al-c">' . $img_tag . '</div>';
			}
			// Content
			the_content(htmlspecialchars_decode($options['archive_readmore_text'])); 
	?>
	</div>
	<footer><?php showPostMetaForArchive(); ?></footer>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php 
			else :
				// ***********************************
				// Show excerpt in Normal View
				// ***********************************

				$excerpt_length = $options['archive_normal_excerpt_length'];
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article <?php echo $evenOddClass . ' ' . $firstPostClass . ' ' . $lastPostClass; ?>">
	<div class="loop-post-thumb normal"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo show_post_thumbnail($width, $height); ?></a></div>
	<div class="loop-article-content">
	<header><h1 class="entry-title loop-title normal"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	<?php
				if ($postFormat === 'quote'): // Check the post format 
					_e('Quote', 'DigiPress');
				else :
					echo $post_title;
				endif;
	?>
	</a></h1></header>
	<?php echo $media_icon_code; ?>
	<div class="loop-excerpt">
	<?php 
			if ( $excerpt_length != 0 ) {
				//Post excerpt
				$desc = strip_tags(get_the_excerpt());
				if (mb_strlen($desc,'utf-8') > $excerpt_length) $desc = mb_substr($desc, 0, $excerpt_length,'utf-8').'...';
				echo '<p class="entry-summary">'.$desc.'</p>';
			}
?>
	</div><?php // loop-excerpt ?>
	</div><?php // loop-article-content ?>
	<footer><div class="meta-div normal"><?php 
			showPostMetaForArchive(); 
			echo $sns_share_code;
	?></div></footer>
	<?php echo $modal_code; ?>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php 
				endif;
			endwhile; 
	?>
	</div><?php // End of "loop-div" class ?>
	</section><?php // End of "loop-section"  

		elseif ($archive_style === 'gallery') : 
		// ***********************************
		// Gallery View
		// ***********************************
	?>
	<section id="loop-section" class="gallery clearfix">
	<?php 
			// Thumbnail size
			$width = 630;
			$height = 450;

			// Main title
			if ($options[$current_archive_flag.'_posts_list_title'] && !is_paged()) {
				echo '<header class="loop-sec-header"><h1>'.$options[$current_archive_flag.'_posts_list_title'].'</h1></header>';
			}

			// loop block
			if ($COLUMN_NUM === 1) :
		?>
	<div class="loop-div one-col">
	<?php
			else : 
	?>
	<div class="loop-div two-col">
	<?php
			endif;

			$titleStrCount = 44;

			//Loop each post
			while (have_posts()) : the_post();
				// Post format
				$postFormat = get_post_format($post->ID);
				// Get icon class each post format
				$titleIconClass = postFormatIcon($postFormat);

				// Video ID(YouTube only)
				$videoID = get_post_meta($post->ID, 'item_video_id', true);

				// *************************************
				// For media icon and modal window
				$media_icon_nav_url = get_permalink();
				if ($postFormat === 'image' || $postFormat === 'gallery') {
					$media_target_class = ' media-modal';
					$media_icon_nav_url = show_post_thumbnail($width, $height, get_the_ID(), false);
					$modal_code = '<div class="modal-window"><div class="modal-body"><img src="'.$media_icon_nav_url.'" class="modal-item-image" alt="modal image" /><div class="icon-cross-circled modal-close"><span>Close</span></div></div></div>';
				} else if (!$postFormat) {
					$media_target_class = '';
					$titleIconClass = 'icon-none';
					$modal_code = '';
				} else {
					$media_target_class = '';
					$modal_code = '';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************
				// YouTube embed player
				if ($videoID) {
					$media_target_class = ' media-modal';
					$titleIconClass = 'icon-video-play';
					$modal_code = '<div class="modal-window emb-video"><div class="modal-body"><div class="emb_video"><iframe width="640" height="360" src="http://www.youtube.com/embed/'.$videoID.'?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allowfullscreen id="'.$videoID.'" allowscriptaccess="always"></iframe></div></div></div>';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************

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
				// Class for thumbnail width
				if ($COLUMN_NUM == 1) {
					$wideColClass = ( $i === 1 || ($i - 8) % 10 === 0 || $i % 10 === 1) ? ' msnry-w': ' msnry-s';
				} else {
					$wideColClass = ( $i === 1 || $i % 5 === 0 ) ? ' msnry-w': ' msnry-s';
				}

				//Fix post title
				$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');

				// Title
				if (mb_strlen($post_title,'utf-8') > $titleStrCount) $post_title = mb_substr($post_title, 0, $titleStrCount,'utf-8') . '...'; 
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article <?php echo $evenOddClass.$wideColClass; ?>">
	<div class="loop-article-inner gallery">
	<?php echo show_post_thumbnail($width, $height); ?>
	<div class="loop-flip">
	<div class="loop-flip-inner clearfix">
	<header class="<?php echo $media_target_class; ?>"><h1 class="entry-title loop-title gallery"><a href="<?php the_permalink() ?>" class="<?php echo $titleIconClass ?>" rel="bookmark">
	<?php
				if ($postFormat === 'quote'): // Check the post format 
					_e('Quote', 'DigiPress');
				else :
					echo $post_title;
				endif;
		?>
	</a></h1></header>
	<footer><div class="meta-div gallery"><?php showPostMetaForArchive(); ?></div><?php echo '<div class="loop-meta-share">'.$sns_share_code.'</div>'; ?></footer>
	</div><?php // loop-flip-inner ?>
	</div><?php // loop-flip ?>
	</div><?php // loop-article-inner ?>
	<?php echo $modal_code; ?>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php
			endwhile;
	?>
	</div>
	</section>
	<?php

		elseif ($archive_style === 'portfolio') : 
		// ***********************************
		// Portfolio View
		// ***********************************
	?>
	<section id="loop-section" class="portfolio clearfix">
	<?php 
			// Thumbnail size
			$width = 630;
			$height = 450;

			// Main title
			if ($options[$current_archive_flag.'_posts_list_title'] && !is_paged()) {
				echo '<header class="loop-sec-header"><h1>'.$options[$current_archive_flag.'_posts_list_title'].'</h1></header>';
			}

			// loop block
			if ($COLUMN_NUM === 1) :
	?>
	<div class="loop-div one-col">
	<?php
			else : 
	?>
	<div class="loop-div two-col">
	<?php
			endif;

			$titleStrCount = 42;

			//Loop each post
			while (have_posts()) : the_post();

				// Post format
				$postFormat = get_post_format($post->ID);

				// Get icon class each post format
				$titleIconClass = postFormatIcon($postFormat);
				// Append icon class attribute
				$titleIconClass2 = $titleIconClass ? ' class="'.$titleIconClass.'"' : '';

				// Video ID(YouTube only)
				$videoID = get_post_meta($post->ID, 'item_video_id', true);

				// *************************************
				// For media icon and modal window
				$media_icon_nav_url = get_permalink();
				if ($postFormat === 'image' || $postFormat === 'gallery') {
					$media_target_class = ' media-modal';
					$media_icon_nav_url = show_post_thumbnail($width, $height, get_the_ID(), false);
					$modal_code = '<div class="modal-window"><div class="modal-body"><img src="'.$media_icon_nav_url.'" class="modal-item-image" alt="modal image" /><div class="icon-cross-circled modal-close"><span>Close</span></div></div></div>';
				} else if (!$postFormat) {
					$media_target_class = '';
					$titleIconClass = 'icon-zoom-in';
					$modal_code = '';
				} else {
					$media_target_class = '';
					$modal_code = '';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************
				// YouTube embed player
				if ($videoID) {
					$media_target_class = ' media-modal';
					$titleIconClass = 'icon-video-play';
					$modal_code = '<div class="modal-window emb-video"><div class="modal-body"><div class="emb_video"><iframe width="640" height="360" src="http://www.youtube.com/embed/'.$videoID.'?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allowfullscreen id="'.$videoID.'" allowscriptaccess="always"></iframe></div></div></div>';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************

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
				$sns_share_code = ($options['hatebu_number_after_title_'.$current_archive_flag] || $options['tweet_number_after_title_'.$current_archive_flag] || $options['likes_number_after_title_'.$current_archive_flag] || !empty($sns_insert_content) ) ? '<div class="loop-share-num">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.$sns_insert_content.'</div>' : '';				// ************* SNS sahre number *****************
				
				// even of odd
				$evenOddClass = (++$i % 2 === 0) ? 'evenpost' : 'oddpost';

				//Fix post title
				$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');
				
				// Title		
				if (mb_strlen($post_title,'utf-8') > $titleStrCount) $post_title = mb_substr($post_title, 0, $titleStrCount,'utf-8') . '...'; 
		?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article <?php echo $evenOddClass; ?>">
	<div class="loop-article-inner portfolio">
	<div class="loop-post-thumb"><?php echo show_post_thumbnail($width, $height); ?></div>
	<header><h1 class="entry-title loop-title portfolio"><a href="<?php the_permalink() ?>" rel="bookmark"<?php echo $titleIconClass2 ?>>
	<?php
				if ($postFormat === 'quote'): // Check the post format 
					_e('Quote', 'DigiPress');
				else :
					echo $post_title;
				endif;
	?>
	</a></h1><?php echo $sns_share_code; ?></header>
	<div class="loop-flip">
	<div class="loop-flip-inner clearfix">
	<footer>
	<div class="meta-div portfolio"><?php showPostMetaForArchive(); ?></div>
	</footer>
	</div><?php // loop-flip-inner ?>
	</div><?php // loop-flip ?>
	<?php echo $media_icon_code; ?>
	</div><?php // loop-article-inner ?>
	<?php echo $modal_code; ?>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
	</article>
	<?php
			endwhile;
	?>
	</div>
	</section>
	<?php

		elseif ($archive_style === 'magazine') : 
		// ***********************************
		// Magazine View
		// ***********************************

			$excerpt_length = $options['archive_magazine_excerpt_length'];
	?>
	<section id="loop-section" class="magazine clearfix">
	<?php 
			// Thumbnail size
			$width = 630;
			$height = 450;

			// Main title
			if ($options[$current_archive_flag.'_posts_list_title'] && !is_paged()) {
				echo '<header class="loop-sec-header"><h1>'.$options[$current_archive_flag.'_posts_list_title'].'</h1></header>';
			}

			// Loop block_
			if ( $COLUMN_NUM === 1 ) : 
	?>
	<div class="loop-div one-col">
	<?php
			else : 
	?>
	<div class="loop-div two-col">
	<?php
			endif;	// end of $COLUMN_NUM

			//Loop each post
			while (have_posts()) : the_post();

				// Post format
				$postFormat = get_post_format($post->ID);

				// Get icon class each post format
				$titleIconClass = postFormatIcon($postFormat);
				// Append icon class attribute
				$titleIconClass2 = $titleIconClass ? ' class="'.$titleIconClass.'"' : '';

				// Video ID(YouTube only)
				$videoID = get_post_meta($post->ID, 'item_video_id', true);

				// *************************************
				// For media icon and modal window
				$media_icon_nav_url = get_permalink();
				if ($postFormat === 'image' || $postFormat === 'gallery') {
					$media_target_class = ' media-modal';
					$media_icon_nav_url = show_post_thumbnail($width, $height, get_the_ID(), false);
					$modal_code = '<div class="modal-window"><div class="modal-body"><img src="'.$media_icon_nav_url.'" class="modal-item-image" alt="modal image" /><div class="icon-cross-circled modal-close"><span>Close</span></div></div></div>';
				} else if (!$postFormat) {
					$media_target_class = '';
					$titleIconClass = 'icon-zoom-in';
					$modal_code = '';
				} else {
					$media_target_class = '';
					$modal_code = '';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************
				// YouTube embed player
				if ($videoID) {
					$media_target_class = ' media-modal';
					$titleIconClass = 'icon-video-play';
					$modal_code = '<div class="modal-window emb-video"><div class="modal-body"><div class="emb_video"><iframe width="640" height="360" src="http://www.youtube.com/embed/'.$videoID.'?enablejsapi=1&version=3&playerapiid=ytplayer" frameborder="0" allowfullscreen id="'.$videoID.'" allowscriptaccess="always"></iframe></div></div></div>';
				}
				$media_icon_code = '<div class="loop-media-icon'.$media_target_class.'"><a href="'.$media_icon_nav_url.'"><span class="'.$titleIconClass.'"></span></a></div>';
				// *************************************
				
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
				// Class for thumbnail width
				if ($COLUMN_NUM === 1) {
					$wideColClass = ( $i === 1 || $i %7 === 1) ? ' msnry-w': ' msnry-s';
				} else {
					$wideColClass = ( $i === 1 ) ? ' msnry-w': ' msnry-s';
				}


				if ( $excerpt_length != 0 ) {
					// String count and fix length of the excerpt
					$desc = strip_tags(get_the_excerpt());
					if (mb_strlen($desc,'utf-8') > $excerpt_length) $desc = mb_substr($desc, 0, $excerpt_length,'utf-8').'…';
				}
	?>
	<article id="post-<?php the_ID(); ?>" class="hentry loop-article clearfix <?php echo $evenOddClass.$wideColClass; ?>">
	<div class="loop-post-thumb magazine"><?php echo $media_icon_code; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo show_post_thumbnail($width, $height); ?></a></div>
	<header><h1 class="entry-title loop-title magazine"><a href="<?php the_permalink() ?>"<?php echo $titleIconClass2; ?> rel="bookmark" title="<?php the_title_attribute(); ?>">
	<?php
				if ($postFormat === 'quote'): // Check the post format 
					_e('Quote', 'DigiPress');
				else :
					echo $post_title;
				endif;
	?>
	</a></h1>
	<?php echo $sns_share_code; ?>
	<div class="meta-div magazine"><?php showPostMetaForArchive(); ?></div>
	</header>
<?php
				if ( $excerpt_length != 0 ) :
?>
	<div class="entry-summary loop-desc"><?php echo $desc; ?></div>
<?php 
				endif;
?>
	<?php echo $modal_code; ?>
	<script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>');});</script>
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
		if ( $options['autopager'] ) : 
		$next_page_link = is_ssl() ? str_replace('http:', 'https:', get_next_posts_link($options['navigation_text_to_2page_'.$current_archive_flag])) : get_next_posts_link($options['navigation_text_to_2page_'.$current_archive_flag]);
	?>
	<nav class="navigation clearfix"><div class="nav_to_paged"><?php echo $next_page_link; ?></div></nav>
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
endif; 	// End of if (isset( $_REQUEST['q'] )
?>
</div><?php // end of #container ?>
</div><?php // end of #main-wrap


// **********************************
// Breadcrumb
// **********************************
echo '<div id="dp_breadcrumb_div">'.dp_breadcrumb(false).'</div>';	
?>
<?php get_footer(); ?>
</body>
</html>