<?php
/****************************************************************
* Create link with the screenshot of target page.
****************************************************************/
function dp_sc_link_with_screen_shot($atts) {
	extract(shortcode_atts(array(
		'url'		=> '',
		'width'		=> 250,
		'class'		=> '',
		'alt'		=> 'Screenshot',
		'rel'		=> '',
		'ext'		=> 1,
		'title'		=> '',
		'caption'	=> '',
		'hatebu'	=> 0,
		'tweets'	=> 0,
		'likes'		=> 0
	), $atts));
	
	if ($url == '') return;

	// Get unique key
	$this_id 	= 'sc-sshot-'.dp_rand();
	
	$sns_share_code = '';
	$sns_share_js = '';
	$urlencode 	= urlencode($url);
	$width 		= intval($width);
	$ext 		= (bool)$ext ? ' target="_blank"' : '';
	$rel 		= ($rel == '') ? '' : ' rel="'.$rel.'" ';
	$return 	= '';
	$caption 		= $caption == '' ? '' : '<div class="ft11px mg16px-top">'.$caption.'</div>';

	// JS
    $sns_share_js = '<script>j$(function(){get_sns_share_count("'.$url.'", "'.$this_id.'");});</script>';

	// ************* SNS sahre number *****************
	// hatebu
	if ((bool)$hatebu) {
		$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
	}
	// Count tweets
	if ((bool)$tweets) {
		$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
	}
	// Count Facebook Like 
	if ((bool)$likes) {
		$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
	}
	$sns_share_code = ((bool)$hatebu || (bool)$tweets || (bool)$likes) ? '<div class="loop-share-num in-blk">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.'</div>' : '';
	// ************* SNS sahre number *****************
	
	// Thumbnail
	$img = "<img src=\"http://s.wordpress.com/mshots/v1/{$urlencode}?w={$width}\" class=\"dp_ss bd {$class}\" width=\"{$width}\" alt=\"{$alt}\" />";

	if ($title) {
		$return = "<a href=\"{$url}\"{$ext}{$rel}>{$img}</a><a href=\"{$url}\"{$ext}{$rel} class=\"b ft16px\">{$title}</a>{$sns_share_code}{$caption}";
	} else {
		$return = "<a href=\"{$url}\"{$ext}{$rel}>{$img}</a>{$sns_share_code}{$caption}";
	}
	$return = '<div id="'.$this_id.'" class="clearfix">'.$return.$sns_share_js.'</div>';
    
	return $return;
}
add_shortcode('ss', 'dp_sc_link_with_screen_shot');


/****************************************************************
* Create QR code
****************************************************************/
function dp_sc_create_qrcode($atts) {
	extract(shortcode_atts(array(
		'url'	=> home_url(),
		'size'	=> '150',
		'alt'	=> 'QR Code',
		'class'	=> 'alignnone'
	), $atts));

	return "<img src=\"https://chart.googleapis.com/chart?chs={$size}x{$size}&cht=qr&chl={$url}&choe=UTF-8\" class=\"{$class}\" width=\"{$size}\" height=\"{$size}\" alt=\"{$alt}\" />";
}
add_shortcode('qrcode', 'dp_sc_create_qrcode');


/****************************************************************
* Show recent posts in specific category in a post.
****************************************************************/
function dp_sc_get_recent_posts_in_the_category($atts) {
	extract(shortcode_atts(array(
		'num'		=> '5',
		'cat' 		=> '',
		'type' 		=> '',
		'date'		=> 0,
		'sort'		=> 'post_date', //rand, title,
		'order'		=> 'DESC',
		'hatebu'	=> 0,
		'excerpt'	=> 0
	), $atts));
	
	global $post;
	
	$oldpost = $post;
	$myposts = get_posts(
		array(
			'numberposts' 	=> $num,
			'order'			=> $order,
			'orderby'		=> $sort,
			'category'		=> $cat,
			'post_type'		=> $type
		));
	
	$retHtml = '<ul>';
	
	foreach($myposts as $post) :
		setup_postdata($post);
		$desc = '';
		if ((bool)$excerpt) {
			$desc = get_the_excerpt();
			if (mb_strlen($desc) > 84) $desc = mb_substr($desc, 0, 84).'…';
			$desc = '<div class="entrylist-cat ft11px">'.$desc.' <br /><a href="'.get_permalink().'" title="'.__('Read more', 'DigiPress').'">'.__('Read more', 'DigiPress').'</a></div>';
		}
		$hatebuCode = ((bool)$hatebu) ? '<a href="//b.hatena.ne.jp/entry/' . get_permalink() . '" target="_blank"><img src="//b.hatena.ne.jp/entry/image/' . get_permalink() . '" alt="' . __('Bookmark number in hatena', 'DigiPress') . '" class="dp_ss_hatebu bd-none bg-none" /></a>' : '';
		$dateCode = ((bool)$date) ? '<span class="ft11px">'.get_the_time(__('Y.m.d : ','DigiPress')).'</span>' : '';
		$retHtml.='<li>'.$dateCode.'<a href="'.get_permalink().'">'.the_title("","",false).'</a>'.$hatebuCode.$desc.'</li>';
	endforeach;
	
	$retHtml.='</ul>';
	
	$post = $oldpost;

	// Reset Query
	wp_reset_query();
	
	return $retHtml;
}
add_shortcode("recentposts", "dp_sc_get_recent_posts_in_the_category");


/****************************************************************
* Show most viewed posts.
****************************************************************/
function dp_sc_get_most_viewed_posts($atts) {
	extract(shortcode_atts(array(
		'num'		=> '5',
		'date'		=> 0,
		'views'		=> 1,
		'hatebu'	=> 0,
		'tweets'	=> 0,
		'likes'		=> 0,
		'excerpt'	=> 0,
		'thumb' 	=> 0,
		'thumbwidth' => 90,
		'thumbheight' => 53,
		'ranking' 	=> 0,
		'year'		=> '',
		'month'		=> '',
		'cat'		=> '',
		'type'		=> '',
		'term'		=> 'all' // daily, weekly, monthly
	), $atts));

	global $post;

	$retHtml = '';
	
	$cat = str_replace("\s", "", $cat);

	switch ($term) {
		case 'all':
			$term = 'post_views_count';
			break;
		case 'daily':
			$term = 'post_views_count_daily';
			break;
		case 'weekly':
			$term = 'post_views_count_weekly';
			break;
		case 'monthly':
			$term = 'post_views_count_monthly';
			break;
		default:
			$term = 'post_views_count';
			break;
	}

	$myposts = get_posts(array(
					'numberposts'	=> $num,
					'category'		=> $cat,
					'post_type'		=> $type,
					'meta_key'		=> $term,
					'meta_value'	=> $meta_value,
					'orderby'		=> 'meta_value_num',
					'year'			=> $year,
					'month'			=> $month
					)
	);
	
	$retHtml  = '';	
	$viewsCode = '';
	$thumb_code = '';
	$hatebuNumberCode = '';
	$tweetCountCode = '';
	$fbLikeCountCode = '';
	$sns_share_code = '';
	$post_title = '';
	$unique_id = '';
	$js_code = '';
	$date_code = '';
	$desc = '';
	$counter = 0;

	foreach($myposts as $post) :
		setup_postdata($post);

		$post_title = '';
		$unique_id = '';
		$js_code = '';

		// Title
		$post_title =  the_title('', '', false) ? the_title('', '', false) : __('No Title', 'DigiPress');

		// Date
		if ( ((bool)$date) ) {
			$date_code = '<span class="ft12px">' . get_the_date() . '</span> : ';
		}

		// Ranking tag
		if ((bool)$ranking) {
			$counter++;
			if ((bool)$thumb) {
				$ranking_code = '<div class="rank_label thumb">'.$counter.'</div>';
			} else {
				$ranking_code = '<div class="rank_label no-thumb">'.$counter.'</div>';
			}
		}

		if ((bool)$excerpt) {
			$desc = get_the_excerpt();
			if (mb_strlen($desc) > 64) $desc = mb_substr($desc, 0, 64).'…';
			$desc = '<div class="ft11px mg10px-btm">'.$desc.' <br /><div class="entrylist-cat"><a href="'.get_permalink().'" title="'.__('Read more', 'DigiPress').'">'.__('Read more', 'DigiPress').'</a></div></div>';
		}

		$viewsCode = ((bool)$views) ? '<span class="mg5px-l ft12px meta_views">'.dp_get_post_views(get_the_ID(), $term).' views</span>' : '';

		// ************* SNS sahre number *****************
		// hatebu
		if ((bool)$hatebu) {
			$hatebuNumberCode = '<div class="bg-hatebu icon-hatebu"><span class="share-num"></span></div>';
		}
			
		// Count tweets
		if ((bool)$tweets) {
			$tweetCountCode = '<div class="bg-tweets icon-twitter"><span class="share-num"></span></div>';
		}

		// Count Facebook Like 
		if ((bool)$likes) {
			$fbLikeCountCode = '<div class="bg-likes icon-facebook"><span class="share-num"></span></div>';
		}
		if ((bool)$hatebu || (bool)$tweets || (bool)$likes) {
			// Get Unique ID
			$unique_id 			= 'scmvp-'.dp_rand().'-'.get_the_ID();
			$sns_share_code = '<div class="loop-share-num in-blk">'.$hatebuNumberCode.$tweetCountCode.$fbLikeCountCode.'</div>';
			$js_code = '<div><script>j$(function() {get_sns_share_count("'.get_permalink().'", "'.$unique_id.'");});</script></div>';
		}
		// ************* SNS sahre number *****************

		// Thumbnail
		if ((bool)$thumb) {
			$thumbwidth = (int)$thumbwidth ? $thumbwidth : 90;
			$thumbheight = (int)$thumbheight ? $thumbheight : 90;
			$thumb_code = show_post_thumbnail($thumbwidth, $thumbheight, $post->ID);

			$retHtml .= '<li id="'.$unique_id.'" class="clearfix"><div class="widget-post-thumb">'.$thumb_code.$ranking_code.'</div><div class="excerpt_div"><div class="excerpt_title_div">'.$date_code.'<h4 class="excerpt_title_wid"><a href="'.get_permalink().'" title="'. get_the_title() .'">' . $post_title .'</a></h4> ' . $sns_share_code . $viewsCode .'</div>'.$desc.'</div>'.$js_code.'</li>';
		} else {
			$retHtml .= '<li id="'.$unique_id.'" class="clearfix"><div class="excerpt_div"><div class="excerpt_title_div">'.$date_code.'<h4 class="excerpt_title_wid"><a href="'.get_permalink().'" title="'. get_the_title() .'">' . $post_title .'</a></h4> ' . $sns_share_code . $viewsCode .'</div>'.$desc.'</div>'.$ranking_code.$js_code.'</li>';
		}

	endforeach;
	
	if ((bool)$thumb) {
		$retHtml = '<ul class="recent_entries thumb">'.$retHtml.'</ul>';
	} else {
		$retHtml = '<ul class="recent_entries">'.$retHtml.'</ul>';
	}

	// Reset Query
	wp_reset_query();
	
	return $retHtml;
}
add_shortcode("mostviewedposts", "dp_sc_get_most_viewed_posts");


/****************************************************************
* Google AdSense.
****************************************************************/
function dp_sc_google_ads($atts) {
	global $options;

	if (!$options['adsense_id']) return;

	extract(shortcode_atts(array(
		'id'		=> $options['adsense_id'],
		'unitid' 	=> '',
		'size'		=> 'rect'
	), $atts));
	
	$arrSize =array(300, 250);
	
	switch ($size) {
		case 'rect':
			$arrSize = array(300, 250);
			break;
		case 'rect_big':
			$arrSize = array(336, 280);
			break;
		case 'half_banner':
			$arrSize = array(234, 60);
			break;
		case 'banner':
			$arrSize = array(468, 60);
			break;
		case 'big_banner':
			$arrSize = array(728, 90);
			break;
		case 'square':
			$arrSize = array(250, 250);
			break;
		case 'square_s':
		case 'square_small':
			$arrSize = array(200, 200);
			break;
	}

$adsCode = <<<_EOD_
<div class="dp_sc_ads"><script type="text/javascript"><!--
google_ad_client = "ca-pub-$id";
google_ad_slot = "$unitid";
google_ad_width = $arrSize[0];
google_ad_height = $arrSize[1];
//-->
</script>
<script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
_EOD_;

	return $adsCode;
}

add_shortcode('adsense', 'dp_sc_google_ads');


/****************************************************************
* Show Google Maps.
****************************************************************/
function dp_sc_show_google_maps($atts) {
	extract(shortcode_atts(array(
		'url'		=> '',
		'width' 	=> '100%',
		'height'	=> '350'
	), $atts));
	
	if ($url == '') return;
	
	 $mapCode = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$url.'&amp;output=embed"></iframe>';

	return $mapCode;
}
add_shortcode("googlemap", "dp_sc_show_google_maps");


/****************************************************************
* Show YouTube.
****************************************************************/
function dp_sc_show_youtube($atts) {
	extract(shortcode_atts(array(
		'id'		=> '',
		'width' 	=> '100%',
		'height'	=> '350',
		'rel'		=> 1
	), $atts));
	
	if ($id == '') return;
	
	$rel = ((bool)$rel) ? '' : '?rel=0';
	 $youtube_code = '<div class="emb_video"><iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$id.$rel.'" frameborder="0" allowfullscreen></iframe></div>';

	return $youtube_code;
}
add_shortcode("youtube", "dp_sc_show_youtube");


/****************************************************************
* Create Linkshare affiliate url.
****************************************************************/
function dp_sc_linkshare_af_link($atts, $content = null) {
	global $options;
	extract(shortcode_atts(array(
		'url'		=> '',
		'token' 	=> $options['ls_token'],
		'mid'		=> $options['ls_mid'],
		'rel'		=> '',
		'title'		=> '',
		'price'	=> '',
		'cat'		=> '',
		'dev'		=> '',
		'size'		=> '',
		'class'		=> 'lsaflink'
	), $atts));
	
	if (($url == '') || ($token == '')) return;
	if (!$content) return;
	
	// Default is Linkshare afilliate program
	$mid = $mid ? $mid : '2451';

	$app_url 	= '';
	$buff_url 	= '';

	$rel = ($rel == '') ? '' : ' rel="'.$rel.'" ';
	$price = ($price == '') ? '' : ' (' .$price. ')';

	if ($mid == '13894') {
		$buff_url 	= $url . '&at='.$options['phg_token'];

		if ($title) {
			 $title = '<a href="'.$buff_url.'" target="_blank" '.$rel .' class="ft14px b">'.$title.'</a>'.$price . '<br /><a href="'.$buff_url.'" target="_blank" '.$rel .' style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.png) no-repeat;width:135px;height:40px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.svg);}"></a><br />';
		} else {
			$title = '<a href="'.$buff_url.'" target="_blank" '.$rel .' style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.png) no-repeat;width:135px;height:40px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.svg);}"></a>';
		}
		
	} else {
		$app_url	= 'http://getdeeplink.linksynergy.com/createcustomlink.shtml?token='.$token.'&mid='.$mid.'&murl='.$url;
		$buff_url 	= file_get_contents($app_url);

		$title = ($title == '') ? '' : '<a href="'.$buff_url.'" target="_blank" '.$rel .' class="ft14px b">'.$title.'</a>'.$price . '<br />';
	}

	if (!$buff_url) return;
	
	$cat  	= ($cat == '') ? '' : '<span class="ft12px">カテゴリ : '.$cat.'</span><br />';
	$dev 	= ($dev == '') ? '' : '<span class="ft12px">販売元 : '.$dev . '</span>';
	$size 	= ($size == '') ? '' : ' (サイズ : '.$size.')';
	
	if ($title == '') $class .= ' fl-l mg15px-r';
	
	$af_code	= '<div class="clearfix"><a href="'.$buff_url.'" class="'.$class.'" target="_blank" '.$rel .'>'.$content.'</a>'.$title.$cat.$dev.$size.'</div>';

	return $af_code;
}
add_shortcode("linkshare", "dp_sc_linkshare_af_link");


/****************************************************************
* Create PHG affiliate url.
****************************************************************/
function dp_sc_phg_af_link($atts, $content = null) {
	global $options;
	extract(shortcode_atts(array(
		'url'		=> '',
		'token' 	=> '',
		'rel'		=> '',
		'title'		=> '',
		'price'		=> '',
		'cat'		=> '',
		'dev'		=> '',
		'button'	=> 'big',
		'class'		=> 'phgaflink'
	), $atts));
	
	if ( !$url ) return;

	$token 	= $token ? $token : $options['phg_token'];
	$rel 	= ($rel == '') ? '' : ' rel="'.$rel.'" ';
	$price 	= ($price == '') ? '' : ' (' .$price. ')';
	$url 	.= '&at='.$token;

	if ($button === 'big') {
		$button = ' style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.png) no-repeat;width:135px;height:40px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets/ja_jp//images/web/linkmaker/badge_appstore-lrg.svg);}"';
	} else {
		$button = ' style="display:inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/htmlResources/assets//images/web/linkmaker/badge_appstore-sm.png) no-repeat;width:61px;height:15px;@media only screen{background-image:url(https://linkmaker.itunes.apple.com/htmlResources/assets//images/web/linkmaker/badge_appstore-sm.svg);}"';
	}

	if ($title) {
			 $title = '<a href="'.$url.'" target="_blank" '.$rel .' class="ft14px b">'.$title.'</a>'.$price . '<br /><a href="'.$url.'" target="_blank" ' . $rel . $button.'></a><br />';
		} else {
			$title = '<a href="'.$url.'" target="_blank" ' . $rel . $button.'></a><br />';
		}

	if (!$url) return;
	
	$cat  	= ($cat == '') ? '' : '<span class="ft12px">カテゴリ : '.$cat.'</span><br />';
	$dev 	= ($dev == '') ? '' : '<span class="ft12px">販売元 : '.$dev . '</span>';
	$size 	= ($size == '') ? '' : ' (サイズ : '.$size.')';
	
	if ($title == '') $class .= ' fl-l mg15px-r';
	
	$af_code	= '<div class="clearfix"><a href="'.$url.'" class="'.$class.'" target="_blank" '.$rel .'>'.$content.'</a>'.$title.$cat.$dev.$size.'</div>';

	return $af_code;
}
add_shortcode("phg", "dp_sc_phg_af_link");
?>