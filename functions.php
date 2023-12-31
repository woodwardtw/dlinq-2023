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


function dlinq_project_button(){
	global $post;
	if(get_field('project_url', $post->ID)){
		$link = get_field('project_url', $post->ID);
		echo "<a class='btn-dlinq' href='{$link}''>See the project</a>";
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

//person links
function dlinq_person_links(){
	if(get_field('external_links')){
		echo '<div class="external-links">';
		$links = get_field('external_links');
		//var_dump($links);
		foreach ($links as $key => $link) {		
			$link_url = $link['link_url'];
			$title = $link['link_title'];
			echo "<a class='btn-primary btn-dlinq' href='{$link_url}'>{$title}</a>";
		}
		echo '</div>';
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

//GRAVITY RELATED

//CHALLENGES

//add gravity forms to acf field for the daily create challenge option
/**
 * Populate ACF select field options with Gravity Forms forms
 */

//might need something like https://wordpress.org/plugins/categories-for-gravity-forms/
function acf_populate_gf_forms_ids( $field ) {
	if ( class_exists( 'GFFormsModel' ) ) {
		$choices = [''];

		foreach ( \GFFormsModel::get_forms() as $form ) {
			$choices[ $form->id ] = $form->title;
		}

		$field['choices'] = $choices;
	}

	return $field;
}
add_filter( 'acf/load_field/name=form_id', 'acf_populate_gf_forms_ids' );


function dlinq_gf_form_entry_display($form_id){
	$search_criteria = array(
	    'status'        => 'active',
	    'field_filters' => array(
	        'mode' => 'any',
	        array(
	            'key'   => '7',
	            'value' => 'public'
	        )
	    )
	);
 
	// Getting the entries
	$results = GFAPI::get_entries( $form_id, $search_criteria );
	$html = '';
	foreach ($results as $key => $result) {
		$text = ($result['6'] != '') ? "<div class='response-text'>{$result['6']}</div>" : '';
		$name = ($result['1.3'] != '' || $result['1.6'] != '') ? "<div class='response-name'>{$result['1.3']} {$result['1.6']}</div>" : '';
		$year = dlinq_year_cleaner($result['3']);
		$grad = ($result['3'] != '') ? "<div class='response-year'>'{$year}</div>" : '';
		//var_dump(dlinq_year_cleaner($result['3']));
		$img = ($result['8'] != '') ? "<div class='response-img'><img src='{$result['8']}' class='img-fluid' alt='An image created from the prompt.'></div>" : '';
		$html .= "<div class='response'>{$img} {$text} <div class='responder'>{$name} {$grad}</div></div>";
	}
	echo "<div class='response-holder'>
			<h2 id='responses'>Responses</h2>
			{$html}
		</div>";
}

function dlinq_year_cleaner($year){
	if(strlen($year)==2){
		return $year;
	}
	if(strlen($year)==4){
		return substr($year, -2);
	}
	if(substr($year, -2)=='.5'){
		return substr($year, -4);
	}
	else {
		return '';
	}

}

/*
**
** EVENT and AJAX attendance 
**
*/

//EVENT REGISTRATION button display
function dlinq_event_registration(){
  global $post;
  $past = dlinq_tribe_is_past_event( $post->ID);
  if( $past != TRUE){
    echo "<button class='btn-dlinq btn-register-event' data-bs-toggle='modal' data-bs-target='#registrationModal'>Register</button>";
  }
}

//hide button if event is past
//from https://theeventscalendar.com/support/forums/topic/check-if-event-has-passed/
// Usage tribe_is_past_event( $event_id )
function dlinq_tribe_is_past_event( $event = null ){
  if ( ! tribe_is_event( $event ) ){
    return false;
  }
  $event = tribe_events_get_event( $event );
  $event_time_zone = get_post_meta( $event->ID, '_EventTimezone', true );
  date_default_timezone_set($event_time_zone);
  // Grab the event End Date as UNIX time
  $end_date = tribe_get_end_date( $event, '', 'UTC');
  if(time() > $end_date){
    return TRUE;//has expired
  } else {
    return FALSE;//still live
  }
}

//hide button if over limit 
function dlinq_registration_check(){
		$limit = intval(get_field('attendance_limit'));
		global $post;
		$post_id = $post->ID;
		$total_count = 0;
		$sorting         = array();
		$paging          = array( 'offset' => 0, 'page_size' => 25 );
		$search_criteria = array(
			    'status'        => 'active',
			    'field_filters' => array(
			        'mode' => 'any',
			        array(
			            'key'   => '6',
			            'value' => $post_id
			        )
			    )
			);
	 
		// Getting the entries
		$results = GFAPI::get_entries( 5, $search_criteria, $sorting, $paging, $total_count );
		if(sizeof($results) <= $limit || $results == '' || $limit === 0){
			echo dlinq_event_registration();
		} else {
			echo "The event is full.";
		}
}


//show registered people if you're an admin
function dlinq_registered_people(){
	if(current_user_can('edit_posts')){
		global $post;
		$post_id = $post->ID;
		$search_criteria = array(
			    'status'        => 'active',
			    'field_filters' => array(
			        'mode' => 'any',
			        array(
			            'key'   => '6',
			            'value' => $post_id
			        )
			    )
			);
	 
		// Getting the entries
		$results = GFAPI::get_entries( 5, $search_criteria );
		//var_dump($results);
		if($results){
			echo "<div class='registration-block'><h2>Registrations</h2><ol>";

			foreach ($results as $key => $result) {

				$entry_id = $result["id"];
				$created = $result["date_created"];
				$first = $result["1.3"];
				$last = $result["1.6"];
				$email = $result["3"];
				$attendance = $result["8"];
				$attend_class = ($attendance == 'No') ? '' : 'present';
				echo "<li class='reg'>
						<span class='reg-name'><a href='mailto:{$email}'>{$first} {$last}</a></span>						
						<span class='reg-date'>{$created}</span>
						<span class='reg-state'>attended: <button class='attend {$attend_class}' data-entry='{$entry_id}' data-state='{$attendance}'>{$attendance}</button></span>

					</li>";
			}
			echo "</ol></div>";
		}		

	}
	
}

function dlinq_set_attend($entry_id, $input_id, $value){
	if($value == 'Yes'){
		update_entry_field( $entry_id, $input_id, 'No' );
	} else {
		update_entry_field( $entry_id, $input_id, 'Yes' );
	}
	
}

function dlinq_event_resources(){
	if( have_rows('resources') ):
		$html = '';
	    // Loop through rows.
	    while( have_rows('resources') ) : the_row();

	        // Load sub field value.
	        $title = get_sub_field('resource_title');
	        $link = get_sub_field('resource_link');
	        $desc = get_sub_field('resource_description');
	        $html .= "
	        	<li>
	        		<a href='{$link}'>{$title}</a><br>
	        		{$desc}
	        	</li>
	        ";
	        // Do something...
	    // End loop.
	    endwhile;
	    return "<ul>{$html}</ul>";
		// No value.
		else :
		    // Do something...
		endif;
}




// register the ajax action for authenticated users
add_action('wp_ajax_dlinq_attendance_update', 'dlinq_attendance_update');
//add_action( 'wp_ajax_nopriv_dlinq_attendance_update', 'dlinq_attendance_update');
// handle the ajax request
function dlinq_attendance_update() {
    $entry_id = $_REQUEST['entry_id'];
    $entry_state = $_REQUEST['entry_state'];
    if($entry_state == 'No'){
    	$entry_state = 'Yes';
    } else {
    	$entry_state = 'No';
    }
    GFAPI::update_entry_field( $entry_id, '8', $entry_state, '' );
    // add your logic here...

    // in the end, returns success json data
    // wp_send_json_success([/* some data here */]);

    // // or, on error, return error json data
    // wp_send_json_error([/* some data here */]);
}

//provide future events as a drop down in the bulk enrollment form

add_filter( 'gform_pre_render_6', 'dlinq_populate_events' );
add_filter( 'gform_pre_validation_6', 'dlinq_populate_events' );
add_filter( 'gform_pre_submission_filter_6', 'dlinq_populate_events' );
add_filter( 'gform_admin_pre_render_6', 'dlinq_populate_events' );
function dlinq_populate_events( $form ) {
 
    foreach( $form['fields'] as &$field )  {
 
        //NOTE: replace 3 with your checkbox field id
        $field_id = 5;
        if ( $field->id != $field_id ) {
            continue;
        }
 
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        //CONSIDER USING THE TRIBES EVENT LOOP INSTEAD
        $posts = get_posts( 'numberposts=-1&post_status=publish&post_type=tribe_events&order=ASC&orderby=date' );
 
        $input_id = 1;
        foreach( $posts as $post ) {
 
            //skipping index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }
 			$date = tribe_get_start_date($post->ID);
            $choices[] = array( 'text' => $post->post_title . ' - ' . $date , 'value' => $post->ID );
            $inputs[] = array( 'label' => $post->post_title, 'id' => "{$field_id}.{$input_id}" );
 
            $input_id++;
        }
 
        $field->choices = $choices;
        $field->inputs = $inputs;
 
    }
 
    return $form;
}

//For bulk enrollment, loop FORM ID 6 and FIELD ID 5 to do an enrollment for each selection and put it in FORM ID 5
//NOTE THAT ALL THOSE IDS MIGHT CHANGE IN MIGRATION***********
add_action( 'gform_after_submission_6', 'after_submission_bulk_enroll', 10, 2 );
function after_submission_bulk_enroll( $entry, $form ) {
 	$first = rgar($entry, '1.3');
 	$last = rgar($entry, '1.6');
 	$email = rgar($entry, '3');
 	$events = rs_gf_get_checked_boxes( $entry, 5 );
 	//var_dump($events);
 	foreach ($events as $key => $event_id) {
 		$event_id = intval($event_id);
 		// code...
 		$event_name = get_the_title($event_id);
 		$zoom_link = get_field('zoom_link', $event_id);
 		$entry = array(
 			'form_id' => 5,
 			'1.3' => $first,
 			'1.6' => $last,
 			'3' => $email,
 			'5' => $event_name,
 			'6' => $event_id,
 			'8' => 'No',
 			'9' => $zoom_link
 		);
 		$new_entry = GFAPI::add_entry( $entry );
 		send_notifications(5, $new_entry );
 	}
}

//create code for deletion to put in gravity form
add_action( 'gform_save_field_value_5_11', 'dlinq_registration_deleter', 10, 4 );

function dlinq_registration_deleter( $value, $lead, $field, $form){
	return wp_generate_password(20,false,false);
}


function dlinq_check_to_delete(){
	if( 'tribe_events' == get_post_type()){
		if(isset($_GET["delete"])){
			$passcode= $_GET["delete"];
			$search_criteria = array(
			    'status'        => 'active',
			    'field_filters' => array(
			        'mode' => 'any',
			        array(
			            'key'   => '11',
			            'value' => $passcode
			        )
			    )
			);
			$entry = GFAPI::get_entries(5, $search_criteria);
			if(sizeof($entry)>0){
				$entry_id = $entry[0]['id'];
				GFAPI::delete_entry( $entry_id );//maybe we don't want to delete this?
			}			
		}
	}
}
add_action('wp_head','dlinq_check_to_delete');


//from https://gist.github.com/RadGH/d08a7466b097dfb895ec6dede2e474f5
/**
 * Return an array of checkboxes that have been checked on a Gravity Form entry.
 * Field keys are the input ID. For example "35.4", which means the 4th item of field #35.
 *
 * @param $entry
 * @param $field_id
 *
 * @return array
 */
function rs_gf_get_checked_boxes( $entry, $field_id ) {
	$items = array();
	
	$field_keys = array_keys( $entry );
	
	// Loop through every field of the entry in search of each checkbox belonging to this $field_id
	foreach ( $field_keys as $input_id ) {
		
		// Individual checkbox fields such as "14.1" belongs to field int(14)
		if ( is_numeric( $input_id ) && absint( $input_id ) == $field_id ) {
			$value = rgar( $entry, $input_id );
			
			// If checked, $value will be the value from the checkbox (not the label, though sometimes they are the same)
			// If unchecked, $value will be an empty string
			if ( "" !== $value ) $items[ $input_id ] = $value;
		}
		
	}
	
	return $items;
}

//from https://gist.github.com/keithdevon/08016bd065397c76045c
// send notifications
function send_notifications($form_id, $entry_id){

	// Get the array info for our forms and entries
	// that we need to send notifications for

	$form = RGFormsModel::get_form_meta($form_id);
	$entry = RGFormsModel::get_lead($entry_id);

	// Loop through all the notifications for the
	// form so we know which ones to send

	$notification_ids = array();

	foreach($form['notifications'] as $id => $info){

		array_push($notification_ids, $id);

	}

	// Send the notifications

	GFCommon::send_notifications($notification_ids, $form, $entry);

}

//new photo size
add_image_size('portrait', 300, 300, true);


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