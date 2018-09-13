<?php
   /*
   Plugin Name: Menú acordeón
   Text Domain: menu-acordeon
   Plugin URI: https://github.com/aitormendez/menu-acordeon
   Description: Plugin de WordPress. Detecta qué items de menú son taxonomías y
   añade todos los post correspondientes a esa categoría como un submenú.
   Version: 1.0
   Author: Aitor Méndez
   Author URI: https://e451.net
   License: GPL 3.0
   */
?>
<?php
class ep_submenu extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
        if( 'taxonomy' == $item->type ) {
            $output .= '<li><a class="toggle" href="javascript:void(0);">' . $item->title . '</a>';
        } else {
            if( $item->url && $item->url != '#' ) {
                  $output .= '<li><a href="' . $item->url . '">';
                } else {
                  $output .= '<li>';
                }
            $output .= $item->title;
            if( $item->url && $item->url != '#' ) {
                  $output .= '</a></li>';
                } else {
                  $output .= '</li>';
                }
        }
    }

    public function end_el(&$output, $item, $depth=0, $args=[]) {
        if( 'taxonomy' == $item->type ) {
            $posts_args = [
                'nopaging'    => true,
                'category'    => $item->object_id
            ];
            $cat_posts = get_posts($posts_args);
            if ( $cat_posts ) {
                $output .= '<ul class="inner">';
                foreach ( $cat_posts as $cat_post ) {
                    $link = get_permalink( $cat_post->ID );
                    $title = apply_filters( 'the_title', $cat_post->post_title );
                    if ( $title ) {
                        $output .= '<li><a href="' . $link  . '">' . $title . '</a></li>';
                    }
                }
                $output .= '</ul>';
            }
        }
        $output .= "</li>\n";
    }
}
