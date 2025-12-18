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
	'/cpts.php',                    // Load custom post types
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
	if(get_field('project') != FALSE){
		echo "<div class='person-project-box'>";
		echo "<h2>Projects</h2><div class='person-projects'>";
		$projects = get_field('project');
		foreach($projects as $project){
			$post_id = $project->ID;
			$title = $project->post_title;
			$link = get_permalink( $post_id);
			$url_stem = get_template_directory_uri();
			$project_summary = get_field('project_summary', $post_id);
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
				<div class='project-summary'>{$project_summary}</div>
			</div>
			";
		}
		echo "</div></div>";
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
	          if( $args->theme_location == 'primary' ){

				    $newitems = '
				    	<li class="menu-item menu-item-type-post_type menu-item-object-tribe_events nav-item connect-li">
				    		<button type="button" class="connect" data-bs-toggle="modal" data-bs-target="#contactModal">
				    		Contact Us
				    		</button>
				    	</li>
				    	<li class="menu-item menu-item-type-post_type menu-item-object-tribe_events nav-item connect-li">
				    		<button type="button" class="connect search-icon" data-bs-toggle="modal" data-bs-target="#searchModal">
				    		Search
				    		</button>
				    	</li>
				    	';
				    $items .= $newitems;

					return $items;
				} else {
					return $items;
				}
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
				if($title != 'Home'){
						$link = get_the_permalink($ancestor);
						$parents .= "<span class='item-parent item-parent-{$ancestor}'>
										<a class='bread-parent bread-parent-{$ancestor}' href='{$link}' title='{$title}'>{$title}</a> &#187;
									</span>";
						$parents .= "<span class='separator separator-{$ancestor}'> </span>";

				}
				
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


//WORKSHOP
//SHOW RESOURCE ON WORKSHOP PAGE ****CONSIDER COMBINING with Event
function dlinq_workshop_resources(){
		$html = '';
		if( have_rows('resources') ):
		    echo  "<h2>Resources</h2>";
		    // Loop through rows.
		    while( have_rows('resources') ) : the_row();
	
		        // Load sub field value.
		        $title = get_sub_field('resource_title');
		        $link = get_sub_field('resource_link');
		        $desc = get_sub_field('resource_description');

		        $html .= "<div class='workshop-resource'>
		        <a href='{$link}'>
		        	<h3>{$title}</h3>
		        </a>
		        	<p>{$desc}</p>

		        </div>

		        ";
		        // Do something...
		    // End loop.
		    endwhile;
		    return $html;
			// No value.
			else :
			    // Do something...
			endif;
	
}


//add workshops dropdown to workshop form
add_action( 'acf/init', 'dlinq_workshop_form_loader' );
function dlinq_workshop_form_loader(){
	$gf_workshop_request_id = get_field('workshop_request_form', 'option');
	$pre_render = 'gform_pre_render_' . $gf_workshop_request_id;
	add_filter( 'gform_pre_render_' . $gf_workshop_request_id , 'populate_cpt_titles' );
	add_filter( 'gform_pre_validation_' . $gf_workshop_request_id,'populate_cpt_titles' );
	add_filter( 'gform_pre_submission_filter_' . $gf_workshop_request_id, 'populate_cpt_titles' );
	add_filter( 'gform_admin_pre_render_' . $gf_workshop_request_id, 'populate_cpt_titles' );

}

function populate_cpt_titles( $form ) {
	
	foreach ( $form['fields'] as &$field ) {
		if ( $field->id != 7 ) {
	    		continue;
		}

		$field->placeholder = 'Select a workshop';

		$args = [
			'posts_per_page'   => -1,
			'order'            => 'ASC',
			'orderby'          => 'post_title',
			'post_type'        => 'workshop', // Change this to your Custom Post Type
			'post_status'      => 'publish',
		];
		$custom_posts = get_posts( $args );

		$options = [];
		foreach( $custom_posts as $custom_post ) {
			$options[] = ['text' => $custom_post->post_title, 'value' => $custom_post->post_title];
		}

		$field->choices = $options;
	}

	return $form;
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

		foreach ( GFAPI::get_forms( true, false, 'title', 'ASC' ) as $form ) {
			//var_dump($form['title']);			
			$choices[ $form['id'] ] = $form['title'];
		}

		$field['choices'] = $choices;
	}

	return $field;
}

//DONT FORGET TO ADD ONE FOR EACH FORM FILTER OPTION YOU NEED TO BE DYNAMIC
add_filter( 'acf/load_field/name=form_id', 'acf_populate_gf_forms_ids' );
add_filter( 'acf/load_field/name=contact_gravity_form', 'acf_populate_gf_forms_ids' );
add_filter( 'acf/load_field/name=workshop_registration_form', 'acf_populate_gf_forms_ids' );
add_filter( 'acf/load_field/name=workshop_request_form', 'acf_populate_gf_forms_ids' );
add_filter( 'acf/load_field/name=workshop_bulk_request_form', 'acf_populate_gf_forms_ids' );

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
  //var_dump(get_the_terms($post->ID, 'tribe_events_cat' ));
  //var_dump(get_the_terms($post->ID, 'tribe_events_cat'));
  //var_dump(is_object_in_term( $post->ID, 'tribe_events_cat', 'no-registration' ));
  //var_dump(has_term('no-registration', 'tribe_events_cat',get_queried_object_id()));
  $terms = get_the_terms($post->ID, 'tribe_events_cat');
  
  if(dlinq_event_no_registration($terms, 'no-registration')){
  	echo "";
  }
  elseif( $past != TRUE && !dlinq_event_no_registration($terms, 'private')){
    echo "<button class='btn-dlinq btn-register-event' data-bs-toggle='modal' data-bs-target='#registrationModal'>Register</button>";
  } else {
  	echo "<div class='closed'><p>Registration is closed.</p></div>";
  }
}


function dlinq_event_no_registration($terms, $cat_slug){
	if($terms){
		foreach ($terms as $key => $term) {
			// code...
			if($term->slug === $cat_slug){
				return TRUE;
			}
		}
	} else {
		return FALSE;
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
function dlinq_registration_check($form_id){
		$limit = intval(get_field('attendance_limit'));
		global $post;
		$post_id = $post->ID;
		$total_count = 0;
		$sorting         = array();
		$paging          = array( 'offset' => 0, 'page_size' => 105 );
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
		$results = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging, $total_count );
		if(sizeof($results) <= $limit || $results == '' || $limit === 0){
			echo dlinq_event_registration();
		} else {
			echo "The event is full.";
		}
}



//show registered people if you're an admin
function dlinq_registered_people($form_id){
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
	 	$paging = array( 'offset' => 0, 'page_size' => 100 );

		// Getting the entries
		$results = GFAPI::get_entries( $form_id, $search_criteria, null, $paging );
		$total_reg =sizeof($results);
		$workshop_title = get_the_title($post_id);
		dlinq_set_registration_data($post_id, $total_reg, 'registered_total');//set total registered as custom field
		$workshop_feedback_template = get_field('workshop_feedback_template', 'option');
		if($results){
			$attendance_count = intval(0);
			echo "<div class='registration-block'>
					<h2>Registrations</h2>
					<div class='event-details'><span id='totalCame'></span> of <span id='totalReg'>{$total_reg}</span> attended</div>
					<button id='copy-emails' class='btn btn-dlinq'>Copy All Emails</button>
					<button id='feedback-email' class='btn btn-dlinq'>Copy Feedback Email</button>
					<div id='feedback-message' class='small-text'>
						{$workshop_feedback_template}				
					</div>
					<ol class='reg-list' id='registered'>";
			foreach ($results as $key => $result) {

				$key = $key+1;//flex display hides the numbers, this seemed easier than changing that
				$entry_id = $result["id"];
				$created = substr($result["date_created"], 0, 10);//get rid of the time
				$first = $result["1.3"];
				$last = $result["1.6"];
				$email = $result["3"];
				$attendance = $result["8"];
				$attendance_count = ($attendance === 'Yes') ? intval($attendance_count)+1 : $attendance_count;
				$attendance_options = [
										"No" => "no",
										"Yes" => "present",
										"Canceled" => "canceled"

										];
				//$attend_class = ($attendance === 'No') ? '' : 'present';
				$attend_class = strtolower($attendance_options[$attendance]);
				$event_title = get_the_title();
				$delete_key = $result["11"];
				//$nonce = wp_create_nonce('delete_reservation_' . $entry_id);
				$delete_link = get_permalink($post_id).'?delete='.$delete_key;
				echo "<li class='reg' data-email='{$email}'> {$key}. 
						<span class='reg-name'><a href='mailto:{$email}?subject={$event_title} workshop'>&nbsp;{$first} {$last}</a><div class='small-mail'>{$email}</div></span>
						<span class='delete'><a href='{$delete_link}'>💀delete💀</a></span>						
						<span class='reg-date'>{$created}</span>
						<span class='reg-state'>attended: <button class='attend {$attend_class}' data-entry='{$entry_id}' data-state='{$attendance}'>{$attendance}</button></span>						
					</li>";
			}
			echo "</ol></div>";
			dlinq_set_registration_data($post_id, $attendance_count, 'attended_total');//set total attended as custom field
            
		}		

	}
	
}

function dlinq_set_registration_data($post_id, $count, $field_name){
	$field_count = get_post_custom_values($field_name, $post_id);//get custom field value
	if($count != $field_count){
		update_post_meta( $post_id, $field_name, sanitize_text_field( $count ) );
	}
}

function dlinq_set_attend($entry_id, $input_id, $value){
	if($value == 'Yes'){
		update_entry_field( $entry_id, $input_id, 'No' );
	} else {
		update_entry_field( $entry_id, $input_id, 'Yes' );
	}
	
}

//SHOW RESOURCES ON EVENT PAGE
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
   
}

//provide future events as a drop down in the bulk enrollment form
//TODO SETUP BULK ENROLLMENT FORM --- GET BULK FORM ID!!!

add_action( 'acf/init', 'dlinq_bulk_workshop_form_loader' );
function dlinq_bulk_workshop_form_loader(){
	$gf_bulk_workshop_request_id = get_field('workshop_bulk_request_form', 'option');//get bulk form ID
	//var_dump($gf_bulk_workshop_request_id);
	$pre_render = 'gform_pre_render_' . $gf_bulk_workshop_request_id;
	add_filter( 'gform_pre_render_' . $gf_bulk_workshop_request_id , 'dlinq_populate_events_by_category' );
	add_filter( 'gform_pre_validation_' . $gf_bulk_workshop_request_id,'dlinq_populate_events_by_category' );
	add_filter( 'gform_pre_submission_filter_' . $gf_bulk_workshop_request_id, 'dlinq_populate_events_by_category' );
	add_filter( 'gform_admin_pre_render_' . $gf_bulk_workshop_request_id, 'dlinq_populate_events_by_category' );

}

function dlinq_populate_events( $form ) {
	//var_dump('events working');
    foreach( $form['fields'] as &$field )  {
 
        //NOTE: replace 5 with your checkbox field id
        $field_id = 5;
        if ( $field->id != $field_id ) {
            continue;
        }
 
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        //CONSIDER USING THE TRIBES EVENT LOOP INSTEAD
        // $posts = get_posts( 'numberposts=22&post_status=publish&post_type=tribe_events&order=ASC&orderby=date' );
 		$posts = tribe_get_events( [
			   'posts_per_page' => 10,
			   'tax_query' => array( // (array) - use taxonomy parameters (available with Version 3.1).
				    'relation' => 'AND', // (string) - The logical relationship between each inner taxonomy array when there is more than one. Possible values are 'AND', 'OR'. Do not use with a single inner taxonomy array. Default value is 'AND'.
				    array(
				      'taxonomy' => 'tribe_events_cat', // (string) - Taxonomy.
				      'field' => 'slug', // (string) - Select taxonomy term by Possible values are 'term_id', 'name', 'slug' or 'term_taxonomy_id'. Default value is 'term_id'.
				      'terms' => array( 'bulk' ), // (int/string/array) - Taxonomy term(s).
				      'operator' => 'IN' // (string) - Operator to test. Possible values are 'IN', 'NOT IN', 'AND', 'EXISTS' and 'NOT EXISTS'. Default value is 'IN'.
				    ),	
				)		   
			] );

        $input_id = 1;
        foreach( $posts as $post ) {
			//write_log($post->ID);
			//$terms = get_the_terms($post->ID, 'tribe_events_cat');
			//write_log($terms);
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

// Enhanced function to populate events by category using CSS classes
function dlinq_populate_events_by_category( $form ) {
    foreach( $form['fields'] as &$field )  {
        
        // Skip if not a checkbox field or if no CSS class set
        if ( $field->type !== 'checkbox' || empty($field->cssClass) ) {
            continue;
        }
        
        // Parse CSS class for category configuration
        // Expected format: "events-category-bulk" or "events-category-workshop,training"
        if ( !preg_match('/events-category-(.+)/', $field->cssClass, $matches) ) {
            continue;
        }
        
        $categories = explode(',', $matches[1]);
        $categories = array_map('trim', $categories);
        
        // Get events for the specified categories
        $posts = tribe_get_events( [
            'posts_per_page' => -1,
            'eventDisplay' => 'upcoming',
            'tax_query' => array(
                array(
                    'taxonomy' => 'tribe_events_cat',
                    'field' => 'slug',
                    'terms' => $categories,
                    'operator' => 'IN'
                ),
            )
        ] );

        $choices = [];
        $inputs = [];
        $input_id = 1;
        
        foreach( $posts as $post ) {
            // Skip index that are multiples of 10 (multiples of 10 create problems as the input IDs)
            if ( $input_id % 10 == 0 ) {
                $input_id++;
            }
            
            $date = tribe_get_start_date($post->ID);
            $categories_list = wp_get_post_terms($post->ID, 'tribe_events_cat', array('fields' => 'names'));
            $categories_str = !empty($categories_list) ? ' (' . implode(', ', $categories_list) . ')' : '';
            
            $choices[] = array( 
                'text' => $post->post_title . ' - ' . $date . $categories_str, 
                'value' => $post->ID 
            );
            $inputs[] = array( 
                'label' => $post->post_title, 
                'id' => "{$field->id}.{$input_id}" 
            );

            $input_id++;
        }
        
        $field->choices = $choices;
        $field->inputs = $inputs;
    }
 
    return $form;
}



add_action( 'acf/init', 'dlinq_workshop_event_subscription' );

//TO DO ACTIVATE BULK ENROLLMENT FORM CHOICE IN ************************
function dlinq_workshop_event_subscription(){
	$gf_bulk_workshop_request_id = get_field('workshop_bulk_request_form', 'option');
	//write_log('ACF bulk request form ID = ' . $gf_bulk_workshop_request_id);
	
	if ( $gf_bulk_workshop_request_id && is_numeric( $gf_bulk_workshop_request_id ) ) {
		$hook_name = 'gform_after_submission_' . $gf_bulk_workshop_request_id;
		//write_log('Adding action hook: ' . $hook_name);
		add_action( $hook_name, 'after_submission_bulk_enroll', 10, 2 );
	} else {
		//write_log('ERROR: Invalid bulk workshop request form ID');
	}
}

// Alternative registration method - registers for ALL forms and checks form ID inside
// DISABLED - Using specific form hook instead to avoid double processing
// add_action( 'gform_after_submission', 'dlinq_check_bulk_enrollment_submission', 10, 2 );
function dlinq_check_bulk_enrollment_submission( $entry, $form ) {
	$gf_bulk_workshop_request_id = get_field('workshop_bulk_request_form', 'option');
	
	//write_log('Form submitted - Form ID: ' . $form['id'] . ', Expected bulk form ID: ' . $gf_bulk_workshop_request_id);
	
	// Check if this is the bulk enrollment form
	if ( $form['id'] == $gf_bulk_workshop_request_id ) {
		//write_log('This is the bulk enrollment form - calling after_submission_bulk_enroll');
		after_submission_bulk_enroll( $entry, $form );
	}
}
function after_submission_bulk_enroll( $entry, $form ) {
	//write_log('bulk after submission ran');
	//write_log($entry);
	// Debug: Log all form fields and their types
	//write_log('=== FORM FIELDS DEBUG ===');
	
	// Debug: Log all entry data
	//write_log('=== ENTRY DATA DEBUG ===');
	//write_log($entry);
	
	// Debug: Log $_POST data to see what was actually submitted
	//write_log('=== POST DATA DEBUG ===');
	//write_log($_POST);
	
	$gf_workshop_registration_id = get_field('workshop_registration_form', 'option');
 	$first = rgar($entry, '1.3');
 	$last = rgar($entry, '1.6');
 	$email = rgar($entry, '2');//change to match with 2025 summer form shift!!!!!
 	
 	// Get all event IDs from all event category fields in the form
 	//write_log('About to call dlinq_get_all_event_ids_from_form');
 	$all_event_ids = dlinq_get_all_event_ids_from_form( $entry, $form );
 	
 	//write_log('Returned from dlinq_get_all_event_ids_from_form - All selected events: ');
 	//write_log($all_event_ids);
 	
 	// If no events found, try the old method as fallback
 	if ( empty( $all_event_ids ) ) {
 		//write_log('No events found with new method, trying old method...');
 		
 		// Try to get events from field ID 5 (the old hard-coded field)
 		$old_events = rs_gf_get_checked_boxes( $entry, 5 );
 		//write_log('Old method events from field 5:');
 		//write_log($old_events);
 		
 		// Try to find any checkbox fields and get their values
 		foreach ( $form['fields'] as $field ) {
 			if ( $field->type === 'checkbox' ) {
 				$checkbox_events = rs_gf_get_checked_boxes( $entry, $field->id );
 				//write_log('Checkbox field ' . $field->id . ' events:');
 				//write_log($checkbox_events);
 				
 				if ( !empty( $checkbox_events ) ) {
 					$all_event_ids = array_merge( $all_event_ids, array_values( $checkbox_events ) );
 				}
 			}
 		}
 	}
 	
 	//write_log('Final event IDs to process:');
 	//write_log($all_event_ids);
 	
 	foreach ($all_event_ids as $event_id) {
 		$event_id = intval($event_id);
 		//write_log('Processing event ID: ' . $event_id);
 		
 		$event_name = get_the_title($event_id);
 		$zoom_link = get_field('zoom_link', $event_id);
 		$entry_data = array(
 			'form_id' =>  $gf_workshop_registration_id,
 			'1.3' => $first,
 			'1.6' => $last,
 			'3' => $email,
 			'5' => $event_name,
 			'6' => $event_id,
 			'8' => 'No',
 			'9' => $zoom_link
 		);
 		$new_entry = GFAPI::add_entry( $entry_data );
 		//send_notifications( $gf_workshop_registration_id, $new_entry );//can send per event but might be messier
		//JUST SEND THE SINGLE MESSAGE ON THE BULK FORM
 	}
}

/**
 * Get all event IDs from all event category fields in a form submission
 * 
 * @param array $entry The Gravity Forms entry
 * @param array $form The Gravity Forms form object
 * @return array Array of unique event IDs
 */
function dlinq_get_all_event_ids_from_form( $entry, $form ) {
    $all_event_ids = array();
    
    //write_log('=== GETTING ALL EVENT IDS FROM FORM ===');
    
    // Loop through all form fields
    foreach ( $form['fields'] as $field ) {
        //write_log('Processing field ID: ' . $field->id . ', Type: ' . $field->type);
        
        // Check if this is an event categories field (our custom field type)
        if ( $field->type === 'event_categories' ) {
            $field_id = $field->id;
            
            // Get selected values for this field
            $selected_events = dlinq_get_event_ids_from_field( $entry, $field_id );
            
            //write_log('Field ' . $field_id . ' (event_categories) returned events: ' . implode(', ', $selected_events));
            
            // Merge with all event IDs
            $all_event_ids = array_merge( $all_event_ids, $selected_events );
        }
        
        // Also check for regular checkbox fields with events-category CSS class (backward compatibility)
        elseif ( $field->type === 'checkbox' && !empty( $field->cssClass ) && strpos( $field->cssClass, 'events-category-' ) !== false ) {
            $field_id = $field->id;
            
            // Get selected values for this field using the existing function
            $selected_events = rs_gf_get_checked_boxes( $entry, $field_id );
            
            //write_log('Field ' . $field_id . ' (checkbox with events-category CSS) returned events: ' . implode(', ', array_values($selected_events)));
            
            // Add the values (event IDs) to our array
            $all_event_ids = array_merge( $all_event_ids, array_values( $selected_events ) );
        }
    }
    
    //write_log('All collected event IDs before deduplication: ' . implode(', ', $all_event_ids));
    
    // Remove duplicates and return
    $final_event_ids = array_unique( array_filter( $all_event_ids ) );
    
    //write_log('Final deduplicated event IDs: ' . implode(', ', $final_event_ids));
    
    return $final_event_ids;
}

/**
 * Get event IDs from a single event categories field
 * 
 * @param array $entry The Gravity Forms entry
 * @param int $field_id The field ID
 * @return array Array of event IDs from this field
 */
function dlinq_get_event_ids_from_field( $entry, $field_id ) {
    $event_ids = array();
    
    //write_log("Getting event IDs from field $field_id");
    //write_log("Available entry keys for field $field_id: " . implode(', ', array_filter(array_keys($entry), function($key) use ($field_id) { return strpos($key, $field_id . '.') === 0; })));
    
    // First check if there's a direct value (custom field might store as single value)
    if ( isset( $entry[ $field_id ] ) && !empty( $entry[ $field_id ] ) ) {
        //write_log("Found direct value for field $field_id: " . $entry[ $field_id ]);
        
        // If it's a comma-separated string, split it
        if ( strpos( $entry[ $field_id ], ',' ) !== false ) {
            $event_ids = explode( ',', $entry[ $field_id ] );
        } else {
            $event_ids[] = $entry[ $field_id ];
        }
    } else {
        // Check for checkbox-style inputs (field_id.input_id format)
        foreach ( $entry as $key => $value ) {
            // Look for keys that start with field_id. and have a value
            if ( strpos( $key, $field_id . '.' ) === 0 && !empty( $value ) ) {
                //write_log("Found checkbox input $key: " . $value);
                $event_ids[] = $value;
            }
        }
    }
    
    // Clean up the array
    $event_ids = array_filter( array_map( 'trim', $event_ids ) );
    
    //write_log("Final event IDs from field $field_id:");
    //write_log($event_ids);
    
    return $event_ids;
}


//create code for deletion to put in gravity form
add_action( 'acf/init', 'dlinq_workshop_event_deletion' );

function dlinq_workshop_event_deletion(){
	$gf_workshop_registration_id = get_field('workshop_registration_form', 'option');
	$form =  'gform_save_field_value_'. $gf_workshop_registration_id . '_11';
	add_action($form, 'dlinq_registration_delete_code', 10, 4);
}

function dlinq_registration_delete_code( $value, $lead, $field, $form){
	return wp_generate_password(20,false,false);
}


function dlinq_check_to_delete(){
	$gf_workshop_registration_id = get_field('workshop_registration_form', 'option');
	if( 'tribe_events' == get_post_type()){
		if(isset($_GET["delete"]) && isset($_GET["confirmed"]) ){
			$passcode = $_GET["delete"];
			$humanOk = $_GET['confirmed'];
			
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
			$entry = GFAPI::get_entries($gf_workshop_registration_id, $search_criteria);
			if(sizeof($entry)>0 && $humanOk != NULL){
				$entry_id = $entry[0]['id'];
				
				// Verify nonce before processing deletion
					GFAPI::update_entry_field($entry_id, 8,'Canceled');			
					//GFAPI::delete_entry( $entry_id );//turns out we don't want to delete this. mark as canceled instead

					echo "<div class='notification delete-alert'>You have removed your reservation. Thank you.</div>";
				} else {
					echo "<div class='notification error-alert'>Invalid security token. Please try again.</div>";
				}
						
		}
	}
}
add_action('wp_head','dlinq_check_to_delete');

//set the cron to run reminder emails function
if ( ! wp_next_scheduled( 'dlinq_reminder_email' ) ) {
    //wp_schedule_event( strtotime('14:58:00'), 'daily', 'dlinq_reminder_email' );
    wp_schedule_event( strtotime('08:00:00'), 'daily', 'dlinq_reminder_email' );

}

add_action( 'dlinq_reminder_email', 'dlinq_reminder_email' );

function dlinq_reminder_email(){
	write_log(__LINE__);
	//get the reservation form ID from the ACF options field
	$gf_workshop_registration_id = get_field('workshop_registration_form', 'option');

	//get current date and add 86400 seconds
	$tomorrow = date("Y-m-d", time() + 86400);
	$start = $tomorrow . ' 00:01';
	$end = $tomorrow . ' 23:59';

	//get Modern Tribe events that occur on current date +24 hrs from the events calendar
	$coming_events = tribe_get_events( [
					   'start_date'   => $start,
					   'end_date'   => $end,
					] );
	write_log($coming_events);
	$event_ids = [];
	if($coming_events){		
		foreach ($coming_events as $key => $event) {		
				array_push($event_ids, $event->ID);
		}
	}

	//if we have event ids, lets get our dear registrants
	if($event_ids){
		foreach ($event_ids as $key => $event_id) {
			//get the reservations from Gravity forms
			$search_criteria = array(
					    'status'        => 'active',
					    'field_filters' => array(
					        'mode' => 'any',
					        array(
					            'key'   => '6',
					            'value' => $event_id
					        )
					    )
					);
			$event_name = get_the_title($event_id);//get title from the event
			$event_date = tribe_events_event_schedule_details( $event_id);
			$clean_date = preg_replace('/<[^>]*>/', '', $event_date);
			$location = dlinq_event_email_location($event_id);
			
			$reservations = GFAPI::get_entries($gf_workshop_registration_id, $search_criteria);
			//var_dump($reservations);
			foreach ($reservations as $key => $reservation) {
				// code...
				$to_email = $reservation[3];
				$delete_key = $reservation[11];
				$entry_id = $reservation['id'];
				//$nonce = wp_create_nonce('delete_reservation_' . $entry_id);
				$delete_url = get_permalink($event_id).'?delete='.$delete_key;
				$delete_block = "<p>Use this link to cancel your reservation <a href='{$delete_url}'>{$delete_url}</a></p>";		
				dlinq_send_reminder_email($to_email, $event_name, $clean_date, $location, $delete_block);
			}
		}		
	}	

}


function dlinq_send_reminder_email($to_email, $event_name, $event_date, $location, $delete_block){
	$to = $to_email;
	$subject = "Reminder: You registered for {$event_name} on {$event_date}";
	$headers = array('Content-Type: text/html; charset=UTF-8','From: DLINQ <dlinq@middlebury.edu>');	
	$message = 'We look forward to seeing you! ' . $location . $delete_block;
	//var_dump($message);
	wp_mail( $to, $subject, $message, $headers);
}

function dlinq_event_email_location($event_id){
	$location = '';
	if(get_field('zoom_link',$event_id)){
		$zoom_link = get_field('zoom_link',$event_id);
		$location = "<br><br><p>Online at:</p><br><a href='{$zoom_link}'>{$zoom_link}</a>";
	} if (strlen(tribe_get_full_address($event_id)) > 45 ) {		
		$location .= "<br><br><p>In person at:</p><br>" . tribe_get_full_address($event_id);		
	}
	return $location;
}

//
//event feedback email 
//

function dlinq_send_feedback_email($to_email, $event_name){
	$clean_title = urlencode_deep($event_name);
	$url ="https://dlinq.middcreate.net/workshop-feedback/?Workshop={$clean_title}";
	$to = $to_email;
	$subject = "{$event_name} Feedback Request";
	$headers = array('Content-Type: text/html; charset=UTF-8','From: DLINQ <dlinq@middlebury.edu>');	
	$message = "<p>Thank you for attending {$event_name}.</p>
		<p>We would greatly appreciate it if <a href='{$url}'>you'd fill out this brief survey</a> to give us feedback on your experience so we can continue to improve our offerings.</p>
	";
	wp_mail( $to, $subject, $message, $headers);
}

//set the cron to run reminder emails function
if ( ! wp_next_scheduled( 'send_dlinq_feedback_email' ) ) {
    wp_schedule_event( strtotime('08:00:00'), 'daily', 'send_dlinq_feedback_email' );
}

add_action( 'send_dlinq_feedback_email', 'dlinq_feedback_email' );

function dlinq_feedback_email(){
	//get the reservation form ID from the ACF options field
	$gf_workshop_registration_id = get_field('workshop_registration_form', 'option');

	//get current date and add remove 86400 seconds to get yesterday
	$yesterday = date("Y-m-d", time() - 86400);
	$start = $yesterday . ' 00:01';
	$end = $yesterday . ' 23:59';
	//get Modern Tribe events that occur on current date +24 hrs from the events calendar
	$coming_events = tribe_get_events( [
					   'start_date'   => $start,
					   'end_date'   => $end,
					] );
	$event_ids = [];
	//write_log($event_ids);
	if($coming_events){		
		foreach ($coming_events as $key => $event) {		
				array_push($event_ids, $event->ID);
		}
	}

	//if we have event ids, lets get our dear registrants
	if($event_ids){
		foreach ($event_ids as $key => $event_id) {
			//get the reservations from Gravity forms
			$search_criteria = array(
					    'status'        => 'active',
					    'field_filters' => array(
					        'mode' => 'any',
					        array(
					            'key'   => '6',
					            'value' => $event_id
					        )
					    )
					);
			$event_name = get_the_title($event_id);//get title from the event
			$event_date = tribe_events_event_schedule_details( $event_id);
			$clean_date = preg_replace('/<[^>]*>/', '', $event_date);
			//$location = dlinq_event_email_location($event_id);
			
			$reservations = GFAPI::get_entries($gf_workshop_registration_id, $search_criteria);
			//var_dump($reservations);
			foreach ($reservations as $key => $reservation) {
				// code...
				$to_email = $reservation[3];
				dlinq_send_feedback_email($to_email, $event_name);
				usleep(250000);
			}
		}		
	}	
return 'done';
}

add_shortcode( 'feedback', 'dlinq_feedback_email' );



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

function dlinq_event_modality(){
	$modality = get_field('modality');
	$stem = "This event is held ";
	if(isset($modality[0])){
		if(sizeof($modality)>1){
			echo $stem . dlinq_zoom_lang($modality[0]) . ' and ' .  dlinq_zoom_lang($modality[1]);
		} else {
			echo $stem . dlinq_zoom_lang($modality[0]);
		}

	}
	
}

function dlinq_zoom_lang($modality){
	if($modality == 'Zoom'){
		return ' online via Zoom';
	} else {
		return $modality;
	}
}

//new photo size
add_image_size('portrait', 300, 300, true);



add_action('wp_dashboard_setup', 'dlinq_custom_dashboard_widgets');
  
function dlinq_custom_dashboard_widgets() {
  global $wp_meta_boxes;
  wp_add_dashboard_widget('custom_dlinq_widget', '<h1>Shortcuts</h1>', 'dlinq_custom_dashboard_posts');
  }
 
function dlinq_custom_dashboard_posts() {
    echo "
    	<a class='dash-btn' href='post-new.php?post_type=page'>Pages</a>: for core elements. Use the focus full width template.<br>
    	<a class='dash-btn' href='post-new.php?post_type=topic'>Topics</a>: for all the other static stuff.<br>
    	<a class='dash-btn' href='post-new.php?post_type=project'>Projects</a>: for projects.<br>
    	<a class='dash-btn' href='post-new.php?post_type=person'>People</a>: for people.<br>
    	<a class='dash-btn' href='post-new.php?post_type=workshop'>Workshop</a>: for the catalog of workshops. Use events for workshops with dates.<br>
    ";
   
}
/*
  Disable Default Dashboard Widgets
  @ https://digwp.com/2014/02/disable-default-dashboard-widgets/
*/
function dlinq_disable_default_dashboard_widgets() {
  global $wp_meta_boxes;
  // wp..
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
 
  // bbpress
  unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
  // yoast seo
  unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
  // gravity forms
  unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
  //events calendar 
  unset($wp_meta_boxes['dashboard']['normal']['core']['tribe_dashboard_widget']);
  //limit logins llar_stats_widget 
  unset($wp_meta_boxes['dashboard']['normal']['high']['llar_stats_widget']);
  //WP Mail SMTP  
  unset($wp_meta_boxes['dashboard']['normal']['core']['wp_mail_smtp_reports_widget_lite']);
}
add_action('wp_dashboard_setup', 'dlinq_disable_default_dashboard_widgets', 999);


//CLEAN VIEW

function dlinq_clean_sidebar(){
  $messy_users = [];
  if(get_field('messy_view', 'options')){
  	  $messy_users = get_field('messy_view', 'options');
  }
  $current_user_id = get_current_user_id();

  $messy = in_array($current_user_id,$messy_users, false);
  if($messy != true){
  	  remove_menu_page( 'index.php' );                  //Dashboard
	  remove_menu_page( 'comments' );                    //Jetpack* 
	  remove_menu_page( 'options-general.php' );        //Settings
	  remove_menu_page( 'themes.php' );        //appearance
	  remove_menu_page( 'users.php' );        //users
	  remove_menu_page( 'plugins.php' );        //plugins
	  remove_menu_page( 'tools.php' );        //tools
	  remove_menu_page( 'upload.php' );        //media
	  remove_menu_page( 'edit.php?post_type=acf-field-group' ); //acf
	  remove_menu_page('limit-login-attempts'); //limit logins
	  remove_menu_page('wp-mail-smtp'); //WP Mail SMTP
  }

}
// add_action( 'admin_init', function () {
//     echo '<pre>' . print_r( $GLOBALS[ 'menu' ], true) . '</pre>';
// } );

add_action( 'admin_init', 'dlinq_clean_sidebar', 999 );
 
//ajax search
add_filter( 'relevanssi_live_search_base_styles', '__return_false' );


//Add CPTS to category archive

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('post','workshop','project');
    $query->set('post_type',$post_type);
    return $query;
    }
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

function dlinq_workshop_registration_updater($post_id){
	$form_id = get_field('workshop_registration_form', 'option');
	if(current_user_can('edit_posts')){	
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
	 	$paging = array( 'offset' => 0, 'page_size' => 100 );

		// Getting the entries
		$results = GFAPI::get_entries( $form_id, $search_criteria, null, $paging );
		$total_reg =sizeof($results);
		dlinq_set_registration_data($post_id, $total_reg, 'registered_total');//set total registered as custom field
		$attendance_count = intval(0);
		if($results){			
			
			foreach ($results as $key => $result) {
				//var_dump($result[8]);
				if($result[8]=== "Yes"){
					$attendance_count = $attendance_count+1;//flex display hides the numbers, this seemed easier than changing that	
				}
				
			}
		}		
		dlinq_set_registration_data($post_id, $attendance_count, 'attended_total');//set total attended as custom field

	}
	
}

// add new buttons
// add_filter( 'mce_buttons', 'myplugin_register_buttons' );

// function myplugin_register_buttons( $buttons ) {
//    array_push( $buttons, 'separator', 'myplugin' );
//    return $buttons;
// }
 
// // Load the TinyMCE plugin : editor_plugin.js (wp2.5)
// add_filter( 'mce_external_plugins', 'myplugin_register_tinymce_javascript' );

// function myplugin_register_tinymce_javascript( $plugin_array ) {
//    $plugin_array['myplugin'] = plugins_url( '/js/tinymce-plugin.js',__FILE__ );
//    return $plugin_array;
// }



//WORKSHOP REPORTS
function dlinq_workshop_report(){
	
	//get current date and add 86400 seconds
	$current_year = 2025;
	$start = $current_year . '-06-31 00:01';
	$end = ($current_year+1) . '-06-31 23:59';

	//get Modern Tribe events that occur on current date +24 hrs from the events calendar
	$year_events = tribe_get_events( [
					   'posts_per_page' => 100,
					   'start_date'   => $start,
					   'end_date'   => $end,
					   'post_status', array('private', 'publish'),
					   'meta_query' => array(
							'relation' => 'AND',
							array(
								'key'     => '_EventHideFromUpcoming',
								'compare' => '=',  // "NOT EXIST" might work, though this makes more logical sense to me
								'value' => 'yes',
							),
							array(
								'key'     => '_EventHideFromUpcoming',
								'compare' => 'NOT EXIST',
							),
						),
					] );
	if($year_events){		
		foreach ($year_events as $key => $event) {		
				
				$event_title = $event->post_title;//get title from the event
				$event_id = $event->ID;
				dlinq_workshop_registration_updater($event_id);//update the stuff
				$link = get_permalink($event_id);
				$event_date = tribe_events_event_schedule_details( $event_id);
				$clean_date = preg_replace('/<[^>]*>/', '', $event_date);
				$registered = get_post_meta($event_id, 'registered_total', TRUE);
				if(get_post_meta($event_id, 'attended_total', TRUE) !==''){
					$attended = get_post_meta($event_id, 'attended_total', TRUE);
				} else {
					$attended = 0;
				}
				if(get_field('classroom_attendance_number',$event_id)){
					$attendance = get_field('classroom_attendance_number',$event_id);
					$registered = 'N/A';
					$attended = $attendance;
				}
				//may need to run the function that sets the reg and attended prior to display per post. .. worry about load though
				echo "<tr>
						<td><a href='{$link}'>{$event_title}</a></td>
						<td>{$clean_date}</td>
						<td>{$registered}</td>
						<td>{$attended}</td>
					</tr>";
		}
	}
			
}

add_shortcode( 'test', 'dlinq_reminder_email' );

//keep events in the private category from showing in calendar views
add_filter( 'tribe_events_views_v2_view_repository_args', 'dlinq_exclude_events_category', 10, 3 );
 
function dlinq_exclude_events_category( $repository_args, $context, $view ) {
    // List of category slugs to be excluded
    $excluded_categories = [
        'private',
    ];
    $repository_args['category_not_in'] = $excluded_categories;
 
    return $repository_args;
}

/*POLICY SPECIFIC*/

function dlinq_last_edit($post_id = NULL){
	$date = get_the_modified_date($post_id);
	return $date;
}

function dlinq_acf_maker($field_name){
	if(get_field($field_name)){		
        $field_obj = get_field_object($field_name);
        $id = $field_obj['name'];
        $field_title =  $field_obj['label'];
        $field_text = $field_obj['value']; 
        //var_dump($field_obj);        
        return "<div class='topic-row row'>
					<div class='col-md-8 offset-md-2'>
						<h2 id='{$id}'>{$field_title}</h2>
        				<div class='policy-content'>{$field_text}</div>
        			</div>
        		</div>";
    } 
}



function dlinq_acf_policies(){
	$html = '';
	if(get_field('related_internal_policies')){
		$internal = get_field('related_internal_policies');
		foreach ($internal as $key => $value) {
			$title = $value->post_title;
			$url = get_permalink($value->ID);
			$html .= "<li><a href='{$url}'>{$title}</a></li>";	
		}
	}
	if(have_rows('related_external_policies')){
		 while( have_rows('related_external_policies') ) : the_row();

	        // Load sub field value.
	        $title = get_sub_field('policy_title');
	        $url = get_sub_field('policy_link');
	        $html .= "<li><a href='{$url}'>{$title}</a></li>";	
	        // Do something...
	    // End loop.
	    endwhile;
	}
	if($html != ''){
		return "<h2 id='related-policies'>Related forms and information</h2><ul>{$html}</ul>";
	}
}

function dlinq_policy_review_date(){
	if(get_field('next_review_date')){
		return get_field('next_review_date');
	} else {
		return 'TBD';
	}
}

function dlinq_policy_definitions(){
	$html = '';
	$definitions = get_field('definitions');
	if($definitions != ''){
		$html = "<div class='topic-row row'>
					<div class='col-md-5 offset-md-2'>
						<h2 id='definitions'>Definitions</h2>";
	
		$posts = get_posts(array(
		 'post__in' => $definitions,
		 'post_type' => 'definition',
		 'posts_per_page' => -1,
		 'post_status' => 'publish',
		 'order' => 'ASC',
		 'orderby' => 'title'		 
		));
		foreach ($posts as $key => $post) {
			// code...
			$the_content = apply_filters('the_content', $post->post_content);
			$title = $post->post_title;
			$html .= "<div class='definition'>
						<h3 class='term'>{$title}</h3>
						{$the_content}
					</div>";
		}
	}
	return $html ."</div></div>";
}


function dlinq_policy_changes(){
	$html = '';
	$canges = get_field('summary_of_changes');
	if( have_rows('summary_of_changes') ):
		$html = "<div class='topic-row row'>
					<div class='col-md-5 offset-md-2'>
						<h2 id='definitions'>Summary of changes</h2>";
	    // Loop through rows.
	    while( have_rows('summary_of_changes') ) : the_row();

	        // Load sub field value.
	        $date = get_sub_field('change_date');
	        $summary = get_sub_field('change_summary');
	        $html .= "
	        		<div class='change-event'>
	        			<h3>{$date}</h3>
	        			{$summary}
	        		</div>
	        ";
	        // Do something...
	    // End loop.
	    endwhile;
	    return $html . "</div></div>";
		// No value.
		else :
		    // Do something...
		endif;
		
}



/**
 * Custom Gravity Forms Field for Event Calendar Pro Events by Category
 * 
 * Form builders select event categories in the field settings.
 * Form users see events from those categories as checkboxes.
 */
if ( class_exists( 'GF_Field' ) ) {

    class GF_Field_Event_Categories extends GF_Field {
        
        public $type = 'event_categories';
        
        /**
         * Return the field title for the form editor
         */
        public function get_form_editor_field_title() {
            return esc_attr__( 'Events by Category', 'gravityforms' );
        }
        
        /**
         * Define which group this field belongs to in the form editor
         */
        public function get_form_editor_button() {
            return array(
                'group' => 'advanced_fields',
                'text'  => $this->get_form_editor_field_title(),
            );
        }
        
        /**
         * Define which settings are available for this field
         */
        public function get_form_editor_field_settings() {
            return array(
                'conditional_logic_field_setting',
                'prepopulate_field_setting',
                'error_message_setting',
                'label_setting',
                'admin_label_setting',
                'rules_setting',
                'visibility_setting',
                'duplicate_setting',
                'description_setting',
                'css_class_setting',
                'required_setting',
                'event_categories_setting' // Custom setting for category selection
            );
        }
        
        /**
         * Define if this field supports conditional logic
         */
        public function is_conditional_logic_supported() {
            return true;
        }
        
        /**
         * Render the field input on the frontend
         */
        public function get_field_input( $form, $value = '', $entry = null ) {
            $form_id         = absint( $form['id'] );
            $is_entry_detail = $this->is_entry_detail();
            $is_form_editor  = $this->is_form_editor();
            
            $id = $this->id;
            
            // In form editor, show placeholder
            if ( $is_form_editor ) {
                $selected_categories = !empty( $this->selectedCategories ) ? $this->selectedCategories : array();
                if ( empty( $selected_categories ) ) {
                    return '<div class="ginput_container"><div style="padding: 10px; border: 1px dashed #ccc; background: #f9f9f9;">Select event categories in field settings to display events here.</div></div>';
                } else {
                    $category_names = $this->get_category_names( $selected_categories );
                    return '<div class="ginput_container"><div style="padding: 10px; border: 1px dashed #ccc; background: #f9f9f9;">Events from categories: ' . implode( ', ', $category_names ) . ' will appear here.</div></div>';
                }
            }
            
            // Get events from selected categories
            $events = $this->get_events_by_categories();
            
            // Debug logging
            //error_log('Event Categories Field ID ' . $id . ' - Found ' . count($events) . ' events');
            //error_log('Selected categories: ' . print_r($this->selectedCategories, true));
            
            if ( empty( $events ) ) {
                return '<div class="ginput_container"><div>No events found in the selected categories.</div></div>';
            }
            
            // Prepare values array
            $selected_values = array();
            if ( !empty( $value ) ) {
                $selected_values = is_array( $value ) ? $value : explode( ',', $value );
            }
            
            // Build CSS classes for fieldset
            $field_classes = array(
                'gfield',
                'gfield--type-checkbox',
                'gfield--type-choice',
                'gfield--input-type-checkbox',
                'gfield--width-full',
                'field_sublabel_below',
                'gfield--no-description',
                'field_description_below',
                'field_validation_below',
                'gfield_visibility_visible'
            );
            
            // Add custom CSS class if specified
            if ( !empty( $this->cssClass ) ) {
                $field_classes[] = esc_attr( $this->cssClass );
            }
            
            // Add error class if validation failed
            if ( $this->failed_validation ) {
                $field_classes[] = 'gfield_error';
            }
            
            // Add required class if field is required
            if ( $this->isRequired ) {
                $field_classes[] = 'gfield_contains_required';
            }
            
            $fieldset_classes = implode( ' ', $field_classes );
            
            // Start fieldset
            $output = '<fieldset id="field_' . $form_id . '_' . $id . '" class="' . $fieldset_classes . '">';
            
            // No legend - let Gravity Forms handle the label and description placement
            
            // Build checkboxes
            $output .= '<div class="ginput_container ginput_container_checkbox">';
            $output .= '<div class="gfield_checkbox" id="input_' . $form_id . '_' . $id . '">';
            
            $input_id = 1;
            foreach ( $events as $event ) {
                $event_id = $event->ID;
                $event_title = esc_html( get_the_title( $event_id ) );
                $event_date = $this->get_event_date( $event_id );
                $event_categories = $this->get_event_category_names( $event_id );
                
                $field_id = $form_id . '_' . $id . '_' . $input_id;
                $is_checked = in_array( $event_id, $selected_values ) ? 'checked="checked"' : '';
                
                // Build label text with event title, date, and categories
                $label_text = $event_title;
                if ( $event_date ) {
                    $label_text .= ' - ' . $event_date;
                }
                // if ( !empty( $event_categories ) ) {
                //     $label_text .= ' (' . implode( ', ', $event_categories ) . ')';
                // }
                
                $output .= '<div class="gchoice gchoice_' . $field_id . '">';
                $output .= '<input class="gfield-choice-input" name="input_' . $id . '.' . $input_id . '" type="checkbox" value="' . $event_id . '" id="choice_' . $field_id . '" ' . $is_checked . ' />';
                $output .= '<label for="choice_' . $field_id . '" id="label_' . $field_id . '" class="gform-field-label gform-field-label--type-inline">' . $label_text . '</label>';
                $output .= '</div>';
                
                $input_id++;
            }
            
            $output .= '</div></div>';
            
            // Close fieldset
            $output .= '</fieldset>';
            
            return $output;
        }
        
        /**
         * Get events from selected categories
         */
        private function get_events_by_categories() {
            // Check if The Events Calendar is active
            if ( !class_exists( 'Tribe__Events__Main' ) ) {
                return array();
            }
            
            $selected_categories = !empty( $this->selectedCategories ) ? $this->selectedCategories : array();
            
            if ( empty( $selected_categories ) ) {
                return array();
            }
            
            // Query events from selected categories
            $args = array(
                'post_type'      => Tribe__Events__Main::POSTTYPE,
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_key'       => '_EventStartDate',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'tax_query'      => array(
                    array(
                        'taxonomy' => Tribe__Events__Main::TAXONOMY,
                        'field'    => 'term_id',
                        'terms'    => $selected_categories,
                        'operator' => 'IN'
                    )
                ),
                'meta_query'     => array(
                    array(
                        'key'     => '_EventStartDate',
                        'value'   => date( 'Y-m-d H:i:s' ),
                        'compare' => '>='
                    )
                )
            );
            
            $events = get_posts( $args );
            
            return $events;
        }
        
        /**
         * Get event date for display with Eastern and Pacific times
         */
        private function get_event_date( $event_id ) {
            if ( !function_exists( 'tribe_get_start_date' ) ) {
                return '';
            }
            
            // Get the event start date/time
            $start_date = tribe_get_start_date( $event_id, false, 'M j, Y' );
            
            // Debug logging
            error_log("Event ID $event_id - Start date: $start_date");
            
            // Try different methods to get the time
            $start_time_utc = tribe_get_start_date( $event_id, false, 'Y-m-d H:i:s' );
            $start_time_local = tribe_get_start_date( $event_id, true, 'Y-m-d H:i:s' );
            $event_timezone = get_post_meta( $event_id, '_EventTimezone', true );
            
            error_log("Event ID $event_id - UTC time: $start_time_utc, Local time: $start_time_local, Timezone: $event_timezone");
            
            // Check if this is an all-day event
            $all_day = tribe_event_is_all_day( $event_id );
            if ( $all_day ) {
                error_log("Event ID $event_id is all-day event");
                return $start_date . ' (All Day)';
            }
            
            if ( empty( $start_time_utc ) && empty( $start_time_local ) ) {
                error_log("Event ID $event_id - No time data found");
                return $start_date;
            }
            
            try {
                // Use local time if available, otherwise UTC
                $time_to_use = !empty( $start_time_local ) ? $start_time_local : $start_time_utc;
                $use_local = !empty( $start_time_local );
                
                error_log("Event ID $event_id - Using time: $time_to_use (local: " . ($use_local ? 'yes' : 'no') . ")");
                
                // Create DateTime object from the event time
                if ( $use_local && !empty( $event_timezone ) ) {
                    // Local time is already in the event's timezone - create DateTime with that timezone
                    $event_datetime = new DateTime( $time_to_use, new DateTimeZone( $event_timezone ) );
                    error_log("Event ID $event_id - Created DateTime with timezone: $event_timezone");
                } else if ( !$use_local ) {
                    // UTC time - create with UTC then convert if needed
                    $event_datetime = new DateTime( $time_to_use, new DateTimeZone( 'UTC' ) );
                    if ( !empty( $event_timezone ) ) {
                        $event_datetime->setTimezone( new DateTimeZone( $event_timezone ) );
                        error_log("Event ID $event_id - Converted UTC to: $event_timezone");
                    }
                } else {
                    // No timezone info - assume local server time
                    $event_datetime = new DateTime( $time_to_use );
                    error_log("Event ID $event_id - Created DateTime with server timezone");
                }
                
                // Convert to Eastern Time
                $eastern_tz = new DateTimeZone( 'America/New_York' );
                $eastern_time = clone $event_datetime;
                $eastern_time->setTimezone( $eastern_tz );
                
                // Convert to Pacific Time
                $pacific_tz = new DateTimeZone( 'America/Los_Angeles' );
                $pacific_time = clone $event_datetime;
                $pacific_time->setTimezone( $pacific_tz );
                
                // Format the times
                $eastern_formatted = $eastern_time->format( 'g:i A T' );
                $pacific_formatted = $pacific_time->format( 'g:i A T' );
                
                $result = $start_date . ' at ' . $eastern_formatted . ' / ' . $pacific_formatted;
                error_log("Event ID $event_id - Final result: $result");
                
                return $result;
                
            } catch ( Exception $e ) {
                // Fallback if timezone conversion fails
                error_log("Event ID $event_id - Exception: " . $e->getMessage());
                return $start_date;
            }
        }
        
        /**
         * Get category names for display
         */
        private function get_category_names( $category_ids ) {
            if ( !class_exists( 'Tribe__Events__Main' ) ) {
                return array();
            }
            
            $names = array();
            foreach ( $category_ids as $cat_id ) {
                $term = get_term( $cat_id, Tribe__Events__Main::TAXONOMY );
                if ( !is_wp_error( $term ) && !empty( $term ) ) {
                    $names[] = $term->name;
                }
            }
            
            return $names;
        }
        
        /**
         * Get event category names for a specific event
         */
        private function get_event_category_names( $event_id ) {
            if ( !class_exists( 'Tribe__Events__Main' ) ) {
                return array();
            }
            
            $terms = get_the_terms( $event_id, Tribe__Events__Main::TAXONOMY );
            
            if ( is_wp_error( $terms ) || empty( $terms ) ) {
                return array();
            }
            
            $names = array();
            foreach ( $terms as $term ) {
                $names[] = $term->name;
            }
            
            return $names;
        }
        
        /**
         * Get all available event categories for the settings
         */
        private function get_event_categories() {
            // Check if The Events Calendar is active
            if ( !class_exists( 'Tribe__Events__Main' ) ) {
                return array();
            }
            
            $categories = get_terms( array(
                'taxonomy'   => Tribe__Events__Main::TAXONOMY,
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC'
            ) );
            
            if ( is_wp_error( $categories ) ) {
                return array();
            }
            
            return $categories;
        }
        
        /**
         * Format the value for entry display
         */
        public function get_value_entry_display( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
            if ( empty( $value ) ) {
                return '';
            }
            
            // Handle both array format and individual input values
            if ( is_array( $value ) ) {
                $event_titles = array();
                foreach ( $value as $key => $val ) {
                    if ( !empty( $val ) ) {
                        $event_title = get_the_title( $val );
                        if ( $event_title ) {
                            $event_titles[] = esc_html( $event_title );
                        }
                    }
                }
                return implode( ', ', $event_titles );
            } else {
                // Single value
                $event_title = get_the_title( $value );
                return $event_title ? esc_html( $event_title ) : '';
            }
        }
        
        /**
         * Format the value for entry list display
         */
        public function get_value_entry_list( $value, $entry, $field_id, $columns, $form ) {
            return $this->get_value_entry_display( $value );
        }
        
        /**
         * Handle array values for entry detail display (fixes PHP warnings)
         */
        public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
            return $this->get_value_entry_display( $value, $currency, $use_text, $format, $media );
        }
        
        /**
         * Format the value for merge tags - shows event names with dates and times
         */
        public function get_value_merge_tag( $value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br ) {
            // Debug logging
            error_log('Merge tag called for field ' . $this->id . ' with value: ' . print_r($value, true));
            error_log('Input ID: ' . $input_id . ', Raw value: ' . print_r($raw_value, true));
            
            // Use raw_value if value is empty - this contains the actual submitted data
            if ( empty( $value ) && !empty( $raw_value ) ) {
                $value = $raw_value;
                error_log('Using raw_value as main value: ' . print_r($value, true));
            }
            
            // Extract event IDs from the array format
            $event_ids = array();
            if ( is_array( $value ) ) {
                foreach ( $value as $key => $val ) {
                    if ( !empty( $val ) && is_numeric( $val ) ) {
                        $event_ids[] = $val;
                    }
                }
            } else if ( !empty( $value ) && is_numeric( $value ) ) {
                $event_ids[] = $value;
            }
            
            error_log('Extracted event IDs: ' . print_r($event_ids, true));
            
            if ( empty( $event_ids ) ) {
                error_log('No event IDs found for merge tag');
                return 'No events selected';
            }
            
            $event_details = array();
            
            // Process each event ID
            foreach ( $event_ids as $event_id ) {
                $event_detail = $this->get_event_merge_tag_display( $event_id );
                if ( $event_detail ) {
                    $event_details[] = $event_detail;
                }
            }
            
            if ( empty( $event_details ) ) {
                error_log('No event details generated');
                return 'No valid events found';
            }
            
            // Join with line breaks for email formatting
            $separator = ( $format === 'html' ) ? '<br>' : "\n";
            $display_value = implode( $separator, $event_details );
            
            error_log('Final merge tag output: ' . $display_value);
            return $esc_html ? esc_html( $display_value ) : $display_value;
        }
        
        /**
         * Get detailed event information for merge tags
         */
        private function get_event_merge_tag_display( $event_id ) {
            $event_title = get_the_title( $event_id );
            if ( !$event_title ) {
                return '';
            }
            
            // Get the full date and time display
            $event_datetime = $this->get_event_date( $event_id );
            
            // Get event location if available
            $location = '';
            if ( function_exists( 'tribe_get_venue' ) ) {
                $venue = tribe_get_venue( $event_id );
                if ( !empty( $venue ) ) {
                    $location = ' at ' . $venue;
                }
            }
            
            // Get zoom link if it's a virtual event
            $zoom_info = '';
            if ( function_exists( 'get_field' ) ) {
                $zoom_link = get_field( 'zoom_link', $event_id );
                if ( !empty( $zoom_link ) ) {
                    $zoom_info = ' (Virtual Event)';
                }
            }
            
            // Build the display string
            $display = $event_title;
            if ( !empty( $event_datetime ) ) {
                $display .= ' - ' . $event_datetime;
            }
            $display .= $location . $zoom_info;
            
            return $display;
        }
        
        /**
         * Override the default behavior to handle checkbox inputs properly
         */
        public function get_input_type() {
            return 'checkbox';
        }
        
        /**
         * Return inputs for this field (like standard checkbox field)
         */
        public function get_entry_inputs() {
            $inputs = array();
            $events = $this->get_events_by_categories();
            
            if ( !empty( $events ) ) {
                $input_id = 1;
                foreach ( $events as $event ) {
                    $inputs[] = array(
                        'id' => $this->id . '.' . $input_id,
                        'label' => get_the_title( $event->ID )
                    );
                    $input_id++;
                }
            }
            
            return $inputs;
        }
        
        /**
         * This tells Gravity Forms this field has multiple inputs (like checkbox)
         */
        public function is_value_submission_array() {
            return true;
        }
        

        /**
         * Sanitize the submitted value
         */
        public function sanitize_value( $value ) {
            if ( is_array( $value ) ) {
                return array_map( 'sanitize_text_field', $value );
            }
            return sanitize_text_field( $value );
        }
        
        /**
         * Validate the field
         */
        public function validate( $value, $form ) {
            //error_log( 'Validating event_categories field - Value received:' );
            //error_log( print_r( $value, true ) );
            
            // Check if any checkbox inputs have values
            $has_values = false;
            $event_ids_to_validate = array();
            
            if ( is_array( $value ) ) {
                foreach ( $value as $input_key => $input_value ) {
                    if ( !empty( $input_value ) ) {
                        $has_values = true;
                        $event_ids_to_validate[] = $input_value;
                    }
                }
            }
            
            //error_log( 'Event IDs to validate: ' . implode( ', ', $event_ids_to_validate ) );
            
            // If field is required and no values are selected
            if ( $this->isRequired && !$has_values ) {
                $this->failed_validation  = true;
                $this->validation_message = empty( $this->errorMessage ) ? esc_html__( 'This field is required.', 'gravityforms' ) : $this->errorMessage;
                return;
            }
            
            // Validate selected event IDs exist and are events
            if ( !empty( $event_ids_to_validate ) ) {
                foreach ( $event_ids_to_validate as $event_id ) {
                    // Make sure it's numeric
                    if ( !is_numeric( $event_id ) ) {
                        //error_log( 'Non-numeric event ID: ' . $event_id );
                        continue;
                    }
                    
                    $event = get_post( intval( $event_id ) );
                    //error_log( 'Validating event ID ' . $event_id . ' - Post found: ' . ( $event ? 'yes' : 'no' ) . ' - Post type: ' . ( $event ? $event->post_type : 'N/A' ) );
                    
                    if ( !$event || $event->post_type !== Tribe__Events__Main::POSTTYPE ) {
                        $this->failed_validation  = true;
                        $this->validation_message = esc_html__( 'Please select valid events.', 'gravityforms' );
                        //error_log( 'Event validation failed for ID: ' . $event_id );
                        break;
                    }
                }
            }
            
            //error_log( 'Validation result - Failed: ' . ( $this->failed_validation ? 'true' : 'false' ) );
        }
        
        /**
         * Define default field values for the form editor
         */
        public function get_form_editor_inline_script_on_page_render() {
            $script = sprintf( 
                "function SetDefaultValues_%s(field) {
                    field.label = '%s';
                    field.selectedCategories = [];
                }", 
                $this->type, 
                $this->get_form_editor_field_title() 
            );
            
            return $script;
        }
    }
    
    // Register the field
    GF_Fields::register( new GF_Field_Event_Categories() );
}


/**
 * Add custom setting for event category selection in form editor
 */
add_action( 'gform_field_standard_settings', 'add_event_categories_setting', 10, 2 );
function add_event_categories_setting( $position, $form_id ) {
    if ( $position == 25 ) {
        ?>
        <li class="event_categories_setting field_setting">
            <label for="field_event_categories" class="section_label">
                <?php esc_html_e( 'Event Categories', 'gravityforms' ); ?>
                <?php gform_tooltip( 'event_categories_value' ) ?>
            </label>
            
            <div id="event_categories_container">
                <?php
                // Get all event categories
                if ( class_exists( 'Tribe__Events__Main' ) ) {
                    $categories = get_terms( array(
                        'taxonomy'   => Tribe__Events__Main::TAXONOMY,
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC'
                    ) );
                    
                    if ( !is_wp_error( $categories ) && !empty( $categories ) ) {
                        foreach ( $categories as $category ) {
                            ?>
                            <div>
                                <input type="checkbox" 
                                       id="event_category_<?php echo $category->term_id; ?>" 
                                       value="<?php echo $category->term_id; ?>" 
                                       onclick="SetEventCategories();" />
                                <label for="event_category_<?php echo $category->term_id; ?>">
                                    <?php echo esc_html( $category->name ); ?>
                                </label>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No event categories found. Make sure The Events Calendar Pro is installed and has categories.</p>';
                    }
                } else {
                    echo '<p>The Events Calendar Pro plugin is required for this field to work.</p>';
                }
                ?>
            </div>
        </li>
        <?php
    }
}


/**
 * Add tooltip for the event categories setting
 */
add_filter( 'gform_tooltips', 'add_event_categories_tooltip' );
function add_event_categories_tooltip( $tooltips ) {
    $tooltips['event_categories_value'] = '<h6>Event Categories</h6>Select which event categories should be used to populate this field. Events from the selected categories will appear as checkboxes for form users.';
    return $tooltips;
}

/**
 * Add JavaScript for form editor functionality
 */
add_action( 'gform_editor_js', 'add_event_categories_field_editor_js' );
function add_event_categories_field_editor_js() {
    ?>
    <script type='text/javascript'>
        // Bind to the load field settings event to populate the categories
        jQuery(document).bind('gform_load_field_settings', function(event, field, form) {
            if (field.type == 'event_categories') {
                // Clear all checkboxes first
                jQuery('#event_categories_container input[type="checkbox"]').prop('checked', false);
                
                // Check the previously selected categories
                if (field.selectedCategories && field.selectedCategories.length > 0) {
                    jQuery.each(field.selectedCategories, function(index, categoryId) {
                        jQuery('#event_category_' + categoryId).prop('checked', true);
                    });
                }
            }
        });
        
        // Function to update the field's selectedCategories property
        function SetEventCategories() {
            const selectedCategories = [];
            jQuery('#event_categories_container input[type="checkbox"]:checked').each(function() {
                selectedCategories.push(parseInt(jQuery(this).val()));
            });
            
            SetFieldProperty('selectedCategories', selectedCategories);
        }
        
        // Add field to Advanced Fields group
        gform.addFilter('gform_form_editor_can_field_be_added', function (canFieldBeAdded, type) {
            return canFieldBeAdded;
        });
    </script>
    <?php
}


//prompt data display
function dlinq_prompt_display(){
	$post_id = get_the_ID();
	$html = '';
	$prompt = get_field('prompt');
	$directions_html = '';
	$links = dlinq_prompt_links();
	if(get_field('additional_directions')){
			$directions = get_field('additional_directions');
			$directions_html = "<div class='directions-text'>
					<h2>Additional Directions</h2>
					<p>{$directions}</p>
					</div>";	
	}
	if($prompt){
		$html .= "<div class='dlinq-prompt-display row'>
				<div class='col-md-6'>
					<div class='prompt-text'>
						<h2>The Prompt</h2>
						<div contenteditable='true' class='prompt-box' id='prompt-box-{$post_id}'>{$prompt}</div>
					</div>
					{$directions_html}
				</div>
				<div class='col-md-4 offset-md-1 prompt-links'>
						$links
					</div>
				</div>";
	}
	echo $html;
}

//prompt link builder 
function dlinq_prompt_links(){
	$post_id = get_the_ID();
	$html = '';
	$html .= "<button class='btn btn-primary btn-dlinq copy-button' id='copy-btn-{$post_id}' data-id='{$post_id}'>Copy Prompt</button>";
	$related_prompts = get_field('ai_service_links');
	if($related_prompts){
		if(in_array('gemini', $related_prompts)){
			$gemini_link = dlinq_gemini_link_builder();
			$html .= "<a class='btn btn-primary btn-dlinq btn-ai' href='{$gemini_link}' target='_blank' rel='noopener'>Open in Gemini</a>";
		}
		if(in_array('chatgpt', $related_prompts)){
			$chatgpt_link = dlinq_chatgpt_link_builder();
			$html .= "<a class='btn btn-primary btn-dlinq btn-ai' href='{$chatgpt_link}' target='_blank' rel='noopener'>Open in ChatGPT</a>";
		}
		if(in_array('claude', $related_prompts)){
			$claude_link = dlinq_claude_link_builder();
			$html .= "<a class='btn btn-primary btn-dlinq btn-ai' href='{$claude_link}' target='_blank' rel='noopener'>Open in Claude</a>";
		}
	}
	
	return $html;
}


function dlinq_gemini_link_builder(){
	$choice = get_field('gemini_choices');
	$prompt = urlencode(get_field('prompt'));

	$stem = 'https://gemini.google.com/';	
	if ($choice == 'Custom Gem'){
		$gem_id = get_field('custom_gem_id');
		$stem = $stem . 'gem/' . $gem_id ;
	}
	if ($choice == 'Specific Tool'){
		$tool = get_field('gemini_specific_tool');
		$stem = $stem . $tool ;
	}
	$prompt_action = '&prompt_action=prefill';
	return $stem . '?prompt_text=' . $prompt . $prompt_action;
}

function dlinq_chatgpt_link_builder(){
	$stem = "https://chat.openai.com/?q=";
	$prompt = urlencode(get_field('prompt'));
	return $stem . $prompt;
}

function dlinq_claude_link_builder(){
	$stem = "https://claude.ai/new?q=";
	$prompt = urlencode(get_field('prompt'));
	return $stem . $prompt;
}

//add prompts to category archives
function include_prompts_in_category( $query ) {
    if ( !is_admin() && $query->is_main_query() && $query->is_category() ) {
        $query->set( 'post_type', array( 'post', 'prompt' ) );
    }
}
add_action( 'pre_get_posts', 'include_prompts_in_category' );

// function dlinq_copilot_link_builder(){
// 	$stem = "https://www.bing.com/chat?q=";
// 	$prompt = urlencode(get_field('prompt'));
// 	var_dump($stem . $prompt . "&sendquery=1");
// 	return $stem . $prompt . "&sendquery=1";
// }

//side nav 
function dlinq_side_nav_gather($title){
	$array = array();
	array_push($array, $title);
	return $array;
}

function dlinq_side_top_nav_builder($big_titles){
	$html = '';
	if(sizeof($big_titles) <= 1){
		return;
	}
	foreach($big_titles as $big_title){
		$big_title_slug = sanitize_title($big_title);
		$html .= "<li class='menu-item menu-item-type-custom nav-item'>
			<a class='nav-link' href='#{$big_title_slug}-content'>{$big_title}</a>
		</li>";

	}
	echo "<nav class='navbar navbar-light navbar-nav navbar-expand' id='side-layout-big-menu'>
			<ul class='navbar-nav justify-content-center flex-grow-1 pe-3'>{$html}</ul>
		</nav>";
}
function dlinq_side_nav_sg_builder($big_title, $id, $sub_groups){
	$big_title_slug = sanitize_title($big_title);
	?>
	<section id='<?php echo $big_title_slug; ?>'>
		<div class='container'>
			<div class='dlinq-side-nav-wrapper'>
				<div class='col-md-3 sidebar'>
					<div class='dlinq-side-nav'>
						<h2 id='<?php echo $id; ?>'><?php echo $big_title; ?></h2>
						<nav class='nav flex-column'>
							<?php foreach($sub_groups as $item):
								$sg_title = $item['sub-group_title'];
								$slug = sanitize_title($sg_title);
								$content_id = $big_title_slug . '-' . $slug;
							?>
								<a class='nav-link' href='#' data-content='<?php echo $content_id; ?>'><?php echo $sg_title; ?></a>
							<?php endforeach; ?>
						</nav>
					</div>
				</div>
				<div class='col-md-9 content-area' id='<?php echo $big_title_slug; ?>-content'>
					<?php foreach($sub_groups as $item):
						$sg_title = $item['sub-group_title'];
						$slug = sanitize_title($sg_title);
						$content_id = $big_title_slug . '-' . $slug;
						$sg_content = $item['sub-group_content'];
					?>
						<div id='<?php echo $content_id; ?>' class='dlinq-side-nav-content'>
							<h3><?php echo $sg_title; ?></h3>
							<?php
							// Render flexible content
							if($sg_content && is_array($sg_content)):
								foreach($sg_content as $content_block):
									$layout = $content_block['acf_fc_layout'];
									dlinq_render_flex_content_block($content_block, $layout);
								endforeach;
							endif;
							?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

function dlinq_render_flex_content_block($block, $layout){
	switch($layout){
		case 'sub_topic':
			dlinq_render_sub_topic($block);
			break;
		case 'image':
			dlinq_render_image_block($block);
			break;
		case 'full_block':
			dlinq_render_full_block($block);
			break;
		case 'people':
			dlinq_render_people_block($block);
			break;
		case 'accordion':
			dlinq_render_accordion_block($block);
			break;
		case 'posts':
			dlinq_render_posts_block($block);
			break;
		case 'challenge':
			dlinq_render_challenge_block($block);
			break;
	}
}

function dlinq_render_sub_topic($block){
	$title = $block['sub_topic_title'];
	$slug = sanitize_title($title);
	$resources = $block['resources'];
	?>
	<div class='row topic-row'>
		<div class='col-md-5'>
			<div class='sub-topic'>
				<?php if ($title): ?>
				<h4 id='<?php echo $slug;?>'><?php echo $title; ?></h4>
				<?php endif;?>
				<?php echo $block['sub_topic_content']; ?>
			</div>
		</div>
		<div class='col-md-5 offset-md-2'>
			<?php if($resources):
				echo "<div class='menu-block'>
				<ul class='resource-links'>";
				foreach($resources as $resource){
					$title = $resource['resource_title'];
					$link = $resource['resource_link'];
					$description = $resource['resource_description'];
					$type = $resource['resource_type'];
					if(str_contains(strtolower($description), 'coming soon')){
						$link = "#{$slug}";
					}
					if(array_key_exists('host', parse_url($link))){
						$url_source = dlinq_remove_www(parse_url($link)["host"]);
					} else {
						$url_source = $link;
					}

					echo "
							<li>
								<a href='{$link}'>
								   <div class='inline'>
										<div class='resource-icon {$type}' arial-lable='Icon for {$type}.'></div>
								   </div>
								   <div class='inline'>
										{$title}
										<div class='resource-source'>source: {$url_source}</div>
										<div class='resource-description'>{$description} &nbsp;</div>
									</div>
								</a>
							</li>
						";
				}
				echo "</ul></div>";
			?>
			<?php endif;?>
		</div>
	</div>
	<?php
}

function dlinq_render_image_block($block){
	$title = $block['title'];
	$slug = sanitize_title($title);
	$content = $block['content'];
	$image = $block['image'];
	$direction = $block['image_align'];
	$order_left = ' order-first ';
	$order_right = ' order-last ';
	if($direction == 'right'){
		$order_left = ' order-last ';
		$order_right = ' order-first ';
	}
	?>
	<div class='row topic-row d-flex align-items-center'>
		<div class='col-md-5<?php echo $order_left;?>'>
			<figure>
				<?php echo wp_get_attachment_image( $image['ID'], 'large', array('class'=>'img-fluid') ); ?>
				<figcaption><?php echo $image['caption']; ?></figcaption>
			</figure>
		</div>
		<div class='col-md-2 order-2'></div>
		<div class='col-md-5 <?php echo $order_right;?>'>
			<?php if($title) :?>
				<h4 id="<?php echo $slug;?>"><?php echo $title; ?></h4>
			<?php endif;?>
			<?php echo $content; ?>
		</div>
	</div>
	<?php
}

function dlinq_render_full_block($block){
	$title = $block['title'];
	$content = $block['content'];
	$slug = sanitize_title($title);
	?>
	<div class='row topic-row full-width-row'>
		<div class='col-md-12'>
			<?php if($title):?>
				<h4 id="<?php echo $slug?>"><?php echo $title;?></h4>
			<?php endif;?>
			<?php echo $content;?>
		</div>
	</div>
	<?php
}

function dlinq_render_people_block($block){
	$persons = $block['individuals'];
	$title = $block['title'];
	$slug = sanitize_title($title);
	?>
	<div class='row topic-row full-width-row d-flex justify-content-around people-row'>
	<?php if($title):?>
		<div class="col-md-12">
			<h4 id="<?php echo $slug?>"><?php echo $title;?></h4>
		</div>
	<?php endif;?>
		<?php
			foreach($persons as $person){
				$post_id = $person;
				$name = get_the_title($post_id);
				$title = get_field('job_title', $post_id);
				$img = dlinq_person_thumb_check($post_id, 'portrait', 'free-bio-pic img-fluid');
				$email_html = '';
				if(get_field('email', $post_id)){
					$email = get_field('email', $post_id);
					$email_html = "<a href='mailto:{$email}' aria-lable='Email to {$name}'>✉️ Connect</a>";
				}
				$link = get_permalink( $post_id);
				echo "
				<div class='col-md-4 person-holder'>
					<div class='person-block'>
						{$img}
						<a href='{$link}'><h4 class='small-name'>{$name}</h4></a>
						<div class='title'>{$title}</div>
						<div class='small-contact'>
							{$email_html}
						</div>
					</div>
				</div>
				";
			}
		?>
	</div>
	<?php
}

function dlinq_render_accordion_block($block){
	$accordion_parts = $block['accordion_parts'];
	$accord_title = $block['accordion_title'];
	$index = rand(1000, 9999); // Generate random index for unique IDs
	$accordion_id = "accordion-{$index}";

	echo "<div class='row topic-row full-width-row d-flex justify-content-around'>";
	if($accord_title){
		$title_slug = sanitize_title($accord_title);
		echo "<h4 id='{$title_slug}'>{$accord_title}</h4>";
	}
	echo "<div class='accordion' id='{$accordion_id}'>";

	foreach($accordion_parts as $piece){
		$title = $piece['title'];
		$slug = sanitize_title($title);
		$content = $piece['content'];
		$item_id = "{$slug}-{$index}"; // Make unique across multiple accordions

		echo "
			<div class='accordion-item'>
				<h2 class='accordion-header' id='heading-{$item_id}'>
					<button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse-{$item_id}' aria-expanded='false' aria-controls='collapse-{$item_id}'>
						{$title}
					</button>
				</h2>
				<div id='collapse-{$item_id}' class='accordion-collapse collapse' aria-labelledby='heading-{$item_id}' data-bs-parent='#{$accordion_id}' hidden='until-found'>
					<div class='accordion-body'>
						{$content}
					</div>
				</div>
			</div>
		";
	}

	echo "</div></div>";
}

function dlinq_render_posts_block($block){
	$title = 'Learn more';
	if($block['title']){
		 $title = $block['title'];
	}
	$slug = sanitize_title( $title);
	echo "<div class='row topic-row full-width-row'>
			<div class='col-md-12'>
				<h4 id='{$slug}'>{$title}</h4>
			</div>
				";

	$cats = $block['category'];
	$type = $block['post_type'];
	$args = array(
		'category__and' => $cats,
		'post_type' => $type,
		'posts_per_page' => -1,
		'paged' => get_query_var('paged')
	);
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
		// Do Stuff
		$title = get_the_title();
		$url = get_the_permalink();
		$html = "";
		if(get_the_content()){
			 $excerpt = wp_trim_words(get_the_content(), 30);
			 $html = "<div class='col-md-12'>
				<div class='post-block'>
					<a class='post-link stretched-link' href='{$url}'>
						<h5>{$title}</h5>
						<p>{$excerpt}</p>
					 </a>
				</div>
			</div>";
		}
		if(get_field('project_summary')){
		   $excerpt =  wp_trim_words(get_field('project_summary'), 30);
			$html = "<div class='col-md-12'>
				<div class='post-block'>
					<a class='post-link stretched-link' href='{$url}'>
						<h5>{$title}</h5>
						<p>{$excerpt}</p>
					 </a>
				</div>
			</div>";
		}
		if(get_field('workshop_description')){
		   $excerpt =  wp_trim_words(get_field('workshop_description'), 30);
			$html = "<div class='col-md-12'>
				<div class='post-block'>
					<a class='post-link stretched-link' href='{$url}'>
						<h5>{$title}</h5>
						<p>{$excerpt}</p>
					 </a>
				</div>
			</div>";
		}
		if(get_field('prompt')){
		   //$excerpt =  wp_trim_words(get_field('prompt'), 30);
		   $html = get_template_part( 'loop-templates/content', 'prompt' );
		}
		echo $html;
		endwhile;
	endif;
	// Reset Post Data
	wp_reset_postdata();
	echo "</div>";
}

function dlinq_render_challenge_block($block){
	$title = $block['challenge_title'];
	$content = $block['challenge_description'];
	$form = $block['form_id'];
	$slug = sanitize_title($title);
	?>
	<div class='row topic-row full-width-row'>
		<div class='col-md-12'>
			<?php if($title):?>
				<h4 id="<?php echo $slug;?>"><?php echo $title;?></h4>
			<?php endif;?>
			<?php echo $content;?>
			<?php if ($form > 0) {
				gravity_form($form);//show form
				dlinq_gf_form_entry_display($form);//show form entries
				}?>
		</div>
	</div>
	<?php
}