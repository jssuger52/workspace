<?php // Container footer widget
if (is_active_sidebar('widget-container-footer') && !is_404()) : ?>
<div id="container_footer">
<div id="content_footer" class="clearfix">
<?php dynamic_sidebar( 'widget-container-footer' ); ?>
</div>
</div>
<?php endif; ?>
<footer id="footer">
<?php // show footer widgets
	dp_get_footer();
?>
<div id="footer-bottom"><div id="ft-btm-content">&copy; <?php 
global $options;
if ($options['blog_start_year'] !== '') {
	echo $options['blog_start_year'] . '-' . date('Y');
} else {
	echo date('Y');
} ?> <a href="<?php echo home_url(); ?>/"><small><?php bloginfo('name'); ?></small></a>
</div></div>
</footer>
<a href="#main-body" id="gototop" class="icon-up-open" title="Return Top"><span>Return Top</span></a>
<?php 
// Footer
wp_footer();
// Javascript for sns
js_for_sns_objects();
?>