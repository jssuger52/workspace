<?php
global $options, $options_visual;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<?php if ( is_singular() ) : ?>
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
<?php else: ?>
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# blog:http://ogp.me/ns/website#">
<?php endif; ?>
<meta charset="UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" /><meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<?php
if ( (is_home() || is_archive()) && is_paged()) :
?>
<meta name="robots" content="noindex,follow" />
<?php
elseif ( is_singular() ) :
	if (get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="noindex,nofollow,noarchive" />
<?php
	elseif (get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		!get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="noindex,nofollow" />
<?php
	elseif (get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		!get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		!get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="noindex" />
<?php
	elseif (!get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="nofollow,noarchive" />
<?php
	elseif (!get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		!get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="noarchive" />
<?php
	elseif (!get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		!get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="nofollow" />
<?php
	elseif (get_post_meta(get_the_ID(), 'dp_noindex', true) &&
		!get_post_meta(get_the_ID(), 'dp_nofollow', true) &&
		get_post_meta(get_the_ID(), 'dp_noarchive', true)) :
?>
<meta name="robots" content="noindex,noarchive" />
<?php
	endif;
endif;

// show title
dp_site_title("<title>", "</title>") ;
// show keyword and description
dp_meta_kw_desc();
// show OGP
dp_show_ogp();
?>
<link rel="stylesheet" href="<?php echo DP_THEME_URI.'/'.DP_MOBILE_THEME_DIR.'/css/style.css?' . date('His'); ?>" media="screen, print" />
<link rel="stylesheet" href="http://santorasuto.sakura.ne.jp/wp-content/themes/dp-graphie/mobile/css/common.css" media="all" />
<?php
// Custom CSS
if ( file_exists( DP_UPLOAD_DIR . '/css/visual-custom.css') ) : ?>
<link rel="stylesheet" href="<?php echo DP_UPLOAD_URI . '/css/visual-custom.css?' . date('His'); ?>" media="screen, print" />
<?php else : ?>
<link rel="stylesheet" href="<?php echo DP_THEME_URI . '/css/visual-custom.css?' . date('His'); ?>" media="screen, print" />
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
// WordPress header
wp_head();

// ***********************
// Slide menu JS
// ***********************
$position 	= 'position:"'.$options['mb_slide_menu_position'].'",';
$zposition 	= 'zposition:"'.$options['mb_slide_menu_zposition'].'"';
$mmenu_js = <<<_EOD_
<script>
var j$ = jQuery;
j$(function(){
	j$("#global_menu_nav").mmenu({
		offCanvas:{
			$position
			$zposition
		}
	});
});</script>
_EOD_;
$mmenu_js = str_replace(array("\r\n","\r","\n","\t"), '', $mmenu_js);
echo $mmenu_js;



// ***********************
// Slideshow JS
// ***********************
if ($options_visual['use_mobile_header']) {
	if ($options_visual['dp_header_content_type_mobile'] == 2 && is_home() && !is_paged()) {
		echo make_slider_js_mobile();
	}
} else {
	if ($options_visual['dp_header_content_type'] == 2 && is_home() && !is_paged()) {
		echo make_slider_js();
	}
}

// ***********************
// Autopager JS
// ***********************
showScriptForAutopagerMobile($wp_query->max_num_pages);

// ***********************
// Headline JS
// ***********************
if ($options['headline_type'] == 3 && (is_home() && !is_paged()) ) {
	if ($options['headline_slider_fx'] == 1) {
		$headlineTime = $options['headline_slider_time'];
		$headlineHoverStop = $options['headline_hover_stop'] ? 'true' : 'false';

		$headline_js = <<<_EOD_
<script>j$(function(){j$('.headline-slider').glide({autoplay:$headlineTime,hoverpause:$headlineHoverStop,arrows:false,nav:false,afterInit:(function(){j$('ul.slides').fadeIn();})});});</script>
_EOD_;

	} else {
		$tickerVelocity = $options['headline_ticker_velocity'] ? $options['headline_ticker_velocity'] : '0.07';
		$tickerHoverStop = $options['headline_ticker_hover_stop'] ? 1 : 0;
		$headline_js = <<<_EOD_
<script>j$(function(){j$(function(){j$("#headline-ticker").liScroll({travelocity:$tickerVelocity,hoverstop:$tickerHoverStop});});j$('#headline-ticker').fadeIn();});</script>
_EOD_;
	}
	echo $headline_js;
}

// ***********************
// Google Custom Search
// ***********************
if ($options['gcs_id'] !== '') :  ?>
<script>(function(){var cx='<?php echo $options['gcs_id']; ?>';var gcse=document.createElement('script'); gcse.type = 'text/javascript';gcse.async=true;gcse.src=(document.location.protocol=='https:'?'https:':'http:')+'//www.google.com/cse/cse.js?cx='+cx;var s =document.getElementsByTagName('script')[0];s.parentNode.insertBefore(gcse,s);})();</script>
<?php
endif;

// ***********************
// Custom header
// ***********************
echo $options['custom_head_content'];

?>
</head>
