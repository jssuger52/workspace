<?php 
/*---------------------------------------
 * Javascript for autopager
 *--------------------------------------*/
function showScriptForAutopager($page_num) {
	global $COLUMN_NUM, $ARCHIVE_STYLE, $options, $options_visual;
	
	$autopagerCode = '';

	// ----------------------------------
	// Scripr for Auto pager 
	// ----------------------------------
	if ($options['autopager'] && !is_single() && !is_page()) :
		// Current archive type 
		$current_archive_flag = '';
		if (is_home()) {
			$current_archive_flag = 'top';
		} else {
			$current_archive_flag = 'archive';
		}
		$current_archive_flag = $options[$current_archive_flag.'_post_show_type'];
		// If category
		if (is_category()) {
			// Get archive style (/inc/scr/get_archive_style.php)
			// return array($current_archive_flag, $archive_style, $archive_normal_style)
			extract($ARCHIVE_STYLE);
			$current_archive_flag = $archive_style;
		}

		$callback 		= '';
		$infiniteAddSelector = ($COLUMN_NUM === 1) ? '.loop-div.one-col' : '.loop-div.two-col';
		$itemSelector 	= '.loop-article';
		$navSelector	= 'nav.navigation';
		$nextSelector	= '.nav_to_paged a';
		$lastMsg		= 'NO MORE CONTENTS';

		// Code
		switch ($current_archive_flag) {
			case 'normal':
			case 'magazine':
				$callback = <<< EOD
preventAnchorNavigate('.media-modal a');
EOD;
				break;

			case 'gallery':
			case 'portfolio':
				$callback = <<< EOD
clickArchiveThumb();
preventAnchorNavigate('.media-modal a');
EOD;
				break;
		}

		// Append common
		$callback .= <<< EOD
getAnchor();
imagesLoadedRun(j$(".loop-post-thumb"), 500);
showLoopMediaModal('.media-modal');
var newElems = j$(this);
var msnryCntr = j$('.$current_archive_flag $infiniteAddSelector').masonry();
msnryCntr.imagesLoaded(function() {
msnryCntr.masonry('appended', newElems);
});
EOD;

		// JS
		$autopagerCode = <<< EOD
<script type="text/javascript">
j$(function() {
	j$.autopager({
		autoLoad: false,
		content:'$itemSelector',
		appendTo:'$infiniteAddSelector',
		link:'$nextSelector',
		start: function(current, next){
			j$('$navSelector').before('<div id="pager-loading"></div>');
		},
		load: function(current, next){
			$callback
			j$('#pager-loading').remove();
			if　(current.page >= $page_num)　{
				j$('$navSelector').hide();
				j$('$navSelector').before('<div class="pager_msg_div"><div class="pager_last_msg">$lastMsg</div></div>');
				j$('.pager_msg_div').fadeIn();
				setTimeout(function(){
					j$('.pager_msg_div').fadeOut();
				}, 4000);
			}
		}
	});
    j$('$nextSelector').click(function() {
		j$.autopager('load');
		return false;
	});
});
</script>
EOD;
		$autopagerCode = str_replace(array("\r\n","\r","\n","\t"), '', $autopagerCode);
	endif;
	echo $autopagerCode;
}


/*---------------------------------------
 * Javascript for autopager in mobile
 *--------------------------------------*/
function showScriptForAutopagerMobile($page_num) {
	global $COLUMN_NUM, $ARCHIVE_STYLE, $options, $options_visual;
	
	$autopagerCode = '';

	// ----------------------------------
	// Scripr for Auto pager 
	// ----------------------------------
	if ($options['autopager_mb'] && !is_single() && !is_page()) :
		// Current archive type 
		$current_archive_flag = '';
		if (is_home()) {
			$current_archive_flag = 'top';
		} else {
			$current_archive_flag = 'archive';
		}
		$current_archive_flag = $options[$current_archive_flag.'_post_show_type'];
		// If category
		if (is_category()) {
			extract($ARCHIVE_STYLE);
			$current_archive_flag = $archive_style;
		}

		$callback 		= '';
		$infiniteAddSelector = '.loop-div';
		$itemSelector 	= '.loop-article';
		$navSelector	= 'nav.navigation';
		$nextSelector	= '.nav_to_paged a';
		$lastMsg		= 'NO MORE CONTENTS';

		// Code
		switch ($current_archive_flag) {
			case 'normal':
			case 'magazine':
				$current_archive_flag = 'blog';
				break;

			case 'gallery':
			case 'portfolio':
				$current_archive_flag = 'app-image';
				$callback = 'clickArchiveThumb();';
				break;
		}

		// Append common
		$callback .= <<< EOD
getAnchor();
imagesLoadedRun(".loop-post-thumb", 0, ".loop-post-thumb a", 500);
EOD;

		// JS
		$autopagerCode = <<< EOD
<script type="text/javascript">
j$(function() {
	j$.autopager({
		autoLoad: false,
		content:'$itemSelector',
		appendTo:'$infiniteAddSelector',
		link:'$nextSelector',
		start: function(current, next){
			j$('$navSelector').before('<div id="pager-loading"></div>');
		},
		load: function(current, next){
			$callback
			j$('#pager-loading').remove();
			if　(current.page >= $page_num)　{
				j$('$navSelector').hide();
				j$('$navSelector').before('<div class="pager_msg_div"><div class="pager_last_msg">$lastMsg</div></div>');
				j$('.pager_msg_div').fadeIn();
				setTimeout(function(){
					j$('.pager_msg_div').fadeOut();
				}, 4000);
			}
		}
	});
    j$('$nextSelector').click(function() {
		j$.autopager('load');
		return false;
	});
});
</script>
EOD;
		$autopagerCode = str_replace(array("\r\n","\r","\n","\t"), '', $autopagerCode);
	endif;
	echo $autopagerCode;
}
?>