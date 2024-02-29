<?php
/**
 * Custom post types
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//workshop custom post type

// Register Custom Post Type workshop
// Post Type Key: workshop

function create_workshop_cpt() {

  $labels = array(
    'name' => __( 'Workshops', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Workshop', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Workshops', 'textdomain' ),
    'name_admin_bar' => __( 'Workshops', 'textdomain' ),
    'archives' => __( 'Workshop Archives', 'textdomain' ),
    'attributes' => __( 'Workshop Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Workshop:', 'textdomain' ),
    'all_items' => __( 'All Workshops', 'textdomain' ),
    'add_new_item' => __( 'Add New Workshop', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Workshop', 'textdomain' ),
    'edit_item' => __( 'Edit Workshop', 'textdomain' ),
    'update_item' => __( 'Update Workshop', 'textdomain' ),
    'view_item' => __( 'View Workshop', 'textdomain' ),
    'view_items' => __( 'View Workshops', 'textdomain' ),
    'search_items' => __( 'Search Workshops', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into workshop', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this workshop', 'textdomain' ),
    'items_list' => __( 'Workshop list', 'textdomain' ),
    'items_list_navigation' => __( 'Workshop list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Workshop list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'workshop', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-welcome-learn-more',
  );
  register_post_type( 'workshop', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_workshop_cpt', 0 );


//people custom post type

// Register Custom Post Type people
// Post Type Key: people

function create_people_cpt() {

  $labels = array(
    'name' => __( 'Peoples', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'People', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'People', 'textdomain' ),
    'name_admin_bar' => __( 'People', 'textdomain' ),
    'archives' => __( 'People Archives', 'textdomain' ),
    'attributes' => __( 'People Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'People:', 'textdomain' ),
    'all_items' => __( 'All Peoples', 'textdomain' ),
    'add_new_item' => __( 'Add New People', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New People', 'textdomain' ),
    'edit_item' => __( 'Edit People', 'textdomain' ),
    'update_item' => __( 'Update People', 'textdomain' ),
    'view_item' => __( 'View People', 'textdomain' ),
    'view_items' => __( 'View Peoples', 'textdomain' ),
    'search_items' => __( 'Search Peoples', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into people', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this people', 'textdomain' ),
    'items_list' => __( 'People list', 'textdomain' ),
    'items_list_navigation' => __( 'People list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter People list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'people', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-nametag',
  );
  register_post_type( 'person', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_people_cpt', 0 );


//project custom post type

// Register Custom Post Type project
// Post Type Key: project

function create_project_cpt() {

  $labels = array(
    'name' => __( 'Projects', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Project', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Projects', 'textdomain' ),
    'name_admin_bar' => __( 'Projects', 'textdomain' ),
    'archives' => __( 'Project Archives', 'textdomain' ),
    'attributes' => __( 'Project Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Project:', 'textdomain' ),
    'all_items' => __( 'All Projects', 'textdomain' ),
    'add_new_item' => __( 'Add New Project', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Project', 'textdomain' ),
    'edit_item' => __( 'Edit Project', 'textdomain' ),
    'update_item' => __( 'Update Project', 'textdomain' ),
    'view_item' => __( 'View Project', 'textdomain' ),
    'view_items' => __( 'View Projects', 'textdomain' ),
    'search_items' => __( 'Search Projects', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into project', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this project', 'textdomain' ),
    'items_list' => __( 'Project list', 'textdomain' ),
    'items_list_navigation' => __( 'Project list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Project list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'project', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag', 'foci'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-hammer',
  );
  register_post_type( 'project', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_project_cpt', 0 );


//quote custom post type

// Register Custom Post Type quote
// Post Type Key: quote

function create_quote_cpt() {

  $labels = array(
    'name' => __( 'Quotes', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Quote', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Quote', 'textdomain' ),
    'name_admin_bar' => __( 'Quote', 'textdomain' ),
    'archives' => __( 'Quote Archives', 'textdomain' ),
    'attributes' => __( 'Quote Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Quote:', 'textdomain' ),
    'all_items' => __( 'All Quotes', 'textdomain' ),
    'add_new_item' => __( 'Add New Quote', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Quote', 'textdomain' ),
    'edit_item' => __( 'Edit Quote', 'textdomain' ),
    'update_item' => __( 'Update Quote', 'textdomain' ),
    'view_item' => __( 'View Quote', 'textdomain' ),
    'view_items' => __( 'View Quotes', 'textdomain' ),
    'search_items' => __( 'Search Quotes', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into quote', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this quote', 'textdomain' ),
    'items_list' => __( 'Quote list', 'textdomain' ),
    'items_list_navigation' => __( 'Quote list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Quote list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'quote', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 10,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-universal-access-alt',
  );
  register_post_type( 'quote', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_quote_cpt', 0 );


//topic custom post type

// Register Custom Post Type topic
// Post Type Key: topic

function create_topic_cpt() {

  $labels = array(
    'name' => __( 'Topics', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Topic', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Topics', 'textdomain' ),
    'name_admin_bar' => __( 'Topics', 'textdomain' ),
    'archives' => __( 'Topic Archives', 'textdomain' ),
    'attributes' => __( 'Topic Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Topic:', 'textdomain' ),
    'all_items' => __( 'All Topics', 'textdomain' ),
    'add_new_item' => __( 'Add New Topic', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Topic', 'textdomain' ),
    'edit_item' => __( 'Edit Topic', 'textdomain' ),
    'update_item' => __( 'Update Topic', 'textdomain' ),
    'view_item' => __( 'View Topic', 'textdomain' ),
    'view_items' => __( 'View Topics', 'textdomain' ),
    'search_items' => __( 'Search Topics', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into topic', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this topic', 'textdomain' ),
    'items_list' => __( 'Topic list', 'textdomain' ),
    'items_list_navigation' => __( 'Topic list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Topic list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'topic', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag', 'foci'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 4,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-search',
  );
  register_post_type( 'topic', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_topic_cpt', 0 );