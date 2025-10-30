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
    'menu_icon' => 'dashicons-editor-quote',
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
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail','page-attributes'),
    'taxonomies' => array('category', 'post_tag', 'foci'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 4,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'menu_icon' => 'dashicons-search',
  );
  register_post_type( 'topic', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_topic_cpt', 0 );


//resource custom post type

// Register Custom Post Type resource
// Post Type Key: resource

function create_resource_cpt() {

  $labels = array(
    'name' => __( 'Resources', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Resource', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Resource', 'textdomain' ),
    'name_admin_bar' => __( 'Resource', 'textdomain' ),
    'archives' => __( 'Resource Archives', 'textdomain' ),
    'attributes' => __( 'Resource Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Resource:', 'textdomain' ),
    'all_items' => __( 'All Resources', 'textdomain' ),
    'add_new_item' => __( 'Add New Resource', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Resource', 'textdomain' ),
    'edit_item' => __( 'Edit Resource', 'textdomain' ),
    'update_item' => __( 'Update Resource', 'textdomain' ),
    'view_item' => __( 'View Resource', 'textdomain' ),
    'view_items' => __( 'View Resources', 'textdomain' ),
    'search_items' => __( 'Search Resources', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into resource', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this resource', 'textdomain' ),
    'items_list' => __( 'Resource list', 'textdomain' ),
    'items_list_navigation' => __( 'Resource list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Resource list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'resource', 'textdomain' ),
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
    'menu_icon' => 'dashicons-admin-links',
  );
  register_post_type( 'resource', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_resource_cpt', 0 );


//policy custom post type

// Register Custom Post Type policy
// Post Type Key: policy

function create_policy_cpt() {

  $labels = array(
    'name' => __( 'Policies', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Policy', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Policy', 'textdomain' ),
    'name_admin_bar' => __( 'Policy', 'textdomain' ),
    'archives' => __( 'Policy Archives', 'textdomain' ),
    'attributes' => __( 'Policy Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Policy:', 'textdomain' ),
    'all_items' => __( 'All Policies', 'textdomain' ),
    'add_new_item' => __( 'Add New Policy', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Policy', 'textdomain' ),
    'edit_item' => __( 'Edit Policy', 'textdomain' ),
    'update_item' => __( 'Update Policy', 'textdomain' ),
    'view_item' => __( 'View Policy', 'textdomain' ),
    'view_items' => __( 'View Policies', 'textdomain' ),
    'search_items' => __( 'Search Policies', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into policy', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this policy', 'textdomain' ),
    'items_list' => __( 'Policy list', 'textdomain' ),
    'items_list_navigation' => __( 'Policy list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Policy list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'policy', 'textdomain' ),
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
    'hierarchical' => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-universal-access-alt',
  );
  register_post_type( 'policy', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_policy_cpt', 0 );


//definition custom post type

// Register Custom Post Type definition
// Post Type Key: definition

function create_definition_cpt() {

  $labels = array(
    'name' => __( 'Definitions', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Definition', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Definition', 'textdomain' ),
    'name_admin_bar' => __( 'Definition', 'textdomain' ),
    'archives' => __( 'Definition Archives', 'textdomain' ),
    'attributes' => __( 'Definition Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Definition:', 'textdomain' ),
    'all_items' => __( 'All Definitions', 'textdomain' ),
    'add_new_item' => __( 'Add New Definition', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Definition', 'textdomain' ),
    'edit_item' => __( 'Edit Definition', 'textdomain' ),
    'update_item' => __( 'Update Definition', 'textdomain' ),
    'view_item' => __( 'View Definition', 'textdomain' ),
    'view_items' => __( 'View Definitions', 'textdomain' ),
    'search_items' => __( 'Search Definitions', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into definition', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this definition', 'textdomain' ),
    'items_list' => __( 'Definition list', 'textdomain' ),
    'items_list_navigation' => __( 'Definition list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Definition list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'definition', 'textdomain' ),
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
    'menu_icon' => 'dashicons-info',
  );
  register_post_type( 'definition', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_definition_cpt', 0 );


function create_prompt_cpt() {

    $labels = array(
      'name' => __( 'Prompts', 'Post Type General Name', 'textdomain' ),
      'singular_name' => __( 'Prompt', 'Post Type Singular Name', 'textdomain' ),
       'add_new_item' => __( 'Add New Prompt', 'textdomain' ),
      'add_new' => __( 'Add New', 'textdomain' ),
      'new_item' => __( 'New Prompt', 'textdomain' ),
      'edit_item' => __( 'Edit Prompt', 'textdomain' ),
    );
    $args = array(
      'label' => __( 'prompt', 'textdomain' ),
      'description' => __( '', 'textdomain' ),
      'labels' => $labels,
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
      'menu_icon' => 'dashicons-welcome-write-blog',
    );
    register_post_type( 'prompt', $args );
    
    // flush rewrite rules because we changed the permalink structure
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
  }
  add_action( 'init', 'create_prompt_cpt', 0 );