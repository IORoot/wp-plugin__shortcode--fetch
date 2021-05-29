<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'Shortcode [fetch]',
        'icon'      => 'allergy',
        'color'     => '#ff0',
        'path'      => __FILE__,
    ]);
} );