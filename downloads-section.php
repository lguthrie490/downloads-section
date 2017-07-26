<?php
/*
Plugin Name: Downloads Section Plugin
Plugin URI: http://logan.codes/downloads-section-plugin
Description: Creates a loop for simple download links
Version: 0.1
Author: Logan Guthrie
Author URI: http://logan.codes
License: GPL2
*/

include 'Downloads.php';

add_shortcode('Downloads', array($this, 'getDownloadsSection'));

register_activation_hook("wp_content/plugins/downloads-section.php", "downloadsInit");

add_action('downloadsSection', 'getDownloadsSection');

register_deactivation_hook("wp_content/plugins/downloads-section.php", "deleteDownloads");

/**
 * @param int $columns
 *
 * @return Downloads
 */
function getDownloadsSection($columns = 3) {
    return new Downloads($columns);
}

/**
 * Wrapper for initializing plugin
 */
function downloadsInit() {
    downloadsPostTypeInit();

    flush_rewrite_rules();
}

function downloadsPostTypeInit() {
    $args = array(
        'label' => 'Downloads',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'download'),
        'query_var' => true,
        'menu_icon' => 'dashicons-download',
        'supports' => array(
            'title',
            'excerpt',
            'trackbacks',
            'revisions',
            'thumbnail',
            'page-attributes',
        )
    );

    register_post_type( 'downloads', $args );
}

/**
 * Deactivation method
 */
function deleteDownloads() {
    unregister_post_type('downloads');
}