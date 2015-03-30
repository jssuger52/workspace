<?php
function dp_get_related_posts() {
	global $post, $options, $options_visual, $COLUMN_NUM;

	if (post_password_required()) return;

	$postType 				= get_post_type();
	$related_posts_style 	= $options['related_posts_style'];
	$related_posts_target 	= $options['related_posts_target'];

	$cat_code = '';


	// *****************************
	// Main display
	// *****************************
	if ($postType !== 'post' && $postType !== 'page' && $postType !== 'attachment' && $postType !== 'revision') : 
		
		// ***********************************
		// Probably Custom post type
		// ***********************************
	 
		// Get title
		$customPostTypeObj 		= get_post_type_object(get_post_type());
		$customPostTypeTitle 	= esc_html($customPostTypeObj->labels->name);

		// Get posts
		$latest =  get_posts('numberposts=' . $options['new_post_count'] . '&post_type=' . $postType . '&exclude=' . $post->ID);
	?>
<section class="new-entry">
<h3 class="inside-title"><span><?php echo __('Other posts of ', 'DigiPress') . $customPostTypeTitle; ?></span></h3>
<div id="scrollentrybox-single">
<ul>
	<?php 
		// Show posts of custom post type
		foreach( $latest as $post ) : setup_postdata($post); 
	?>
<li class="clearfix">
	<?php echo '<span class="entrylist-date">'.get_the_date().'</span>'; ?>
<a href="<?php the_permalink(); ?>" class="entrylist-title" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</li>
	<?php
		endforeach;
		wp_reset_postdata();
	?>
</ul>
</div>
</section>
<?php
	elseif ((get_post_type() === 'post') && is_single() && $options['show_related_posts']) :
		// ***********************************
		// Probably single post
		// *********************************** 
		
		// Type
		if ($related_posts_style === 'horizon') {
			$type = ' horizontal';
		} else {
			$type = ' vertical';
		}

		// Column
		$col_css	= ' two-col';
		if ($COLUMN_NUM === 1 || get_post_meta(get_the_ID(), 'disable_sidebar', true)) {
			$col_css	= ' one-col';
		} else if ($options_visual['dp_column'] == 3) {
			$col_css	= ' three-col';
		}
?>
<aside class="dp_related_posts clearfix<?php echo $type.$col_css; ?>">
<h3 class="inside-title"><span><?php echo $options['related_posts_title']; ?></span></h3>
<ul>
<?php
		// Get related posts
		$number_posts	= $options['number_related_posts'];
		// Thumbnail size
		$width			= 300;
		$height			= 262;


		// Target
		if ($related_posts_target == 2) {
			$cat = get_the_category();
			$cat = $cat[0];
			$args = array(
				'numberposts'	=> $number_posts,
				'category'		=> $cat->cat_ID,
				'exclude'		=> $post->ID
				);

		} else if ($related_posts_target == 3) {
			$cat = get_the_category();
			$cat = $cat[0];
			$args = array(
				'numberposts'	=> $number_posts,
				'category'		=> $cat->cat_ID,
				'exclude'		=> $post->ID,
				'orderby'		=> 'rand'
				);

		} else {
			$tagIDs		= array();
			$tags		= wp_get_post_tags($post->ID);
			$tagcount 	= count($tags);
			for ($i = 0; $i < $tagcount; $i++) {
				$tagIDs[$i] = $tags[$i]->term_id;
			}
			$args = array(
				'tag__in'			=> $tagIDs,
				'post__not_in'		=> array($post->ID),
				'numberposts'		=> $number_posts,
				'exclude'			=> $post->ID,
				'caller_get_posts'	=> 1
				);
		}

		// Query
		$my_query = get_posts($args);

		// Display
		if ($my_query) :
			foreach ( $my_query as $post ) : setup_postdata( $post );
				$title = the_title('', '', false); 
?>
<li class="clearfix">
<?php 
				//If show thumbnail
				if ($options['related_posts_thumbnail']) : 
					if ($related_posts_style === 'horizon') {
						if (mb_strlen($title) > 52) $title = mb_substr($title, 0, 51).'...';
					}
?>
<div class="widget-post-thumb"><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php echo show_post_thumbnail($width, $height); ?></a></div>
<?php 
				endif;

				if ( $options['show_pubdate_on_meta'] && $related_posts_style === 'vertical') :
?>
<div class="rel-pub-date"><time datetime="<?php the_time('c'); ?>" pubdate="pubdate"><?php echo get_the_date();?></time></div>
<?php
				endif;

				// Category
				if ($options['related_posts_category']) :
					$cats = get_the_category();
					if ($cats) {
						$cats = $cats[0];
						$cats_code = '<a href="'.get_category_link($cats->cat_ID).'" rel="tag">' .$cats->cat_name.'</a>';
					}
?>
<div class="entrylist-cat"><?php echo $cats_code; ?></div>
<?php 
				endif;
?>
<h4><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php echo $title; ?></a></h4>
</li>
<?php
			endforeach; 
			wp_reset_postdata();
		else :
?>
<li><?php _e('No related posts yet.', 'DigiPress'); ?></li>
<?php 
		endif;
?>
</ul>
</aside>
<?php
	endif;	// End of "Main display"
}
?>