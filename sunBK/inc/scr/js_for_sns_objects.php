<?php
function js_for_sns_objects() {
	global $options, $FB_APP_ID, $EXIST_FB_LIKE_BOX;

	$postType = '';
	$fb_app_id = '';
	if (is_single() || is_page()) {
		$hideSNSIconFlag = get_post_meta(get_the_ID(), 'hide_sns_icon', true);
		$postType = get_post_type();
	}

	//For SNS Buttons
	if ( (is_single() || is_page()) && ($options['sns_button_under_title'] || $options['sns_button_on_meta']) ) {
		if (!$hideSNSIconFlag) {
			if ($options['show_google_button']) {
				echo '<script src="https://apis.google.com/js/plusone.js">{lang: "ja"}</script>';
			}
			if ($options['show_hatena_button']) {
				echo '<script src="//b.hatena.ne.jp/js/bookmark_button.js" charset="utf-8" async="async"></script>';
			}
			if ($options['show_mixi_button'] && $options['mixi_accept_key']) {
				echo '<script type="text/javascript">(function(d) {var s = d.createElement(\'script\'); s.type = \'text/javascript\'; s.async = true;s.src = \'//static.mixi.jp/js/plugins.js#lang=ja\';d.getElementsByTagName(\'head\')[0].appendChild(s);})(document);</script>';
			}
			if ($options['show_evernote_button']) {
				echo '<script src="//static.evernote.com/noteit.js"></script>';
			}
			if ($options['show_tumblr_button']) {
				echo '<script src="//platform.tumblr.com/v1/share.js"></script>';
			}
			if ($options['show_pocket_button']) {
				echo '<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>';
			}
			if ($options['show_facebook_button'] || $options['facebookcomment_page'] || $options['facebookrecommend']) {
				// Change flag
				$EXIST_FB_LIKE_BOX = true;
			}
			if ($options['show_twitter_button']) {
				echo '<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			}
		}
	}

	// JS for facebook
	if ($EXIST_FB_LIKE_BOX) {
		$fb_app_id =  $options['fb_app_id'] ? '&appId='.$options['fb_app_id'] : '';
		if (!$fb_app_id) {
			$fb_app_id = $FB_APP_ID ? '&appId='.$FB_APP_ID : '';
		}

		echo '<div id="fb-root"></div><script type="text/javascript">(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id;js.async = true; js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1' . $fb_app_id . '"; fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));</script>';
	}

	// Under this below is Facebook recommended box
	if ($postType === 'post' && $options['facebookrecommend'] && $fb_app_id !== '') : 
?>
<div class="fb-recommendations-bar mq-hide" data-href="<?php the_permalink(); ?>" data-trigger="<?php echo $options['fb_recommend_scroll']; ?>" data-read-time="<?php echo $options['fb_recommend_time']; ?>" data-action="<?php echo $options['fb_recommend_action']; ?>" data-side="<?php echo $options['fb_recommend_position']; ?>" num_recommendations="<?php echo $options['number_fb_recommend']; ?>"></div>
<?php 
	endif;
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php 
}	// end of function
?>