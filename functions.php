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
			$url_stem = get_template_directory_uri();
			if(has_post_thumbnail($post_id)){
				$image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'img-fluid bio-pic-project') );
			} else {
				$image = "<img src='{$url_stem}/imgs/no-pic.svg' class='img-fluid bio-pic-project' alt='A generic face placeholder.'>";
			}
			echo "
			<div class='person'>
				<a href='{$link}'>
					{$image}					
					<span class='project-person-name'>{$title}</span>
				</a>
			</div>
			";
		}
		echo "</div>";
	}
	
}

function dlinq_person_thumb_check($post_id){
	$url_stem = get_template_directory_uri();
	if(has_post_thumbnail($post_id)){
				$image = get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'img-fluid bio-pic-project') );
			} else {
				$image = "<img src='{$url_stem}/imgs/no-pic.svg' class='img-fluid bio-pic-project' alt='A generic face placeholder.'>";
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
		<ol class='sub-topic-list'>";
		 while( have_rows('content') ) : the_row(); 
			if( get_row_layout() == 'sub_topic'){
				$title = get_sub_field('sub_topic_title');
				$slug = sanitize_title($title);
			}
			if( get_row_layout() == 'image'){
				$title = get_sub_field('title');
				$slug = sanitize_title($title);
			}
			if( get_row_layout() == 'full_block'){
				$title = get_sub_field('title');
				$slug = sanitize_title($title);
			}
			
			if($title){
				echo "			
					<li class='sub-topic'>
						<a href='#{$slug}'>{$title}</a>
					</li>
			";
			}
			
	
		 endwhile;
	echo "</ol></div>";
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
                $parents .= '<span class="item-parent"><a class="bread-parent" href="' . get_site_url() . '">Home</a> &#187; </span> ';
                foreach ( $anc as $ancestor ) {
                    $parents .= '<span class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . site_url() .'?menu=menu_' . $ancestor . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></span>';
                    $parents .= '<span class="separator separator-' . $ancestor . '"> </span>';
                }

                // Display parent pages
                echo $parents;

                // Current page
               // echo '<span class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></span>';
               
            } else {

            }
    }
