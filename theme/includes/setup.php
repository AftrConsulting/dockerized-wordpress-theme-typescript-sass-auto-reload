<?php

/**
 * Disables the scripts.
 */
function disable_scripts() {
    remove_action('wp_head', 'print_emoji_detection_script', 7); 
    remove_action('admin_print_scripts', 'print_emoji_detection_script'); 
    remove_action('wp_print_styles', 'print_emoji_styles'); 
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'disable_scripts');

/**
 * Dequeus the block library.
 */
function dequeue_block_library() {
    wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'dequeue_block_library', 100);

add_filter('image_strip_meta', false);

add_action('init', function() {
    add_theme_support('custom-logo');

    register_sidebar([
        'name' => 'Sidebar',
        'id' => 'my_sidebar'
    ]);

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);
    function clear_nav_menu_item_id($id, $item, $args) {
        return "";
    }

    add_filter('nav_menu_css_class', 'clear_nav_menu_item_class', 10, 3);
    function clear_nav_menu_item_class($classes, $item, $args) {
        if (in_array('current-menu-item', $classes)){
            return [ 'sub-menu-item-same' ];
        }
        return [];
    }
});