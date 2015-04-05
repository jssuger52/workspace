<?php 
get_header(); 
// Header flag
$has_header_class = "main-wrap no-header";

$mobile_flag_class 	= $IS_MOBILE_DP ? 'mb' : '';
?>
<body id="main-body" <?php body_class($mobile_flag_class); ?>>
<?php
// **********************************
// Site header
// **********************************
include_once(TEMPLATEPATH . "/site-header.php");
?>
<div id="main-wrap" class="<?php echo $has_header_class; ?>">
<?php
// **********************************
// Page title
// **********************************
$page_title = dp_current_page_title(false);
if ($page_title) {
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1 class="headline-static-title">'.$page_title.'</h1></div></section>';
}
// ***********************************
// Not found...
// ***********************************
?>
<div id="container" class="container clearfix">
<div id="content" class="content one-col">
<?php
	include_once(TEMPLATEPATH .'/not-found.php');
?>
</div><?php // end of #content?>
</div><?php // end of #container ?>
</div><?php // end of #main-wrap


// **********************************
// Breadcrumb
// **********************************
echo '<div id="dp_breadcrumb_div">'.dp_breadcrumb(false).'</div>';	
?>
<?php get_footer(); ?>
</body>
</html>