<?php
function postFormatIcon($format) {
	$titleIconClass = '';
	switch  ($format) {
		case 'aside':
			$titleIconClass = ' icon-pencil';
			break;
		case 'gallery':
			$titleIconClass = ' icon-pictures';
			break;
		case 'image':
			$titleIconClass = ' icon-picture';
			break;
		case 'quote':
			$titleIconClass = ' icon-quote-left';
			break;
		case 'status':
			$titleIconClass = ' icon-comment';
			break;
		case 'video':
			$titleIconClass = ' icon-video-play';
			break;
		case 'audio':
			$titleIconClass = ' icon-music';
			break;
		case 'chat':
			$titleIconClass = ' icon-comment';
			break;
		case 'link':
			$titleIconClass = ' icon-link';
			break;
		default:
			$titleIconClass = '';
			break;
	}

	return $titleIconClass;
}

/*******************************************************
* Published time diff
*******************************************************/
function publishedDiff(){
	$from 	= get_post_time('U',true); 	// Published datetime
	$to 	= time(); 				// Current time
	$diff 	= $to - $from; 			// Diff
	$code 	= '';
	if ( $diff < 0 ) {
		$code = '<span class="icon-clock"><time datetime="'.get_the_date('c').'" pubdate="pubdate">'.human_time_diff( $from, $to ) . __(' ago','DigiPress').'</time></span>';
	} elseif ( abs($diff) <= 86400 ) {
		// Posted in less than 24 hours
		// $code = '<span><time datetime="'.get_the_date('c').'" pubdate="pubdate">'.__('This article was posted in less than 24 hours.','DigiPress').'</time></span>';
		$code = '<span class="icon-clock"><time datetime="'.get_the_date('c').'" pubdate="pubdate">'.human_time_diff( $from, $to ) . __(' ago','DigiPress').'</time></span>';
	} else {
		$code = '<span class="icon-clock"><time datetime="'.get_the_date('c').'" pubdate="pubdate">'.human_time_diff( $from, $to ) . __(' ago','DigiPress').'</time></span>';
	}
	return $code;
}

/*******************************************************
* Meta content in excerpt
*******************************************************/
function showPostMetaForArchive() {
	if (post_password_required()) return;

	global $options, $post, $ARCHIVE_STYLE, $IS_MOBILE_DP;
	
	extract($ARCHIVE_STYLE);

	// Get post type
	$postType 	= get_post_type();

	$current_archive_flag = '';
	$html_code	= '';
	$tags_code	= '';
	$cats_code	= '';
	$comment_code 	= '';
	$views_code 	= '';
	$author_code	= '';
	$rating_num 	= 0;
	$rating_code 	= '';

	// Post parameters
	$dp_hide_date 			= get_post_meta(get_the_ID(), 'dp_hide_date', true);
	$dp_hide_author 		= get_post_meta(get_the_ID(), 'dp_hide_author', true);
	$dp_hide_cat 			= get_post_meta(get_the_ID(), 'dp_hide_cat', true);
	$dp_hide_tag 			= get_post_meta(get_the_ID(), 'dp_hide_tag', true);
	$dp_hide_views 			= get_post_meta(get_the_ID(), 'dp_hide_views', true);
	$dp_star_rating_enable 	= get_post_meta(get_the_ID(), 'dp_star_rating_enable', true);
	$dp_star_rating 		= get_post_meta(get_the_ID(), 'dp_star_rating', true);


	// Published date
	if ( $options['show_pubdate_on_meta'] && !$dp_hide_date) {
		if ($archive_style !== 'normal' || $archive_normal_style !== 'all') {
			$html_code .= '<div class="meta-date icon-clock"><time datetime="'. get_the_date('c').'" pubdate="pubdate" class="updated">'.get_the_date().'</time></div>';
		}
	}

	// Category
	if ($postType === 'post' && $options['show_cat_on_meta'] && !$dp_hide_cat) {
		$cats = get_the_category();

		if ($archive_style === 'normal' && $archive_normal_style === 'all') {
			if ($cats) {
				for ($i = 0; $i < 3; $i++) {
					if ($cats[$i]) {
						$cats_code .= '<a href="'.get_category_link($cats[$i]->cat_ID).'" rel="tag">' .$cats[$i]->cat_name.'</a> ';
					} else {
						break;
					}
				}
				// foreach ($cats as $cat) {
				// 	$cats_code .= '<a href="'.get_category_link($cat->cat_ID).'" rel="tag">' .$cat->cat_name.'</a> ';
				// }
			}
		} else {
			if ($cats) {
				$cats = $cats[0];
				$cats_code = '<a href="'.get_category_link($cats->cat_ID).'" rel="tag">' .$cats->cat_name.'</a>';
			}
		}
		$cats_code = '<div class="entrylist-cat meta-cat">' .$cats_code. '</div>';
	}

	// Tags 
	if ( $postType === 'post' && $options['show_tags'] && $archive_style == 'normal' && !$dp_hide_tag) {

		$count = 0;
		$tags = get_the_tags();

		if ($archive_style === 'normal') {
			if ($tags) {
				foreach ($tags as $tag) {
					$count++;
					if ($count < 4) {
						$tags_code .= '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.$tag->count.__(' topics of this tag.', 'DigiPress').'">'.$tag->name.'</a> ';
					} else {
						break;
					}
				}
			}
		} else {
			if ($tags) {
				foreach ($tags as $tag) {
					$count++;
					if ($count === 1) {
						$tags_code .= '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.$tag->count.__(' topics of this tag.', 'DigiPress').'">'.$tag->name.'</a> ';
						break;
					}
				}
			}
		}

		$tags_code = $tags_code ? '<div class="entrylist-cat meta-tag">'.$tags_code.'</div>': '' ;
	}

	// *********************************
	// Add Categories + Tags
	if ( ($archive_style === 'gallery' || $archive_style === 'portfolio') ) {
		$html_code .= '<div class="meta-cat-tag">'.$cats_code.$tags_code.'</div>';
	} else {
		$html_code .= $cats_code.$tags_code;
	}
	// *********************************

	// Comments
	if ( comments_open() ) {
		$comment_code = '<div class="meta-comment icon-comment">'. get_comments_popup_link(
							'0', '1', '%').'</div>';
	}

	// Views 
	if ($options['show_views_on_meta'] && $archive_style != 'news' && function_exists('dp_get_post_views') && !$dp_hide_views) {
		$views_code = '<div class="meta-views icon-eye">'.dp_get_post_views(get_the_ID(), null).'</div>';
	}

	// Author
	if ($options['show_author_on_meta'] && $archive_style != 'news' && !$dp_hide_author ) {
		$author_code .= '<div class="meta-author icon-user vcard"><a href="'.get_author_posts_url(get_the_author_meta('ID')).'" rel="author" title="'.__('Show articles of this user.', 'DigiPress').'" class="fn">'.get_the_author_meta('display_name').'</a></div>';
	}

	// *********************************
	// Add Comments + Views + Author
	$html_code .= '<div class="meta-com-views-author">'.$comment_code.$views_code.$author_code.'</div>';
	// *********************************
	
	// Display
	echo $html_code;
	// Rating 
	if ( $dp_star_rating_enable && function_exists('wp_star_rating') ) {
		wp_star_rating( array('rating' => $dp_star_rating) );
	}
}


/*******************************************************
* Meta content in single and archive that shows all
*******************************************************/
function showPostMetaForSingleTop() { 
	$post_type_name = esc_html(get_post_type_object(get_post_type())->name);
	if (post_password_required() || $post_type_name == 'topic' || $post_type_name == 'forum' || $post_type_name == 'forums' ) return;

	global $options, $post, $IS_MOBILE_DP;

	$blank_flg = true;
	$additional_first_code = '';
	$additional_end_code = '';
	$html_code	= '';

	// GET THE POST TYPE
	$postType = get_post_type();

	// Post parameters
	$dp_hide_date 				= get_post_meta(get_the_ID(), 'dp_hide_date', true);
	$dp_hide_author 			= get_post_meta(get_the_ID(), 'dp_hide_author', true);
	$dp_hide_cat 				= get_post_meta(get_the_ID(), 'dp_hide_cat', true);
	$dp_hide_tag 				= get_post_meta(get_the_ID(), 'dp_hide_tag', true);
	$dp_hide_views 				= get_post_meta(get_the_ID(), 'dp_hide_views', true);
	$dp_hide_fb_comment 		= get_post_meta(get_the_ID(), 'dp_hide_fb_comment', true);
	$dp_star_rating_enable 		= get_post_meta(get_the_ID(), 'dp_star_rating_enable', true);
	$hide_sns_icon 				= get_post_meta(get_the_ID(), 'hide_sns_icon', true);
	$dp_hide_time_for_reading	= get_post_meta(get_the_ID(), 'dp_hide_time_for_reading', true);

	// Common parametaers
	$time_for_reading 			= $options['time_for_reading'];
	$show_pubdate_on_meta 		= $options['show_pubdate_on_meta'];
	$show_pubdate_on_meta_page 	= $options['show_pubdate_on_meta_page'];
	$show_date_under_post_title = $options['show_date_under_post_title'];
	$show_views_on_meta 		= $options['show_views_on_meta'];
	$show_views_under_post_title = $options['show_views_under_post_title'];
	$show_author_on_meta 		= $options['show_author_on_meta'];
	$show_author_on_meta_page 	= $options['show_author_on_meta_page'];
	$show_author_under_post_title = $options['show_author_under_post_title'];
	$show_cat_on_meta 			= $options['show_cat_on_meta'];
	$show_cat_under_post_title 	= $options['show_cat_under_post_title'];
	$sns_button_under_title 	= $options['sns_button_under_title'];


	/****
	 * filter hook
	 */
	$additional_first_code = apply_filters('dp_single_meta_top_first', get_the_ID());
	if (!empty($additional_first_code) && $additional_first_code != get_the_ID()) {
		$html_code .= $additional_first_code;
		$blank_flg = false;
	}

	// Post date
	if ((( is_single() && $show_pubdate_on_meta ) || ( is_page() && $show_pubdate_on_meta_page )) && !$dp_hide_date && $show_date_under_post_title ) : 

		if ($options['date_reckon_mode']) {
			$html_code .= publishedDiff();
		} else {
			$html_code .= '<span class="icon-clock"><time datetime="'. get_the_date('c').'" pubdate="pubdate" class="updated">'.get_the_date().'</time></span>';
		}
		$blank_flg = false;
	endif;

	// Comment
	if ( $post->comment_status == 'open' && !is_page() ) : 
		$html_code .= '<span class="icon-comment">'. get_comments_popup_link(
							__('No Comments', 'DigiPress'), 
							__('Comment(1)', 'DigiPress'), 
							__('Comments(%)', 'DigiPress')).'</span>';
		$blank_flg = false;
	endif; 

	// Views
	if ( $postType === 'post' && $show_views_on_meta && !$dp_hide_views && $show_views_under_post_title ) : 
		$html_code .= '<span class="icon-eye">'.dp_get_post_views(get_the_ID(), null).'</span>';
		$blank_flg = false;
	endif;

	// Author
	if ((( $postType === 'post' && $show_author_on_meta ) || ( $postType === 'page' && $show_author_on_meta_page )) && $show_author_under_post_title && !$dp_hide_author ) : 
		$html_code .= '<span class="icon-user vcard"><a href="'.get_author_posts_url(get_the_author_meta('ID')).'" rel="author" title="'.__('Show articles of this user.', 'DigiPress').'" class="fn">'.get_the_author_meta('display_name').'</a></span>';
		$blank_flg = false;
	endif;

	// Time for reading
	if ( $postType === 'post' && $time_for_reading && !$dp_hide_time_for_reading) {
		$minutes = round(mb_strlen(strip_tags(get_the_content())) / 600) + 1;
		$time_for_reading = '<span class="dp_time_for_reading icon-alarm">' . __('You can read this content about ', 'DigiPress') . $minutes . __(' minute(s)','DigiPress') . '</span>'; 
		$html_code .= $time_for_reading;

		$blank_flg = false;
	}

	// Edit link
	if (is_user_logged_in() && current_user_can('level_10')) {
		$html_code .= '| <a href="'.get_edit_post_link().'">Edit</a>';
	}

	// *******************
	// Create First Row
	// *******************
	$html_code = '<div class="first_row">' . $html_code . '</div>';


	// *******************
	// Second Row...
	
	// Category
	if ( $postType === 'post' && $show_cat_on_meta && $show_cat_under_post_title && !$dp_hide_cat && !$IS_MOBILE_DP) : 

		$cats_code = '';
		$cats = get_the_category();
		if ($cats) {
			foreach ($cats as $cat) {
				$cats_code .= '<a href="'.get_category_link($cat->cat_ID).'" rel="tag">' .$cat->cat_name.'</a> ';
			}

			$cats_code = '<div class="second_row"><div class="entrylist-cat meta-cat">' .$cats_code. '</div></div>';
			$blank_flg = false;
		}
		$html_code .= $cats_code;
	endif;

	// SNS BUttons
	if ( !$hide_sns_icon && $sns_button_under_title && !$IS_MOBILE_DP ) :
		$html_code .= dp_show_sns_buttons('top', false);
		$blank_flg = false;
	endif;

	/****
	 * filter hook
	 */
	$additional_end_code = apply_filters('dp_single_meta_top_end', get_the_ID());
	if (!empty($additional_end_code) && $additional_end_code != get_the_ID()) {
		$html_code .= $additional_end_code;
		$blank_flg = false;
	}

	// Show source
	if (!$blank_flg) {
		$html_code = '<div class="single_post_meta">' . $html_code . '</div>';
		echo $html_code;
	}
}	// End function 


/*******************************************************
* Meta content for post meta
*******************************************************/
function showPostMetaForSingleBottom() {
	$post_type_name = esc_html(get_post_type_object(get_post_type())->name);
	if (post_password_required() || $post_type_name == 'topic' || $post_type_name == 'forum' || $post_type_name == 'forums' ) return;

	global $options, $post, $IS_MOBILE_DP;

	$blank_flg = true;
	$additional_first_code = '';
	$additional_end_code = '';
	$html_code	= '';

	// GET THE POST TYPE
	$postType = get_post_type();

	// Post parameters
	$dp_hide_date 			= get_post_meta(get_the_ID(), 'dp_hide_date', true);
	$dp_hide_author 		= get_post_meta(get_the_ID(), 'dp_hide_author', true);
	$dp_hide_cat 			= get_post_meta(get_the_ID(), 'dp_hide_cat', true);
	$dp_hide_tag 			= get_post_meta(get_the_ID(), 'dp_hide_tag', true);
	$dp_hide_views 			= get_post_meta(get_the_ID(), 'dp_hide_views', true);
	$dp_hide_fb_comment 	= get_post_meta(get_the_ID(), 'dp_hide_fb_comment', true);
	$dp_star_rating_enable 	= get_post_meta(get_the_ID(), 'dp_star_rating_enable', true);
	$dp_star_rating 		= get_post_meta(get_the_ID(), 'dp_star_rating', true);
	$hide_sns_icon 			= get_post_meta(get_the_ID(), 'hide_sns_icon', true);

	// Common parametaers
	$time_for_reading 			= $options['time_for_reading'];
	$show_pubdate_on_meta 		= $options['show_pubdate_on_meta'];
	$show_pubdate_on_meta_page 	= $options['show_pubdate_on_meta_page'];
	$show_date_on_post_meta 	= $options['show_date_on_post_meta'];
	$show_last_update 			= $options['show_last_update'];
	$show_views_on_meta 		= $options['show_views_on_meta'];
	$show_views_on_post_meta 	= $options['show_views_on_post_meta'];
	$show_author_on_meta 		= $options['show_author_on_meta'];
	$show_author_on_meta_page 	= $options['show_author_on_meta_page'];
	$show_author_on_post_meta 	= $options['show_author_on_post_meta'];
	$show_cat_on_meta 			= $options['show_cat_on_meta'];
	$show_cat_on_post_meta 		= $options['show_cat_on_post_meta'];
	$show_tags 					= $options['show_tags'];
	$sns_button_on_meta 		= $options['sns_button_on_meta'];

	/****
	 * filter hook
	 */
	$additional_first_code = apply_filters('dp_single_meta_bottom_first', get_the_ID());
	if (!empty($additional_first_code) && $additional_first_code != get_the_ID()) {
		$html_code .= $additional_first_code;
		$blank_flg = false;
	}

	// Category
	if (!is_page()) {
		// if(function_exists('the_ratings')) the_ratings();
		if ($postType === 'post' && $show_cat_on_meta && $show_cat_on_post_meta && !$dp_hide_cat ) {

			$cats_code = '';
			$cats = get_the_category();
			if ($cats) {
				foreach ($cats as $cat) {
					$cats_code .= '<a href="'.get_category_link($cat->cat_ID).'" rel="tag">' .$cat->cat_name.'</a> ';
				}

				$cats_code = '<div class="entrylist-cat meta-cat">' .$cats_code. '</div>';
				$blank_flg = false;
			}
			$html_code .= $cats_code;
		}
	}

	//Show tags
	if ( $show_tags && !$dp_hide_tag ) { 
		$tags_code = '';

		$tags = get_the_tags();
		if ($tags) {
			foreach ($tags as $tag) {
				$tags_code .= '<a href="'.get_tag_link($tag->term_id).'" rel="tag" title="'.$tag->count.__(' topics of this tag.', 'DigiPress').'">'.$tag->name.'</a> ';
			}
			$tags_code = '<div class="entrylist-cat meta-tag">'.$tags_code.'</div>';
			$blank_flg = false;
		}
		$html_code .= $tags_code;
	}

	// Post Date
	if ( ((is_single() && $show_pubdate_on_meta) || (is_page() && $show_pubdate_on_meta_page)) && !$dp_hide_date && $show_date_on_post_meta ) {

		// Last update
		if ( $show_last_update && ( get_the_modified_date() != get_the_date()) ) {
			$lastUpdate =  ' ('.__('Last Update:', 'DigiPress').get_the_modified_date().')';
		} else {
			$lastUpdate = '';
		}
		$blank_flg = false;

		$html_code .= '<span class="icon-clock"><time datetime="'. get_the_date('c').'" pubdate="pubdate" class="updated">'.get_the_date().'</time>'.$lastUpdate.'</span>';
	}

	// If comment and trackback is open
	if ( ('open' == $post->comment_status) && !is_page() ) {
		$blank_flg = false;
		$html_code .= '<span class="icon-edit"><a href="#respond">'.__('Comment', 'DigiPress').'</a></span><span class="icon-comment">'. get_comments_popup_link(
							__('No Comments', 'DigiPress'), 
							__('Comment(1)', 'DigiPress'), 
							__('Comments(%)', 'DigiPress')).'</span>';
	}

	// Views
	if (($postType === 'post' ) && $show_views_on_meta && !$dp_hide_views && $show_views_on_post_meta && function_exists('dp_get_post_views')) {
		$blank_flg = false;
		$html_code .= '<span class="icon-eye">'.dp_get_post_views(get_the_ID(), null).'</span>';
	}

	// Author
	if ((($postType === 'post' && $show_author_on_meta) || ($postType === 'page' && $show_author_on_meta_page)) && !$dp_hide_author && $show_author_on_post_meta ) {
		$blank_flg = false;
		$html_code .= '<span class="icon-user vcard"><a href="'.get_author_posts_url(get_the_author_meta('ID')).'" rel="author" title="'.__('Show articles of this user.', 'DigiPress').'" class="fn">'.get_the_author_meta('display_name').'</a></span>';
	}

	// Edit link
	if (is_user_logged_in() && current_user_can('level_10')) {
		$html_code .= '| <a href="'.get_edit_post_link().'">Edit</a>';
	}

	if (!$blank_flg) {
		$html_code = '<div class="first_row">'.$html_code.'</div>';
	}

	// SNS BUttons
	if ( !$hide_sns_icon &&  $sns_button_on_meta ) {
		$blank_flg = false;
		$html_code .= dp_show_sns_buttons('bottom', false);
	}

	/****
	 * filter hook
	 */
	$additional_end_code = apply_filters('dp_single_meta_bottom_end', get_the_ID());
	if (!empty($additional_end_code) && $additional_end_code != get_the_ID()) {
		$html_code .= $additional_end_code;
		$blank_flg = false;
	}

	if (!$blank_flg) {
		$html_code = '<footer class="single_post_meta">'.$html_code.'</footer>';
		echo $html_code;
	}

}	// End function



/*******************************************************
* Meta content in single and archive for MOBILE
*******************************************************/
function showPostMetaForArchiveMobile() {
	if (post_password_required() || esc_html(get_post_type_object(get_post_type())->name) == 'topic' ) return;

	global $options, $post, $ARCHIVE_STYLE, $IS_MOBILE_DP;
	
	extract($ARCHIVE_STYLE);

	// Get post type
	$postType 	= get_post_type();

	$current_archive_flag = '';
	$html_code	= '';
	$tags_code	= '';
	$cats_code	= '';
	$comment_code 	= '';
	$views_code 	= '';
	$author_code	= '';
	$rating_num 	= 0;
	$rating_code 	= '';

	// Post parameters
	$dp_hide_date 	= get_post_meta(get_the_ID(), 'dp_hide_date', true);
	$dp_hide_author 	= get_post_meta(get_the_ID(), 'dp_hide_author', true);
	$dp_hide_cat 		= get_post_meta(get_the_ID(), 'dp_hide_cat', true);
	$dp_hide_tag 		= get_post_meta(get_the_ID(), 'dp_hide_tag', true);
	$dp_hide_views 	= get_post_meta(get_the_ID(), 'dp_hide_views', true);
	$dp_star_rating_enable = get_post_meta(get_the_ID(), 'dp_star_rating_enable', true);
	$dp_star_rating 	= get_post_meta(get_the_ID(), 'dp_star_rating', true);


	// Published date
	if ( $options['show_pubdate_on_meta'] && !$dp_hide_date) {
		if ($archive_style !== 'normal' || $archive_normal_style !== 'all') {
			$html_code .= '<div class="meta-date icon-clock"><time datetime="'. get_the_date('c').'" pubdate="pubdate" class="updated">'.get_the_date().'</time></div>';
		}
	}

	// Category
	if ($postType === 'post' && $options['show_cat_on_meta'] && $archive_style != 'news' && $archive_style != 'normal' && $archive_style != 'magazine' && !$dp_hide_cat) {
		$cats = get_the_category();
		if ($cats) {
				$cats = $cats[0];
				$cats_code = '<a href="'.get_category_link($cats->cat_ID).'" rel="tag">' .$cats->cat_name.'</a>';
			}
		$cats_code = '<div class="entrylist-cat meta-cat">' .$cats_code. '</div>';
		$html_code .= $cats_code;
	}

	// Comments
	if ( comments_open() ) {
		$comment_code = '<div class="meta-comment icon-comment">'. get_comments_popup_link(
							'0', '1', '%').'</div>';
	}

	// Views 
	if ($options['show_views_on_meta'] && $archive_style != 'news' && $archive_style != 'normal' && $archive_style != 'magazine' && function_exists('dp_get_post_views') && !$dp_hide_views) {
		$views_code = '<div class="meta-views icon-eye">'.dp_get_post_views(get_the_ID(), null).'</div>';
	}

	// Author
	if ($options['show_author_on_meta'] && $archive_style != 'news' && $archive_style != 'normal' && $archive_style != 'magazine' && !$dp_hide_author ) {
		$author_code .= '<div class="meta-author icon-user vcard"><a href="'.get_author_posts_url(get_the_author_meta('ID')).'" rel="author" title="'.__('Show articles of this user.', 'DigiPress').'" class="fn">'.get_the_author_meta('display_name').'</a></div>';
	}


	// *********************************
	// Add Comments + Views + Author
	$html_code .= '<div class="meta-com-views-author">'.$comment_code.$views_code.$author_code.'</div>';
	// *********************************
	
	// Display
	echo $html_code;
	// Rating 
	if ( $dp_star_rating_enable && function_exists('wp_star_rating') && $archive_style != 'normal' && $archive_style != 'magazine' ) {
		wp_star_rating( array('rating' => $dp_star_rating) );
	}
}	//End function 
?>