<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/acf.php',                    // Load ACF functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}


//home page top menu
function dlinq_top_menu_list($title){
			$title_id = sanitize_title($title);
			$base_url = get_site_url();//{$base_url}
			echo "<a href='#{$title_id}'>{$title}</a>";
}

//home page events 
function dlinq_home_events(){
	$events = tribe_get_events(
			array(
				'eventDisplay'=>'upcoming',
				'posts_per_page'=>10,			
		)
	);
	$number = sizeof($events);
	if($events){
		$plural = '';
		if($number >1 ){
			$plural = 's';
		}
		$title = get_the_title();
		$args = array(
			'count' => $number,
			'cat' => '',
			'plural' => $plural
		);
		get_template_part( 'loop-templates/content', 'event-accordion', $args );
		
	}
	
}

//home page details titles
function dlinq_topic_title($title){
	$title_id = sanitize_title($title);
	echo "<h2 class='topic-title' id='{$title_id}' name='{$title_id}'>{$title}</h2>";
}

//home page details pages list
function dlinq_topic_list($pages){
	foreach($pages as $page){
		$title = dlinq_cleanup_title($page->post_title);
		$post_id = $page->ID;
		$url = get_permalink($post_id);
		$slug = $page->post_name;
		
		echo "<li><a href='{$url}'>{$title}</a></li>";
	}
}

function dlinq_cleanup_title($title){
	if(str_contains($title, 'Instructor')){
		$clean_title = str_replace('Instructor', '', $title);
		return $clean_title;
	} else {
		return $title;
	}
}

//home page focus area image 
function dlinq_focus_image($image){
	$src = $image['sizes']['medium'];
	$alt = $image['alt'];
	echo "<img class='img-fluid focus' src='{$src}' alt='{$alt}'>";
}

//Single person page

function dlinq_person_details($field_name){
	if ( get_field($field_name) ) {
		$the_field = get_field($field_name);
		$field_label = get_field_object($field_name)['label'];
		$class = sanitize_title($field_name);
		if($field_name == 'email'){
			$the_field = "<a href='mailto:$the_field'>{$the_field}</a>";
		}
		echo "
			<div class='{$class} person-detail'>
				<span class='field-label'>{$field_label}</span>: {$the_field}
			</div>
		";
	}
}

function dlinq_person_projects(){
	if(get_field('project')){
		echo "<h2>Projects</h2><div class='person-projects'>";
		$projects = get_field('project');
		foreach($projects as $project){
			$post_id = $project->ID;
			$title = $project->post_title;
			$link = get_permalink( $post_id);
			$url_stem = get_template_directory_uri();
			if(has_post_thumbnail($post_id)){
				$image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'img-fluid') );
			} else {
				$image = "<img src='{$url_stem}/imgs/no-pic.svg' class='img-fluid bio-pic-project' alt='A generic project placeholder.'>";
			}
			echo "
			<div class='project'>
				<a href='{$link}'>
					{$image}					
					<span class='project-name'>{$title}</span>
				</a>
			</div>
			";
		}
		echo "</div>";
	}
	
}

//single project page

function dlinq_projects_people(){
	if(get_field('persons')){
		echo "<h2>People</h2><div class='project-people'>";
		$people = get_field('persons');
		foreach($people as $person){
			$post_id = $person->ID;
			$title = $person->post_title;
			$link = get_permalink( $post_id);
			$image = dlinq_person_thumb_check($post_id, 'thumbnail', 'img-fluid bio-pic-project');
			
			echo "
			<div class='person'>
				<a class='stretched-link' href='{$link}'>
					{$image}					
					<span class='project-person-name'>{$title}</span>
				</a>
			</div>
			";
		}
		echo "</div>";
	}
	
}

function dlinq_person_thumb_check($post_id, $size, $class){
	$url_stem = get_template_directory_uri();
	if(has_post_thumbnail($post_id)){
				$image = get_the_post_thumbnail( $post_id, $size, array( 'class' => $class) );
			} else {
				$image = "<img src='{$url_stem}/imgs/no-pic.svg' class='{$class}' alt='A generic face placeholder.'>";
			}
	return $image;
}

function dlinq_projects_cats(){
	global $post;
	$post_id = $post->ID;
	$categories = get_the_category($post_id);
	foreach($categories as $category){
		$title = $category->name;
		$url = get_category_link( $category->term_id );
		echo "
			<div class='project-cat'>
				<a class='btn-dlinq' href='{$url}'>{$title}</a>
			</div>
		";
	}
}

//topic functions
function dlinq_topic_menu(){
	if ( have_rows('content') ) {
		echo "<div class='menu-block'>
		<h2>Topics</h2>
		<ul class='sub-topic-list'>";
		 while( have_rows('content') ) : the_row(); 
			if( get_row_layout() == 'sub_topic'){
				$title = get_sub_field('sub_topic_title');
				dlinq_topic_menu_title($title);
			}
			if( get_row_layout() == 'image'){
				$title = get_sub_field('title');
				dlinq_topic_menu_title($title);
			}
			if( get_row_layout() == 'full_block'){
				$title = get_sub_field('title');
				dlinq_topic_menu_title($title);
			}
			if( get_row_layout() == 'accordion'){
				$title = get_sub_field('accordion_title');
				dlinq_topic_menu_title($title);
			}
			if( get_row_layout() == 'posts'){
				$title = get_sub_field('title');
				dlinq_topic_menu_title($title);
			}
			if( get_row_layout() == 'people'){
				$title = get_sub_field('title');
				dlinq_topic_menu_title($title);
			}
	
		 endwhile;
	echo "</ul></div>";
	}
}
 
 function dlinq_topic_menu_title($title){
	if($title){
		$slug = sanitize_title($title);
				echo "			
					<li class='sub-topic'>
						<a href='#{$slug}'>{$title}</a>
					</li>
			";
	}
 }


//events for topics 

function dlinq_topic_events($cat){
	$events = tribe_get_events(
			array(
				'eventDisplay'=>'upcoming',
				'posts_per_page'=>10,
				'tax_query'=> array(
				array(
				'taxonomy' => 'tribe_events_cat',
				'field' => 'slug',
				'terms' => $cat
				)
			)
		)
	);
	$number = sizeof($events);
	if($events){
		$plural = '';
		if($number >1 ){
			$plural = 's';
		}
		$title = get_the_title();
		$args = array(
			'count' => $number,
			'cat' => $cat,
			'plural' => $plural
		);
		get_template_part( 'loop-templates/content', 'event-accordion', $args );
		
	}
	
}

//GENERAL FUNCTIONS
//checks title to make sure it's a category option

function dlinq_add_category($post_ID, $post, $update){
	$title = get_the_title($post_ID);
	//post type is topic or post template is full width focus page
	if(($post->post_type ==  'topic' || get_page_template_slug($post_ID) == 'page-templates/focuspage.php') && $post->post_status == 'publish'){
			wp_create_category($title);
			$args = array(
				'taxonomy' => 'tribe_events_cat',
				'cat_name' => $title
			);
			wp_insert_category($args);//add to events category as well
	}
}

add_action( 'save_post', 'dlinq_add_category', 10, 3 ); //don't forget the last argument to allow all three arguments of the function

add_filter( 'wp_nav_menu_items', 'add_logo_nav_menu', 10, 2 );
function add_logo_nav_menu($items, $args){
    $newitems = '<li class="menu-item menu-item-type-post_type menu-item-object-tribe_events nav-item connect-li"><button type="button" class="connect" data-bs-toggle="modal" data-bs-target="#formModal">
Connect</button></li>';
    $items .= $newitems;

	return $items;
}


//parent breadcrumbs
function dlinq_custom_breadcrumbs(){
    global $post;
    if( $post->post_parent ){
		// If child page, get parents
		$anc = get_post_ancestors( $post->ID );

		// Get parents in the right order
		$anc = array_reverse($anc);

		// Parent page loop
		if ( !isset( $parents ) ) $parents = null;
		$home_url = get_site_url();
		$parents .= "<span class='item-parent'><a class='bread-parent' href='{$home_url}'>Home</a> &#187; </span> ";
		$last_key = sizeof($anc);
		foreach ( $anc as $key => $ancestor ) {
			$title = get_the_title($ancestor);
			$link = get_the_permalink($ancestor);
			$parents .= "<span class='item-parent item-parent-{$ancestor}'>
							<a class='bread-parent bread-parent-{$ancestor}' href='{$link}' title='{$title}'>{$title}</a> &#187;
						</span>";
			$parents .= "<span class='separator separator-{$ancestor}'> </span>";
		}

		// Display parent pages
		echo $parents;

                // Current page
               echo '<span class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></span>';
               
            } else {

            }
    }

//maybe force bs 5 in theme customizer
function understrap_default_bootstrap_version( $current_mod ) {
    return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );


//FIX TITLE ON QUOTES 
// function dlinq_quote_titles ($post_id){
//   $type = get_post_type($post_id);
//   if ($type === 'quote'){
//     remove_action( 'save_post', 'quoteTitles' );
//     $quote = substr(get_field( "the_quote", $post_id ),0, 40) . ' . . .';
//     $my_post = array(
//         'ID'           => $post_id,
//         'post_title'   => wp_strip_all_tags($quote),      
//     );

//   // Update the post into the database
//     wp_update_post( $my_post );
//   }
// }
//     add_action( 'save_post', 'dlinq_quote_titles' );


//change title for ACF flexible layout in collapsed mode

add_filter('acf/fields/flexible_content/layout_title/name=content', 'dlinq_acf_fields_flexible_content_layout_title', 10, 4);
function dlinq_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {

    if( get_sub_field('sub_topic_title') ) {
        $title .= ' - ' . get_sub_field('sub_topic_title');     
    }
	if( get_sub_field('title') ) {
        $title .= ' - ' . get_sub_field('title');     
    }
	 if( get_sub_field('accordion_title') ) {
        $title .= ' - ' . get_sub_field('accordion_title');     
    }


    return $title;
}


add_action( 'admin_head-options-reading.php', 'wpse_18013_modify_front_pages_dropdown' );
//add_action( 'pre_get_posts', 'wpse_18013_enable_front_page_stacks' );

function wpse_18013_modify_front_pages_dropdown()
{
    // Filtering /wp-includes/post-templates.php#L780
    add_filter( 'get_pages', 'wpse_18013_add_cpt_to_pages_on_front' );
}

function wpse_18013_add_cpt_to_pages_on_front( $r )
{
    $args = array(
        'post_type' => 'topic'
    );
    $stacks = get_posts( $args );
    $r = array_merge( $r, $stacks );

    return $r;
}

function wpse_18013_enable_front_page_stacks( $query )
{
    if( isset($query->query_vars['post_type']) === FALSE && 0 != $query->query_vars['page_id'] )
        $query->query_vars['post_type'] = array( 'page', 'topic' );
}

function dlinq_remove_www($string){
	$string = strtolower($string);
	if(str_contains($string, 'www.')){
		$string = str_replace('www.', '', $string);
		return $string;
	}
	return $string;
}

//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}