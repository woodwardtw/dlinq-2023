<?php
/**
 * ACF data
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


function local_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'local_acf_json_save_point' );