<?php
function show_post_thumbnail($width = 680, 
							 $height = 480, 
							 $post_id = null,
							 $if_img_tag = true) {

	$post_id = empty($post_id) ? get_the_ID() : $post_id;
	$img_tag = "";
	
	if (has_post_thumbnail($post_id)) {
		$image_id 	= get_post_thumbnail_id($post_id);
		$image_url 	= wp_get_attachment_image_src($image_id, array($width, $height), true); 
		$image_url 	= is_ssl() ? str_replace('http:', 'https:', $image_url[0]) : $image_url[0];

		if ($if_img_tag) {
			// $img_tag = get_the_post_thumbnail($post_id, array($width, $height));
			$img_tag = '<img src="'.$image_url.'" width="'.$width.'" class="wp-post-image" alt="'.get_the_title().'" />';
		} else {
			$img_tag 	= $image_url;
		}
		
	} else {
		preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"]/i', get_post($post_id)->post_content, $imgurl);
		if (isset($imgurl[1][0])) {
			$image_url = is_ssl() ? str_replace('http:', 'https:', $imgurl[1][0]) : $imgurl[1][0];
			if ($if_img_tag) {
				$img_tag = '<img src="'.$image_url.'" width="'.$width.'" class="wp-post-image" alt="'.get_the_title().'" />';
			} else {
				$img_tag = $image_url;
			}
			
		} else {
			$strPattern	=	'/(\.gif|\.jpg|\.jpeg|\.png)$/';
			if ($handle = opendir(DP_THEME_DIR . '/img/post_thumbnail')) {
				$image = '';
				$cnt = 0;
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						//Image file only
						if (preg_match($strPattern, $file)) {
							$image[$cnt] = DP_THEME_URI . '/img/post_thumbnail/'.$file;
							//count
							$cnt ++;
						}
					}
				}
				closedir($handle);
			}
			if ($cnt > 0) {
				$randInt = rand(0, $cnt - 1);
				$image_url = is_ssl() ? str_replace('http:', 'https:', $image[$randInt]) : $image[$randInt];
				if ($if_img_tag) {
					$img_tag = '<img src="'.$image_url.'" width="'.$width.'" class="wp-post-image" alt="'.get_the_title().'" />';
				} else {
					$img_tag = $image_url;
				}
			}
		}
	}
	
	return $img_tag;
}
?>