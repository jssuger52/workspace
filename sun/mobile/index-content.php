<?php 
if ( $options['show_top_under_content'] == false ) return;

$top_post_show_type = $options['top_post_show_type'];

$date_code 			= ''; 


// Counter
$i = 0;

//For thumbnail size
$width = 680;
$height = 480;

$hatebuNumberCode 	= '';
$tweetCountCode		= '';
$fbLikeCountCode	= '';

if ( $top_post_show_type == 'gallery' || $top_post_show_type == 'portfolio' ) :
// ***********************************
// Appeal image View
// ***********************************
?>
<section id="loop-section" class="app-image mb-theme clearfix">
<?php 
	// Main title
	if ($options['top_posts_list_title'] && !is_paged()) {
		echo '<header class="loop-sec-header"><h1><span>'.$options['top_posts_list_title'].'</span></h1></header>';
	}
?>
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
		if ($options['hatebu_number_after_title_top']) {
			$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
		}
			
		// Count tweets
		if ($options['tweet_number_after_title_top']) {
			$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
		}

		// Count Facebook Like 
		if ($options['likes_number_after_title_top']) {
			$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
		}
		/***
		 * Filter hook
		 */
		$sns_insert_content = apply_filters( 'dp_top_insert_sns_content', get_the_ID() );
		if ($sns_insert_content == get_the_ID() || !is_string($sns_insert_content)) {
			$sns_insert_content = '';
		}

		// Whole share code
		$sns_share_code = ($options['hatebu_number_after_title_top'] || $options['tweet_number_after_title_top'] || $options['likes_number_after_title_top'] || !empty($sns_insert_content)) ? '<div class="loop-share-num">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.$sns_insert_content.'</div>' : '';
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

else : 
// ***********************************
// Normal blog View
// ***********************************
?>
<section id="loop-section" class="blog mb-theme clearfix">
<?php 
	// Thumbnail size
	$width = 680;
	$height = 600;

	// Main title
	if ($options['top_posts_list_title'] && !is_paged()) {
		echo '<header class="loop-sec-header"><h1><span>'.$options['top_posts_list_title'].'</span></h1></header>';
	}
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
		if ($options['hatebu_number_after_title_top']) {
			$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
		}
			
		// Count tweets
		if ($options['tweet_number_after_title_top']) {
			$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
		}

		// Count Facebook Like 
		if ($options['likes_number_after_title_top']) {
			$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
		}
		/***
		 * Filter hook
		 */
		$sns_insert_content = apply_filters( 'dp_top_insert_sns_content', get_the_ID() );
		if ($sns_insert_content == get_the_ID() || !is_string($sns_insert_content)) {
			$sns_insert_content = '';
		}

		// Whole share code
		$sns_share_code = ($options['hatebu_number_after_title_top'] || $options['tweet_number_after_title_top'] || $options['likes_number_after_title_top'] || !empty($sns_insert_content)) ? '<div class="loop-share-num">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.$sns_insert_content.'</div>' : '';
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
endif;	// end of $top_post_show_type

// ***********************************
// Navigation
// ***********************************
// Front page
if ( $options['autopager_mb'] || (is_front_page() && !is_paged()) ) : ?>
<nav class="navigation clearfix"><div class="nav_to_paged"><?php next_posts_link($options['navigation_text_to_2page']) ?></div></nav>
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
