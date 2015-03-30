<?php 
/* ------------------------------------------
   This template is for mobile device!!!!!!!
 ------------------------------------------*/
include (TEMPLATEPATH.'/'.DP_MOBILE_THEME_DIR.'/header.php');
// Header flag
$has_header_class = "clearfix";
?>
<body id="main-body" <?php body_class("mb-theme"); ?>>
<div id="wrapper" class="wrapper">
<?php
// **********************************
// Site header
// **********************************
include_once(TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/site-header.php");
?>
<div id="main-wrap" class="<?php echo $has_header_class; ?>">
<?php
// **********************************
// Page title
// **********************************
$page_title = dp_current_page_title(false);
if ($page_title) {
	echo '<section id="headline-sec"><div id="headline-sec-inner"><h1>'.$page_title.'</h1></div></section>';
}
?>
<div id="container" class="container mb-theme clearfix">
<?php

// **********************************
// Main content
// ********************************** ?>
<div id="content" class="content">
<?php
// ***********************************
// Not found...
// ***********************************
include_once(TEMPLATEPATH .'/not-found.php');
?>
</div><?php // end of #content ?>
</div><?php // end of #container

// **********************************
// Footer area
// **********************************
include (TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/footer.php");

// **********************************
// Slider Menu
// **********************************
include (TEMPLATEPATH."/".DP_MOBILE_THEME_DIR."/global-menu.php");
?>
</div><?php // end of #wrapper

// **********************************
// WordPress footer
// **********************************
wp_footer();
// Javascript for sns
js_for_sns_objects();
?>
</body>
</html>