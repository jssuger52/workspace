<?php 
if ( $options['show_top_content'] == false ) return;

$views				= '';
$hatebuImgCode		= '';
//$tweetCountCode		= '';
//$fbLikeCountCode	= '';

if (is_home() && !is_paged()) : ?>
<section class="new-entry">
<header class="loop-sec-header indx-top"><h1><span><?php echo $options['new_post_label'];?></span></h1></header>
<div id="scrollentrybox">
<ul>
		<?php
		// For thumbnail size
		$width = 180;
		$height = 132;

		$cat_code = '';

		$more_url = $options['autopager'] ? '' : esc_url(get_pagenum_link(2));
		
		// Query
		if ($options['show_specific_cat_index_top'] === 'cat') {
			if ($options['index_top_except_cat']) {
				// Add nimus each category id
				$cat_ids = preg_replace('/(\d+)/', '-${1}', $options['index_top_except_cat_id']);
				$latest =  get_posts($query_string . '&numberposts=' . $options['new_post_count'] . '&category=' . $cat_ids);
				$more_url = '';
			} else {
				$latest =  get_posts($query_string . '&numberposts=' . $options['new_post_count'] . '&category=' . $options['specific_cat_index_top']);
				$more_url = get_category_link($options['specific_cat_index_top']);
			}
			
		} else if ($options['show_specific_cat_index_top'] === 'custom') {
			$latest =  get_posts($query_string . '&numberposts=' . $options['new_post_count'] . '&post_type=' . $options['specific_post_type_index_top']);
			$more_url = get_post_type_archive_link($options['specific_post_type_index_top']);
		} else {
			$latest = get_posts($query_string . '&numberposts=' . $options['new_post_count']);
		}
		
		foreach( $latest as $post ): setup_postdata($post);
			if (!get_post_meta(get_the_ID(), 'hide_in_index', true)) :
			
			// ************* SNS sahre number *****************
			// hatebu
			if ($options['show_hatebu_number_newentry']) {
				$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
			}
				
			// Count tweets
			if ($options['show_tweet_number_newentry']) {
				$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
			}

			// Count Facebook Like 
			if ($options['show_likes_number_newentry']) {
				$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
			}
			$sns_share_code = ($options['show_hatebu_number_newentry'] || $options['show_tweet_number_newentry'] || $options['show_likes_number_newentry']) ? '<div class="loop-share-num in-blk">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.'</div>' : '';
			// ************* SNS sahre number *****************
		?>
<li id="newentry-<?php the_ID(); ?>" class="clearfix">
<?php
			// Views
			if ($options['show_views_on_meta'] && function_exists('dp_get_post_views') && !$options['show_specific_cat_index_top'] === 'custom') {
				$views = '<span class="icon-eye ft11px">'.dp_get_post_views(get_the_ID(), null).'</span>';
			}
			// Thumbnail
			if ($options['show_thumbnail'] == true) {
				echo '<div class="widget-post-thumb"><a href="'.get_permalink().'" title="'.get_the_title().'">';
				// Get thumbnail
				echo show_post_thumbnail($width, $height);
				echo '</a></div>';
			}
			
			// Date
			if ( $options['show_pubdate'] == true ) echo '<span class="entrylist-date">'.get_the_date().'</span>';

			// Category
			if ($options['show_specific_cat_index_top'] !== 'custom' && $options['show_cat_entrylist']) {
				$cats = get_the_category();
				if ($cats) {
					$cats = $cats[0];
					$cats_code = '<a href="'.get_category_link($cats->cat_ID).'" rel="tag">' .$cats->cat_name.'</a>';
					$cats_code = '<div class="entrylist-cat meta-cat">' .$cats_code. '</div>';
				}
				echo $cats_code;
			}
?>
<a href="<?php the_permalink(); ?>" class="entrylist-title" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php echo $sns_share_code; ?> <?php if (comments_open() && $options['show_comment_num_index']) : ?><span class="icon-comment ft11px reverse-link"><?php comments_popup_link(' 0 ', ' 1 ',  ' % '); ?></span><?php endif; ?> <?php echo $views; ?><script>j$(function() {get_sns_share_count('<?php the_permalink(); ?>', 'newentry-<?php the_ID(); ?>');});</script></li>
<?php
			endif;
		endforeach;

		// Reset Query
		wp_reset_postdata();
?>
</ul>
</div>
<?php 
		// More link
		if (!empty($more_url) && !empty($options['new_post_to_archive_label'])) {
			echo '<a href="'.$more_url.'" class="more-entry-link"><span>'.html_entity_decode($options['new_post_to_archive_label']).'</span></a>';
		}
?>
</section>
<?php endif; ?>