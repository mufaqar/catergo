<?php
class Custom_Menu_Walker extends Walker_Nav_Menu {
    /**
     * Start the ul with submenu class
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"submenu\">\n";
    }

    /**
     * End the ul
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the li and output the link
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add has-dropdown class if item has children
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'has-dropdown';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $attributes  = ! empty( $item->attr_title )  ? ' title="'   . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )      ? ' target="'  . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )         ? ' rel="'     . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )         ? ' href="'    . esc_attr( $item->url        ) .'"' : '';

        $item_output  = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        // Add dropdown icon if item has children
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $item_output .= '<i class="fas fa-angle-down"></i>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * End the li
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
?>