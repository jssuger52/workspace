<?php 
global $SIDEBAR_FLOAT;
?>
<aside id="sidebar" class="<?php echo $SIDEBAR_FLOAT; ?>">
<?php 
if ( !function_exists('dynamic_sidebar') || !is_active_sidebar('Sidebar') ) : 
?>
<div class="widget-box widget_categories">
<h1 class="dp-widget-title"><span><?php _e('Categories', 'DigiPress'); ?></span></h1>
<ul class="widget-ul">
<?php wp_list_categories('show_count=0&child_of&hierarchical=1&title_li='); ?>
</ul>
</div>
<div class="widget-box">
<h1><?php _e('Archive', 'DigiPress'); ?></h1>
<ul class="widget-ul">
<?php wp_get_archives('show_post_count=yes'); ?>
</ul>
</div>
<div class="widget-box">
<h1 class="dp-widget-title"><span><?php _e('Subscribe', 'DigiPress'); ?></span></h1>
<ul class="dp_feed_widget clearfix">
<?php echo ('<li><a href="'
			.get_bloginfo('rss2_url')
			.'" title="'.__('Subscribe feed', 'DigiPress')
			.'" target="_blank" class="icon-rss"><span>RSS</span></a></li>'); ?>
</ul>
</div>
<?php 
else :
	dynamic_sidebar('Sidebar');
endif; 
?>
</aside>
