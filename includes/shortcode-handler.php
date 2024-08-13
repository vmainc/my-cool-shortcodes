<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function my_cool_shortcodes_register_shortcodes() {
    $shortcodes = get_option( 'my_cool_shortcodes_list', array() );

    if ( ! empty( $shortcodes ) && is_array( $shortcodes ) ) {
        foreach ( $shortcodes as $shortcode ) {
            // Ensure the shortcode has a name and content
            if ( ! empty( $shortcode['name'] ) && ! shortcode_exists( $shortcode['name'] ) ) {
                add_shortcode( $shortcode['name'], function() use ( $shortcode ) {
                    return do_shortcode( $shortcode['content'] );
                } );
            }
        }
    }
}
add_action( 'init', 'my_cool_shortcodes_register_shortcodes' );
