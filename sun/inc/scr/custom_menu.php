<?php
/*******************************************************
* Extend Custom Menu.
*******************************************************/
class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title )	? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )		? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )		? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )		? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$description  = ! empty( $item->description ) ? '<span class="menu-caption">'.esc_attr( $item->description ).'</span>' : '';

		$prepend	= '<span class="menu-title">';
		$append		= '</span>';

		if (($depth != 0) || (($depth == 0) && empty($item->description))) $description = $prepend = $append = '';

		// Only parent menu
		if ( $depth == 0 && !empty($args->before_only_parent) ) {
			$before_only_parent = $args->before_only_parent;
		} else {
			$before_only_parent = '';
		}

		$item_output = $before_only_parent . $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append .$args->link_after;
		$item_output .= $description;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

//Register Custom menu.
register_nav_menus(
	array(
		'global_menu_ul' => (__('Gobal Menu','DigiPress')),
		'footer_menu_ul' => (__('Footer Menu','DigiPress')),
		'top_menu_mobile' => (__('Top Menu (Mobile)','DigiPress')),
		'footer_menu_mobile' => (__('Footer Menu (Mobile)','DigiPress'))
	)
);
?>