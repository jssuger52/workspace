<?php
/*******************************************************
* Create Style Sheet
*******************************************************/
/** ===================================================
* Create main CSS file.
*
* @param	string	$color
* @param	string	$sidebar
* @return	none
*/
function dp_css_create() {
	$options 		= get_option('dp_options');
	$options_visual = get_option('dp_options_visual');
	
	//Custom CSS file
	$file_path	=  DP_UPLOAD_DIR . "/css/visual-custom.css";
	//Get theme settings
	$originalCSS	= $options_visual['original_css'];

	// Create CSS
	$str_css = dp_custom_design_css(
					$options,
					$options_visual
				);

	// Strip blank, tags
	$str_css = str_replace(array("\r\n","\r","\n","\t"), '', $str_css);

	// Rewrite CSS for custom design
	dp_export_file($file_path, $str_css);
	// gzip compress
	dp_export_gzip($file_path, $str_css);
	
	return true;
}


/**  ===================================================
* Create css for custom design hack.
*
* @param	string	$headerImage	Custom header image.
* @param	string	$imgRepeat	Method image repeat.
* @param	string	$blindTitle	Whether site title is blind.
* @param	string	$blindDesc	Whether site description is blind.
* @return	none
*/
function dp_custom_design_css($options, $options_visual) {
	extract($options);
	extract($options_visual);

	$original_font_size_px				= 14;
	$original_font_size_em				= 1.1;

	// For CSS
	$layout_css 					= '';
	$base_font_size_css				= '';
	$site_bg_img_css				= '';
	$header_area_css 				= '';
	$header_slide_toggle_css 		= '';
	$header_slideshow_css 			= '';
	$headline_area_css 				= '';
	$global_menu_css 				= '';
	$container_css 					= '';
	$entry_css 						= '';
	$list_hover_css 				= '';
	$share_num_css 					= '';
	$meta_area_css 					= '';
	$base_link_color_css 			= '';
	$base_link_hover_color_css 		= '';
	$navigation_link_color_css 		= '';
	$link_filled_color_css 			= '';
	$link_filled_hover_color_css 	= '';
	$header_filter_css 				= '';
	$entry_link_css 				= '';
	$border_color_css 				= '';
	$bordered_obj_css 				= '';
	$common_bg_color_css 			= '';
	$quote_css 						= '';
	$comment_box_css 				= '';
	$container_footer_css 			= '';
	$footer_text_color_css 			= '';
	$footer_title_border_css 		= '';
	$tooltip_css 					= '';
	$search_form_css 				= '';
	$form_css 						= '';
	$ranking_css 					= '';
	$btn_label_css 					= '';


	// *************************************************
	// layout CSS
	// *************************************************
	// Footer Column number
	switch ($footer_col_number) {
		case 1:
			$footer_widget_css = <<<_EOD_
#ft-widget-content .ft-widget-area{
	width:100%;
}
_EOD_;
			break;
		case 2:
			$footer_widget_css = <<<_EOD_
#ft-widget-content .ft-widget-area{
	width:48.4%;
}
#ft-widget-area1{
	margin:0 3.2% 0 0;
}
_EOD_;
			break;
		case 3:
			$footer_widget_css = <<<_EOD_
#ft-widget-content .ft-widget-area{
	width:31.2%;
}
#ft-widget-area2{
	margin:0 3.2%;
}
_EOD_;
			break;
		case 4:
			$footer_widget_css = <<<_EOD_
#ft-widget-content .ft-widget-area{
	width:22.6%;
}
#ft-widget-area1,
#ft-widget-area2,
#ft-widget-area3{
	margin:0 3.2% 0 0;
}
#ft-widget-area4{
	margin:0;
}
_EOD_;
			break;
		default:
			$footer_widget_css = "";
			break;
	}

	// Top page scroll entry box CSS
	if ($show_thumbnail) {
		$scrollentry_height_css = 
"#scrollentrybox{
	height:303px;
}";
	} else {
		if ($show_cat_entrylist && !($show_specific_cat_index_top == 'custom')) {
			$scrollentry_height_css = 
"#scrollentrybox{
	height:219px;
	max-height:219px;
}";
		} else {
			$scrollentry_height_css = 
"#scrollentrybox{
	height:202px;
	max-height:202px;
}";
		}	
	}

	// Layout CSS
	$layout_css = $scrollentry_height_css.$footer_widget_css;




	// *************************************************
	// Body CSS
	// *************************************************
	//Background image
	if ( $dp_background_img == "none" || !$dp_background_img ) {
		$site_bg_img_css ='';
	} else {
		$dp_background_img = is_ssl() ? str_replace('http:', 'https:', $dp_background_img) : $dp_background_img;
		$site_bg_img_css =" url(".$dp_background_img.") " . $dp_background_repeat . " left top";
	}

	// Body CSS
	$body_css = 
".main-wrap,
.mm-page{
	color:".$base_font_color.";
	background:".$site_bg_color.$site_bg_img_css."
}
a,
a:visited{
	color:".$base_font_color.";
}
a:hover{
	color:".$base_link_color.";
}";
	

	// *************************************************
	// Container CSS
	// *************************************************
	$rgb = hexToRgb($base_font_color);
	$container_css = 
".container{
	color:".$base_font_color.";
	background-color:".$container_bg_color.";
}
.container select{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.14);
}";



	// *************************************************
	// entry CSS
	// *************************************************
	// Font size
	if (!$base_font_size || ($base_font_size == '')) {
		if ( !$base_font_size_unit || $base_font_size_unit == '' ) {
			$base_font_size_css = 
".entry{
	font-size:".$original_font_size_px."px;
}";
		} else {
			$base_font_size_css = 
".entry{
	font-size:".$original_font_size_em."em".$options_visual['base_font_size_unit'].";
}";
		}
	} else {
		if ( !$base_font_size_unit || $base_font_size_unit == '' ) {
			$base_font_size_css = 
".entry{
	font-size:".$base_font_size."px;
}";
		} else {
			$base_font_size_css = 
".entry{
	font-size:".$base_font_size.$base_font_size_unit.";
}";
		}
	}

	//Link Style
	if ($base_link_underline == 1 || $base_link_underline == null) {
		if ($base_link_bold) {
			$entry_link_css	= ".entry a{font-weight:bold;text-decoration:none;}".
						  ".entry a:hover{text-decoration:underline;}";
		} else {
			$entry_link_css	= ".entry a{font-weight:normal;text-decoration:none;}".
						  ".entry a:hover{text-decoration:underline;}";
		}
	} else {
		if ($base_link_bold) {
			$entry_link_css	= ".entry a{font-weight:bold;text-decoration:underline;}".
						  ".entry a:hover{text-decoration:none;}";
		} else {
			$entry_link_css	= ".entry a{font-weight:normal;text-decoration:underline;}".
						  ".entry a:hover{text-decoration:none;}";
		}
	}



	// *************************************************
	// anchor text link CSS
	// *************************************************
	$base_link_color_css = 
".entry a,
.entry a:visited{
	color:" . $base_link_color . ";
}";

	$link_filled_color_css 			= 
".dp-pagenavi span.current,
.entrylist-cat a,
.entrylist-cat a:visited,
.content pre,
.entry input[type=\"submit\"],
.plane-label,
#wp-calendar tbody td a,
#wp-calendar tbody td a:visited,
input#submit{
	color:". $container_bg_color.";
	background-color:" . $base_link_color . ";
}
.meta-tag a:before{
	border-right-color:".$base_link_color.";
}";


	//Base hovering anchor text color
	$base_link_hover_color_css	= 
".container a:hover,
.entry a:hover,
.fake-hover:hover{
	color:".$base_link_hover_color.";
}";

	$link_filled_hover_color_css 	=
".entrylist-cat a:hover,
nav.single-nav a:hover,
.entry input[type=\"submit\"]:hover,
#wp-calendar tbody td a:hover,
input#submit:hover{
	color:". $container_bg_color .";
	background-color:" . $base_link_hover_color . ";
}
.meta-tag a:hover:before{
	border-right-color:".$base_link_hover_color.";
}";


	// ***********************************
	// navigation color CSS
	// ***********************************
	$navigation_link_color_css = 
".dp-pagenavi a,
.dp-pagenavi a:hover,
.dp-pagenavi a:visited{
	color:".$base_font_color.";
}
nav.navigation .navialignleft a:hover,
nav.navigation .navialignright a:hover{
	color:".$base_link_color.";
}";


	// ***********************************
	// Post meta info CSS
	// ***********************************
	$rgb = hexToRgb($base_font_color);
	$meta_area_css = 
"#loop-section.magazine .loop-title a:hover,
#loop-section.portfolio .loop-article header .loop-title a:hover{
	color:".$base_link_color.";
}
.loop-excerpt,
.loop-article.normal-all footer div,
.meta-div.normal, 
.meta-div.magazine,
.meta-div.app-image,
.meta-div.blog{
	color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.74);
}
.post-header-date{
	background-color:".$base_link_color.";
	color:".$container_bg_color.";
}";

	
	// ***********************************
	// Header image filter CSS
	// ***********************************
	if ($filter_enable) {
		// For FireFox(SVG)
		if ($filter_grayscale) {
			$val = 1 - (int)$filter_grayscale/100;
			$grayscale_ie 		= 'gray';
			$grayscale_svg 	= "<feColorMatrix type='saturate' values='".$val."' result='A' />";
		}
		if ($filter_blur) {
			$blur_svg_params = " x='-5%' y='-5%' width='110%' height='110%'";
			$blur_svg 		= "<feGaussianBlur stdDeviation='".$filter_blur."' />";
			$blur_ie			= ' progid:DXImageTransform.Microsoft.Blur(PixelRadius='.$filter_blur.')';
		}
		if ($filter_sepia) {
			$sepia_svg 		= "<feColorMatrix type='matrix' values='.8 .8 .8 0 0 .6 .6 .6 0 0 .3 .3 .3 0 0 0 0 0 1 0'/>";
		}
		if ($filter_brightness != 100) {
			$val = (int)$filter_brightness/100;
			$brightness_svg 	= "<feColorMatrix type='matrix' values='".$val." 0 0 0 0 0 ".$val." 0 0 0 0 0 ".$val." 0 0 0 0 0 1 0'/>";
		}

		// IE filter
		if ($grayscale_ie || $blur_ie) {
			$filter_ie = 'filter:'.$grayscale_ie.$blur_ie.';';
		}

		// Filter CSS
		$header_filter_css = 
'.img-filter-div img {
	filter:blur('.$filter_blur.'px) grayscale('.$filter_grayscale.'%) sepia('.$filter_sepia.'%) brightness('.$filter_brightness.'%);
	-webkit-filter:blur('.$filter_blur.'px) grayscale('.$filter_grayscale.'%) sepia('.$filter_sepia.'%) brightness('.$filter_brightness.'%);
	-moz-filter:blur('.$filter_blur.'px) grayscale('.$filter_grayscale.'%) sepia('.$filter_sepia.'%) brightness('.$filter_brightness.'%);
	filter:url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'dp_hd_img_filter\''.$blur_svg_params.'>'.$grayscale_svg.$blur_svg.$sepia_svg.$brightness_svg.'</filter></svg>#dp_hd_img_filter");'.$filter_ie.'
}';
	}


	// *************************************************
	// Border CSS
	// *************************************************
	$rgb = hexToRgb($base_font_color);
	$border_color_css = 
"hr{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.4);
}
address,
.entry h1,
.entry h2,
.entry h3,
.entry h4,
.entry h5,
.entry h6,
#switch_comment_type, 
.dp_tab_widget_ul{
	border-color:".$base_link_color.";
}
.new-entry ul li,
.widget_pages li a,
.widget_nav_menu li a,
.widget_categories li a,
.widget_mycategoryorder li a,
.recent_entries li{
	border-bottom:1px dotted rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.3);
}
.content table th,
.content table td,
.content dl,
.content dt,
.content dd,
.entrylist-date,
div#comment-author,
div#comment-email,
div#comment-url,
div#comment-comment,
#comment_section li.comment,
#comment_section li.trackback,
#comment_section li.pingback{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.18);
}";

	

	// *************************************************
	// Comon background color CSS
	// *************************************************
	$common_bg_color_css = 
".dp-pagenavi a:hover{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.02);
}
.content dt,
.content table th,
.entry .wp-caption,
#wp-calendar caption,
#wp-calendar th, 
#wp-calendar td{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.04);
}
.dp-pagenavi a,
.widget_categories li .count,
.mb-theme .post_meta_sns_btn,
.mb .post_meta_sns_btn{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.06);
}
#wp-calendar tbody td#today{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.1);
}
.meta-tag a:after{
	background-color:".$container_bg_color.";
}";

	
	// *************************************************
	// Bordered object css
	// *************************************************
	$bordered_obj_css = 
".active_tab,
#hd-slideshow .button-slider,
.entry ul li:before, 
#comment_section .comment-meta .comment-reply-link, 
.container .more-entry-link, 
.tagcloud a,
.entry>p>a.more-link, 
#commentform input[type=\"submit\"], 
.nav_to_paged a, 
a#gototop {
	color:".$container_bg_color.";
	background-color:".$base_link_color.";
	-webkit-box-shadow:0 0 0 1px ".$base_link_color.";
	-moz-box-shadow:0 0 0 1px ".$base_link_color.";
	-o-box-shadow:0 0 0 1px ".$base_link_color.";
	box-shadow:0 0 0 1px ".$base_link_color.";
} 
#comment_section .comment-meta .comment-reply-link:hover, 
.container .more-entry-link:hover, 
.tagcloud a:hover,
.entry>p>a.more-link:hover, 
#commentform input[type=\"submit\"]:hover, 
.nav_to_paged a:hover,
a#gototop:hover{
	color:".$container_bg_color.";
	background-color:".$base_link_hover_color.";
	-webkit-box-shadow:0 0 0 1px ".$base_link_hover_color.";
	-moz-box-shadow:0 0 0 1px ".$base_link_hover_color.";
	-o-box-shadow:0 0 0 1px ".$base_link_hover_color.";
	box-shadow:0 0 0 1px ".$base_link_hover_color.";
}
.inactive_tab{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	-moz-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	-o-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
}
.inactive_tab:hover{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-moz-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-o-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
}
.loop-sec-header h1 span,
.widget-box .dp-widget-title span,
.inside-title span, 
#reply-title span, 
#comment_section li.comment:hover, 
#comment_section li.trackback:hover, 
#comment_section li.pingback:hover,
.navialignleft a:hover,
.navialignright a:hover,
.loop-share-num div{
	border-color:".$base_link_color.";
}
#hd-slideshow .button-slider,
#loop-section.normal .meta-cat a, 
#loop-section.magazine .meta-cat a, 
.entry ul li:before, 
.dp_related_posts.horizontal .entrylist-cat a,
 #comment_section .comment-meta .comment-reply-link, 
.container .more-entry-link,
.active_tab,
.inactive_tab,
.tagcloud a,
.entry>p>a.more-link, 
#commentform input[type=\"submit\"], 
.nav_to_paged a, 
a#gototop{
	border-color:".$container_bg_color.";	
}
.single-article,
.single-article header,
.single-article .single_post_meta,
.loop-sec-header h1,
.widget-box .dp-widget-title, 
.dp_related_posts.vertical li,
.inside-title, #reply-title,
#comment_section .comment-avator img,
div.gsc-input-box,
#searchform{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
.gsc-input-box-hover,
.gsc-input-box-focus{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2)!important;
}
#loop-section.blog .loop-article,
#loop-section.normal .loop-article,
#loop-section.normal .loop-article.normal-all header{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.4);
}
.entry .wp-caption{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.1);
}
#loop-section.normal .loop-media-icon a,
#loop-section.app-image .loop-media-icon a{
	border-color:".$container_bg_color.";	
	color:".$container_bg_color.";
	background-color:".$base_link_color.";
}
#loop-section.normal .loop-media-icon a:hover{
	background-color:".$base_link_hover_color.";
}";



	// List item hover color
	$list_hover_css = 
".widget_nav_menu li a:hover,
.widget_pages li a:hover,
.widget_categories li a:hover,
.widget_mycategoryorder li a:hover,
ul.recent_entries li:hover,
.dp_recent_posts_widget li:hover,
.dp_related_posts ul li:hover,
span.v_sub_menu_btn{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.06);
}";
	

	// *************************************************
	// Header area CSS
	// *************************************************	
	$rgb1 = hexToRgb($header_menu_bgcolor);
	$rgb2 = hexToRgb($header_menu_link_color);
	$rgb_txt_shadow = hexToRgb($header_banner_text_shadow_color);
	if ( (bool)$header_banner_text_shadow_enable ) {
		$header_banner_text_shadow = 'text-shadow:0 0 1px rgba('.$rgb_txt_shadow[0].','.$rgb_txt_shadow[1].','.$rgb_txt_shadow[2].',.05), 0 1px 2px rgba('.$rgb_txt_shadow[0].','.$rgb_txt_shadow[1].','.$rgb_txt_shadow[2].',.3);';
	}

	$header_area_css = 
".header_container{
	background-color:rgba(". $rgb1[0] . ", " . $rgb1[1] . "," . $rgb1[2] . ", 0.84);
	border-top-color:".$header_toggle_bgcolor.";
	border-bottom-color:rgba(". $rgb2[0] . ", " . $rgb2[1] . "," . $rgb2[2] . ",0.3);
	color:".$header_menu_link_color.";
}
.header_container a{
	color:".$header_menu_link_color.";
}
.header_container:not(.mb):hover{
	background-color:".$header_menu_bgcolor.";
}
.header_container.mb-theme{
	background-color:".$header_menu_bgcolor.";
}
.header_container.mb-theme a:hover{
	color:".$header_menu_link_color.";
}
#header_content hgroup h2{
	color:rgba(". $rgb2[0] . ", " . $rgb2[1] . "," . $rgb2[2] . ",0.7);
}
.header-banner-outer,
.header-banner-outer a,
.header-banner-outer a:hover{
	color:".$header_banner_font_color.";".$header_banner_text_shadow."
}";
	
	// *************************************************
	// Headline CSS
	// *************************************************	
	$headline_area_css = 
"#headline-sec{
	background-color:".$header_menu_link_color.";
	color:".$header_menu_bgcolor.";
}
#headline-sec a,
#headline-sec a:hover,
#headline-sec a:visited{
	color:".$header_menu_bgcolor.";
}
#headline-sec .headline_main_title h1{
	background-color:".$header_menu_bgcolor.";
	color:".$header_menu_link_color.";
}";


	// *************************************************
	// Header slide toggle area CSS
	// *************************************************	
	$rgb = hexToRgb($header_toggle_font_color);
	$rgb_sns_num = hexToRgb($header_toggle_font_hover_color);
	$header_slide_toggle_css = 
"#header-toggle-btn{
	color:".$header_toggle_font_color.";
	border-color:transparent ".$header_toggle_bgcolor." transparent transparent;	
}
#header-toggle-content{
	background-color:".$header_toggle_bgcolor.";
	color:".$header_toggle_font_color.";
}
#header-toggle-content a{
	color:".$header_toggle_font_color.";
}
#header-toggle-content a:hover{
	color:".$header_toggle_font_hover_color.";
}
#header-toggle-content .dp-widget-hd-toggle .toggle-title{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#header-toggle-content #searchform{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#header-toggle-content #wp-calendar tbody td a{
	color:".$header_toggle_bgcolor.";
	background-color:".$header_toggle_font_color.";
}
#header-toggle-content #wp-calendar tbody td a:hover{
	background-color:".$header_toggle_font_hover_color.";
}
#header-toggle-content .tagcloud a,
#header-toggle-content .active_tab{
	color:".$header_toggle_bgcolor.";
	background-color:".$header_toggle_font_color.";
	border-color:".$header_toggle_bgcolor.";
	-webkit-box-shadow:0 0 0 1px".$header_toggle_font_color.";
	-moz-shadow:0 0 0 1px".$header_toggle_font_color.";
	-o-shadow:0 0 0 1px".$header_toggle_font_color.";
	box-shadow:0 0 0 1px".$header_toggle_font_color.";
}
#header-toggle-content .tagcloud a:hover{
	background-color:".$header_toggle_font_hover_color.";
	-webkit-box-shadow:0 0 0 1px".$header_toggle_font_hover_color.";
	-moz-shadow:0 0 0 1px".$header_toggle_font_hover_color.";
	-o-shadow:0 0 0 1px".$header_toggle_font_hover_color.";
	box-shadow:0 0 0 1px".$header_toggle_font_hover_color.";
}
#header-toggle-content .inactive_tab{
	color:".$header_toggle_font_color.";
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	border-color:".$header_toggle_bgcolor.";
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-moz-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-o-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
}
#header-toggle-content .dp_tab_widget_ul{
	border-color:".$header_toggle_font_color.";
}
#header-toggle-content .loop-share-num div{
	color:".$header_toggle_font_hover_color.";
	border-color:".$header_toggle_font_hover_color.";
	background-color:rgba(". $rgb_sns_num[0] . ", " . $rgb_sns_num[1] . "," . $rgb_sns_num[2] . ", 0.14);
}
#header-toggle-content #searchform input#searchtext{
	color:".$header_toggle_font_color.";
}
#header-toggle-content #searchform input.searchsubmit{
	color:".$header_toggle_font_color.";
}
#header-toggle-content #searchform input.searchsubmit:hover{
	color:".$header_toggle_font_hover_color.";
}";



	// *************************************************
	// Global menu CSS
	// *************************************************
	 $rgb = hexToRgb($header_menu_bgcolor);
	 $rgb_link_color = hexToRgb($header_menu_link_color);
	 $global_menu_css = 
"#global_menu .current-menu-item a,
#global_menu .current_page_item a,
#global_menu a:hover{
	color:".$header_menu_link_hover_color.";
}
ul#global_menu_ul.mq-mode,
ul#global_menu_ul .expand_global_menu_li{
	background-color:".$header_menu_bgcolor.";
}
ul#global_menu_ul:not(.mb-theme) > li .gnav-bd{
	background-color:".$header_menu_link_hover_color.";
}
ul#global_menu_ul:not(.mb-theme) li.current-menu-item:before,
ul#global_menu_ul:not(.mb-theme) li.menu-item-has-children:hover:before,
ul#global_menu_ul:not(.mb-theme) li.menu-item-has-children.current_page_item:before{
	color:".$header_menu_link_hover_color.";
}
ul#global_menu_ul:not(.mb-theme) li ul.sub-menu li{
	background-color:".$header_menu_bgcolor.";
}
ul#global_menu_ul:not(.mb-theme) li ul.sub-menu li:hover,
ul#global_menu_ul:not(.mb-theme) li ul.sub-menu li.current-menu-item{
	border-color:".$header_menu_link_hover_color.";
}
ul#global_menu_ul:not(.mb-theme) .mq_submenu_li{
	background-color:".$header_menu_link_color.";
}
ul#global_menu_ul:not(.mb-theme) .mq_submenu_li:before{
	color:".$header_menu_bgcolor.";
}
.mm-offcanvas{
	background-color:".$header_menu_link_color.";
}
.mm-offcanvas,
ul.mm-list li a{
	color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.8);	
}
ul.mm-list li.current-menu-item:after,
ul.mm-list li.current_page_item:after{
	border-color:".$header_menu_link_hover_color.";
}
.mm-menu .mm-list > li:after,
.mm-menu .mm-list > li > a.mm-subclose,
.mm-menu .mm-list > li > a.mm-subopen:before{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.14);	
}
.mm-menu .mm-list > li > a.mm-subclose:before,
.mm-menu .mm-list > li > a.mm-subopen:after{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.34);
}
.mm-menu .mm-list > li > a.mm-subclose{
	background-color:rgba(". $rgb_link_color[0] . ", " . $rgb_link_color[1] . "," . $rgb_link_color[2] . ", 0.8);	
	color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.3);
}
.mm-menu .mm-list > li.mm-selected > a:not(.mm-subopen),
.mm-menu .mm-list > li.mm-selected > span{
	background-color:rgba(". $rgb_link_color[0] . ", " . $rgb_link_color[1] . "," . $rgb_link_color[2] . ", 0.8);
}";
	
	// *************************************************
	// Header Slideshow CSS 
	// *************************************************
	$rgb = hexToRgb($base_link_color);
	$header_slideshow_css = 
"#hd-slideshow .button-slider{
	color:".$base_link_color."!important;
}
#hd-slideshow .button-slider:before{
	color:".$container_bg_color.";
}
.devrama-slider .hd-slide-item-div .hd-slide-post-title{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.7);	
}
.hd-slide-nav{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.5);
}";


	// *************************************************
	// SNS share number CSS
	// *************************************************
	$share_num_css = 
".loop-share-num div{
	color:".$base_link_color.";
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.14);
}";


	
	// *************************************************
	// Search form CSS
	// *************************************************
	$rgb = hexToRgb($header_menu_bgcolor);
	$search_form_css = 
"#searchform input#searchtext{
	color:".$base_font_color.";
}
#searchform input.searchsubmit{
	color:".$base_font_color.";
}
#searchform input.searchsubmit:hover{
	color:".$base_link_color.";
}
#searchform input:focus{
	background:".$container_bg_color.";
}
#hd_searchform:not(.mb-theme) #searchform .searchtext_div{
	background-color:".$header_menu_link_color.";
}
#hd_searchform.mb-theme #searchform input#searchtext,
#hd_searchform:not(.mb-theme) #searchform input#searchtext,
#hd_searchform:not(.mb-theme) #searchform:hover input#searchtext::-webkit-input-placeholder,
#hd_searchform:not(.mb-theme) #searchform input#searchtext:focus::-webkit-input-placeholder{
	color:".$header_menu_bgcolor.";
}
#hd_searchform:not(.mb-theme) #searchform input.searchsubmit,
#hd_searchform:not(.mb-theme) #searchform span.searchsubmit{
	color:".$header_menu_link_color.";
}
#hd_searchform:not(.mb-theme) #searchform input.searchsubmit:hover,
#hd_searchform:not(.mb-theme) #searchform span.searchsubmit:hover{
	color:".$header_menu_link_hover_color.";
}
#hd_searchform:not(.mb-theme) table.gsc-search-box div.gsc-input-box{
	background-color:".$header_menu_link_color.";
}
#hd_searchform:not(.mb-theme) table.gsc-search-box td.gsc-search-button:hover{
	color:".$header_menu_link_hover_color.";
}
#hd_searchform:not(.mb-theme) table.gsc-search-box td.gsc-search-button:hover input.gsc-search-button{
	border-color:".$header_menu_link_hover_color."!important;
}
#hd_searchform:not(.mb-theme) table.gsc-search-box td.gsc-search-button input.gsc-search-button{
	border-color:".$header_menu_link_color."!important;
}
#hd_searchform.mb-theme #searchform{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#hd_searchform.mb-theme table.gsc-search-box td.gsc-input,
#hd_searchform.mb-theme table.gsc-search-box td.gsc-search-button{
	background-color:".$header_menu_bgcolor.";
}
#hd_searchform.mb-theme table.gsc-search-box td.gsc-search-button:before{
	color:".$header_menu_link_color.";
}";


	// *************************************************
	// Blockquote CSS
	// *************************************************
	$rgb = hexToRgb($base_font_color);
	//Quotes tag
	$quote_css = 
".content blockquote,
.content q,
.content code{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.04);
	border:1px solid rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
}
.content blockquote:before,
.content blockquote:after{
	color:".$base_link_color.";
}";

	
	// *************************************************
	// Comment area CSS
	// *************************************************
	$comment_box_css = 
"#comment_section li.comment:hover,
#comment_section li..trackback:hover,
#comment_section li..pingback:hover{
	border-color:".$base_link_color.";
}";
	


	// *************************************************
	// Container bottom area CSS
	// *************************************************
	// Container bottom CSS
	$rgb = hexToRgb($container_bottom_font_color);
	$container_footer_css = 
"#container_footer{
	border-color:".$container_bg_color.";
	background-color:".$container_bottom_bgcolor.";
	color:".$container_bottom_font_color.";
	-webkit-box-shadow:0 0 0 2px ".$container_bottom_bgcolor.";
	-moz-box-shadow:0 0 0 2px ".$container_bottom_bgcolor.";
	-o-box-shadow:0 0 0 2px ".$container_bottom_bgcolor.";
	box-shadow:0 0 0 2px ".$container_bottom_bgcolor.";
}
#container_footer a{
	color:".$container_bottom_font_color.";
}
#container_footer #searchform{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#container_footer #wp-calendar tbody td a,
#container_footer #wp-calendar tbody td a:hover{
	color:".$header_toggle_bgcolor.";
	background-color:".$container_bottom_font_color.";
}
#container_footer .tagcloud a,
#container_footer .tagcloud a:hover,
#container_footer .active_tab{
	color:".$container_bottom_bgcolor.";
	background-color:".$container_bottom_font_color.";
	border-color:".$container_bottom_bgcolor.";
	-webkit-box-shadow:0 0 0 1px".$container_bottom_font_color.";
	-moz-shadow:0 0 0 1px".$container_bottom_font_color.";
	-o-shadow:0 0 0 1px".$container_bottom_font_color.";
	box-shadow:0 0 0 1px".$container_bottom_font_color.";
}
#container_footer .inactive_tab{
	color:".$container_bottom_font_color.";
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	border-color:".$container_bottom_bgcolor.";
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-moz-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	-o-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
}
#container_footer .dp_tab_widget_ul{
	border-color:".$container_bottom_font_color.";
}
#container_footer .loop-share-num div{
	color:".$container_bottom_font_color.";
	border-color:".$container_bottom_font_color.";
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.14);
}
#container_footer #searchform input#searchtext{
	color:".$container_bottom_font_color.";
}
#container_footer #searchform input.searchsubmit{
	color:".$container_bottom_font_color.";
}
#container_footer #searchform input.searchsubmit:hover{
	color:".$container_bottom_font_color.";
}";


	// *************************************************
	// Form CSS
	// *************************************************
	$rgb = hexToRgb($base_font_color);
	$form_css = 
"input[type=\"checkbox\"]:checked,
input[type=\"radio\"]:checked{
		background-color:".$base_link_color.";
}
select{
	border:1px solid rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.14);
}";
	
	// *************************************************
	// Ranking CSS
	// *************************************************
	$rgb1 = hexToRgb($base_link_color);
	$rgb2 = hexToRgb($base_font_color);
	$rgb3 = hexToRgb($container_bottom_font_color);
	$rgb4 = hexToRgb($footer_link_color);
	$ranking_css = 
".rank_label.thumb{
	color:".$container_bg_color.";
}
.rank_label.thumb:before{
	border-color:rgba(".$rgb1[0].",".$rgb1[1].",".$rgb1[2].",0.84) transparent transparent transparent;
}
.rank_label.no-thumb{
	color:rgba(".$rgb2[0].",".$rgb2[1].",".$rgb2[2].",0.1);
}
#container_footer .rank_label.thumb{
	color:".$container_bottom_bgcolor.";
}
#container_footer .rank_label.thumb:before{
	border-color:rgba(".$rgb3[0].",".$rgb3[1].",".$rgb3[2].",0.84) transparent transparent transparent;
}
#container_footer .rank_label.no-thumb{
	color:rgba(".$rgb3[0].",".$rgb3[1].",".$rgb3[2].",0.1);
}
#ft-widget-content .rank_label.thumb{
	color:".$footer_bgcolor.";
}
#ft-widget-content .rank_label.thumb:before{
	border-color:rgba(".$rgb4[0].",".$rgb4[1].",".$rgb4[2].",0.84) transparent transparent transparent;
}
#ft-widget-content .rank_label.no-thumb{
	color:rgba(".$rgb4[0].",".$rgb4[1].",".$rgb4[2].",0.1);
}";


	// *************************************************
	// Tooltip CSS
	// *************************************************
	$tooltip_css = 
".tooltip-arrow{
	border-color:transparent transparent " . $base_link_color . " transparent;
}
.tooltip-msg{
	color:". $container_bg_color .";
	background-color:" . $base_link_color . ";
}
.tagcloud .tooltip-msg{
	color:". $base_link_color .";
	background-color:" . $container_bg_color . ";
}";


	// *************************************************
	// Default Button label color
	// *************************************************
	$btn_label_css = 
".btn,
.label{
	background-color:".$base_link_color."
}";

	// *************************************************
	// Footer area CSS
	// *************************************************
	$rgb = hexToRgb($footer_text_color);
	$rgb_sns_num = hexToRgb($footer_link_hover_color);
	$footer_title_border_css = 
"#footer,
#footer #footer-bottom a,
#footer #footer-bottom a:hover{
	background-color:".$footer_bgcolor.";
	color:".$footer_text_color.";
}
#footer a{
	color:".$footer_link_color.";
}
#footer a:hover{
	color:".$footer_link_hover_color.";
}
#footer select,
#footer_menu_ul,
#ft-widget-content,
#ft-widget-content .dp-widget-title,
#footer_menu_mobile,
#footer_menu_mobile li{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#ft-widget-content .dp-widget-title span{
	border-color:".$footer_link_hover_color.";
}
#ft-widget-content #searchform{
	border-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.2);
}
#ft-widget-content #wp-calendar caption,
#ft-widget-content #wp-calendar th, 
#ft-widget-content #wp-calendar td{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
}
#ft-widget-content #wp-calendar tbody td#today{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.12);
}
#ft-widget-content #wp-calendar tbody td a{
	color:".$footer_bgcolor.";
	background-color:".$footer_link_color.";
}
#ft-widget-content #wp-calendar tbody td a:hover{
	background-color:".$footer_link_hover_color.";
}
.ft-widget-box ul.recent_entries li,
.ft-widget-box .widget_pages li a, 
.ft-widget-box .widget_nav_menu li a, 
.ft-widget-box .widget_categories li a, 
.ft-widget-box .widget_mycategoryorder li a{
	border-bottom:1px dotted rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.4);
}
#ft-widget-content .tagcloud a,
#ft-widget-content .active_tab{
	color:".$footer_bgcolor.";
	border-color:".$footer_bgcolor.";
	background-color:".$footer_link_color.";
	-webkit-box-shadow:0 0 0 1px".$footer_link_color.";
	-moz-shadow:0 0 0 1px".$footer_link_color.";
	-o-shadow:0 0 0 1px".$footer_link_color.";
	box-shadow:0 0 0 1px".$footer_link_color.";
} 
#ft-widget-content .tagcloud a:hover{
	background-color:".$footer_link_hover_color.";
	-webkit-box-shadow:0 0 0 1px".$footer_link_hover_color.";
	-moz-shadow:0 0 0 1px".$footer_link_hover_color.";
	-o-shadow:0 0 0 1px".$footer_link_hover_color.";
	box-shadow:0 0 0 1px".$footer_link_hover_color.";
}
#ft-widget-content .inactive_tab{
	color:".$footer_text_color.";
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	border-color:".$footer_bgcolor.";
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	-moz-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	-o-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.08);
}
#ft-widget-content .inactive_tab:hover{
	background-color:rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.03);
	-webkit-box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.03);
	-moz-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.03);
	-o-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.03);
	box-shadow:0 0 0 1px rgba(". $rgb[0] . ", " . $rgb[1] . "," . $rgb[2] . ", 0.03);
}
#ft-widget-content .dp_tab_widget_ul{
	border-color:".$footer_link_color.";
}
#ft-widget-content .loop-share-num div{
	color:".$footer_link_hover_color.";
	border-color:".$footer_link_hover_color.";
	background-color:rgba(". $rgb_sns_num[0] . ", " . $rgb_sns_num[1] . "," . $rgb_sns_num[2] . ", 0.14);
}
#ft-widget-content #searchform input#searchtext{
	color:".$footer_text_color.";
}
#ft-widget-content #searchform input.searchsubmit{
	color:".$footer_text_color.";
}
#ft-widget-content #searchform input.searchsubmit:hover{
	color:".$footer_link_hover_color.";
}";



	$result = <<<_EOD_
@charset "utf-8";
$layout_css
$body_css
$base_font_size_css
$list_hover_css
$base_link_color_css
$base_link_hover_color_css
$header_slide_toggle_css
$header_area_css
$header_filter_css
$header_slideshow_css
$global_menu_css
$headline_area_css
$search_form_css
$share_num_css
$container_css
$navigation_link_color_css
$entry_link_css
$link_filled_color_css
$link_filled_hover_color_css
$bordered_obj_css
$border_color_css
$meta_area_css
$form_css
$ranking_css
$common_bg_color_css
$tooltip_css
$quote_css
$comment_box_css
$container_footer_css
$footer_text_color_css
$footer_title_border_css
$btn_label_css
$original_css
_EOD_;

	return $result;
}

/****************************
 * Gradient SVG for IE9
 ***************************/
function gradientSVGForIE9($color1, $color2) {
	if ($color1 == "") return;
	if ($color2 == "") return;

	$xml = <<<_EOD_
<?xml version="1.0" ?>
<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.0" width="100%" height="100%" xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
    <linearGradient id="myLinearGradient1" x1="0%" y1="0%" x2="0%" y2="100%" spreadMethod="pad">
      <stop offset="0%"   stop-color="$color1" stop-opacity="1"/>
      <stop offset="100%" stop-color="$color2" stop-opacity="1"/>
    </linearGradient>
  </defs>
  <rect width="100%" height="100%" style="fill:url(#myLinearGradient1);" />
</svg>
_EOD_;

	return $xml;
}

/*******************************************************
* Write File
*******************************************************/
/** ===================================================
* Write css and svg to the file.
*
* @param	string	$file_path
* @param	string	$string
* @return	true or false
*/
function dp_export_file($file_path, $str) {
	if ( !file_exists($file_path) ) {
		touch( $file_path );
		chmod( $file_path, 0666 );
	}

	//Rewrite CSS for custom design
	if (is_writable( $file_path )){
		//Open
		if(!$fp = fopen($file_path,  'w') ){
			$err_msg = $file_path . ": " . __('The file can not be opened. Please identify the conflict process.','DigiPress');
			$e = new WP_Error();
			$e->add( 'error', $err_msg );
			set_transient( 'dp-admin-option-errors',
				$e->get_error_messages(), 10 );
			add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
    		return false;
  		}
  		//Write 
  		if(!fwrite( $fp, $str )){
			$err_msg = $file_path . ": " . __('The file may be in use by other program. Please identify the conflict process.','DigiPress');
			$e = new WP_Error();
			$e->add( 'error', $err_msg );
			set_transient( 'dp-admin-option-errors',
				$e->get_error_messages(), 10 );
			add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
			return false;
		}
		//Close file
		fclose($fp);
	} else {
		//if only readinig
		$err_msg = $file_path . ": " . __('The file is not rewritable. Please change the permission to 666 or 606.','DigiPress');
		$e = new WP_Error();
		$e->add( 'error', $err_msg );
		set_transient( 'dp-admin-option-errors',
			$e->get_error_messages(), 10 );
		add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
		return false;
	}
	return true;
}
function dp_export_gzip($file_path, $str) {
	if ( !file_exists($file_path) ) {
		touch( $file_path );
		chmod( $file_path, 0666 );
	}

	//Rewrite CSS for custom design
	if (is_writable( $file_path )){
		//Open
		if(!$fp = gzopen($file_path.'.gz',  'w9') ){
			$err_msg = $file_path . ".gz: " . __('The file can not be opened. Please identify the conflict process.','DigiPress');
			$e = new WP_Error();
			$e->add( 'error', $err_msg );
			set_transient( 'dp-admin-option-errors',
				$e->get_error_messages(), 10 );
			add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
    		return false;
  		}
  		//Write 
  		if(!gzwrite( $fp, $str )){
			$err_msg = $file_path . ".gz: " . __('The file may be in use by other program. Please identify the conflict process.','DigiPress');
			$e = new WP_Error();
			$e->add( 'error', $err_msg );
			set_transient( 'dp-admin-option-errors',
				$e->get_error_messages(), 10 );
			add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
			return false;
		}
		//Close file
		gzclose($fp);
	} else {
		//if only readinig
		$err_msg = $file_path . ".gz: " . __('The file is not rewritable. Please change the permission to 666 or 606.','DigiPress');
		$e = new WP_Error();
		$e->add( 'error', $err_msg );
		set_transient( 'dp-admin-option-errors',
			$e->get_error_messages(), 10 );
		add_action( 'admin_notices', array('digipress_options', 'dp_show_admin_error_message') );
		return false;
	}
	return true;
}


/****************************
 * HEX to RGB
 ***************************/
function hexToRgb($color) {
	$color = preg_replace("/^#/", '', $color);
	if (mb_strlen($color) == 3) $color .= $color;
	$rgb = array();
	for($i = 0; $i < 6; $i+=2) {
		$hex = substr($color, $i, 2);
		$rgb[] = hexdec($hex);
	}
	return $rgb;
}
?>
