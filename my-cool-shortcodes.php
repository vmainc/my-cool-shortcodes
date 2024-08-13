<?php
/**
 * Plugin Name: My Cool Shortcodes
 * Description: A plugin to create and manage custom shortcodes with a TinyMCE editor and a custom settings page.
 * Version: 1.0
 * Author: Virtual Market Advantage
 * Text Domain: my-cool-shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define plugin constants
define( 'MY_COOL_SHORTCODES_VERSION', '1.0' );
define( 'MY_COOL_SHORTCODES_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_COOL_SHORTCODES_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
include_once MY_COOL_SHORTCODES_PATH . 'includes/admin-settings.php';
include_once MY_COOL_SHORTCODES_PATH . 'includes/shortcode-handler.php';
include_once MY_COOL_SHORTCODES_PATH . 'includes/manage-shortcode.php';

// Register block editor scripts and styles
function my_cool_shortcodes_register_block_assets() {
    wp_register_script(
        'my-cool-shortcodes-block',
        MY_COOL_SHORTCODES_URL . 'blocks/block.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ),
        MY_COOL_SHORTCODES_VERSION,
        true
    );

    wp_register_style(
        'my-cool-shortcodes-editor-style',
        MY_COOL_SHORTCODES_URL . 'blocks/editor.css',
        array( 'wp-edit-blocks' ),
        MY_COOL_SHORTCODES_VERSION
    );

    wp_register_style(
        'my-cool-shortcodes-style',
        MY_COOL_SHORTCODES_URL . 'blocks/style.css',
        array(),
        MY_COOL_SHORTCODES_VERSION
    );
}
add_action( 'init', 'my_cool_shortcodes_register_block_assets' );

// Enqueue block editor assets
function my_cool_shortcodes_enqueue_block_editor_assets() {
    wp_enqueue_script( 'my_cool-shortcodes-block' );
    wp_enqueue_style( 'my_cool-shortcodes-editor-style' );
}
add_action( 'enqueue_block_editor_assets', 'my_cool_shortcodes_enqueue_block_editor_assets' );

// Enqueue frontend assets
function my_cool_shortcodes_enqueue_frontend_assets() {
    wp_enqueue_style( 'my_cool-shortcodes-style' );
}
add_action( 'enqueue_block_assets', 'my_cool_shortcodes_enqueue_frontend_assets' );
