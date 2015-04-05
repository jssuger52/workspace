<?php global $IS_MOBILE_DP; ?>
<form method="get" id="searchform"<?php if ($IS_MOBILE_DP) echo ' class="mb"'; ?> action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div class="searchtext_div"><label for="searchtext" class="assistive-text"><?php _e( 'Search', 'DigiPress' ); ?></label>
<input type="text" class="field searchtext" name="s" id="searchtext" placeholder="<?php esc_attr_e( 'Search', 'DigiPress' ); ?>" /></div>
<?php 
// Search submit button (mobile or PC)
if ($IS_MOBILE_DP) :
?>
<span class="submit searchsubmit icon-search" name="submit"></span>
<?php
else :
?>
<input type="submit" class="submit searchsubmit" name="submit" value="" />
<?php
endif;
?>
</form>
