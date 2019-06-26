<?php

/**
 * Returns the parsed shortcode.
 *
 * @param array   {
 *     Attributes of the shortcode.
 *
 *     @type string $id ID of...
 * }
 * @param string  Shortcode content.
 *
 * @return string HTML content to display the shortcode.
 */
function shortcodeCallback( $atts = array(), $content = '' ) {
    $atts = shortcode_atts( array(
        'id' => 'value',
    ), $atts, 'shortcode' );

    // do shortcode actions here
}

add_shortcode( 'shortcode', 'shortcodeCallback' );
