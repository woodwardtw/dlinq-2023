<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper( get_the_ID() );
/**
 * Setting up the cookie if it doesn't exist yet and grabbing the browser time zone string.
 */
if ( ! isset( $_COOKIE['tribe_browser_time_zone'] ) ) { ?>
    <script type="text/javascript">
        if ( navigator.cookieEnabled ) {
            document.cookie = "tribe_browser_time_zone=" + Intl.DateTimeFormat().resolvedOptions().timeZone + "; path=/";
        }
    </script>
<?php }
 
/**
 * Calculating the event start time and time zone based on the browser time zone of the visitor.
 */
 
// Setting default values in case the cookie doesn't exist.
$user_time_output = "<small>Your time zone couldn't be detected. Try <a href=''>reloading</a> the page.</small>";
$browser_time_zone_string = "not detected";
 
if ( isset( $_COOKIE['tribe_browser_time_zone'] ) ) {
    // Grab the time zone string from the cookie.
    $browser_time_zone_string = $_COOKIE['tribe_browser_time_zone'];
 
    // Grab the event time zone string.
    $event_time_zone_string = Tribe__Events__Timezones::get_event_timezone_string( $event_id );
 
    // Grab the event start date in UTC time from the database.
    $event_start_utc = tribe_get_event_meta( $event_id, '_EventStartDateUTC', true );
 
    // Set up the DateTime object.
    $event_start_date_in_utc_timezone = new DateTime( $event_start_utc, new DateTimeZone( 'UTC' ) );
 
    // Convert the UTC DateTime object into the browser time zone.
    $event_start_date_in_browser_timezone = $event_start_date_in_utc_timezone->setTimezone( new DateTimeZone( $browser_time_zone_string ) )->format( get_option( 'time_format' ) );
 
    // Grab the time zone abbreviation based on the browser time zone string.
    $browser_time_zone_abbreviation = Tribe__Timezones::abbr( 'now', $browser_time_zone_string );
 
    // Compile the output string with time zone abbreviation.
    $user_time_output = $event_start_date_in_browser_timezone . " " . $browser_time_zone_abbreviation;
 
    // Compile the string of the time zone for the tooltip.
    $browser_time_zone_string .= ' detected';
}

/**
 * Allows filtering of the event ID.
 *
 * @since 6.0.1
 *
 * @param int $event_id
 */
$event_id = apply_filters( 'tec_events_single_event_id', $event_id );

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array  $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 */
$title = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, false ), $event_id );
$cost  = tribe_get_formatted_cost( $event_id );

?>
<div id="tribe-events-content" class="tribe-events-single">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php echo $title; ?>

	<div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		<?php
			/**
			 * Adding the event start time in the visitor's time zone.
			 */
			if ( ! tribe_event_is_all_day( $event_id ) ) {
			    echo "<div class='tribe-events-schedule--browser-time-zone'><p>";
			    echo "Start time in <span data-toggle='tooltip' data-placement='top' style='text-decoration-style: dotted; text-decoration-line: underline; cursor: help;' title='This is based on your browser time zone (" . $browser_time_zone_string . ") and it might not be fully accurate.'>your time zone</span>: " . $user_time_output;
			    echo "</p></div>";
			}
			?>		
		<?php if ( ! empty( $cost ) ) : ?>
			<span class="tribe-events-cost"><?php echo esc_html( $cost ) ?></span>
		<?php endif; ?>
	</div>

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>					
			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<div class="row">
					<div class="col-md-8">
						<?php dlinq_event_modality();?>
						<?php the_content(); ?>
					</div>
					<div class="col-md-4">
						<!-- Event featured image, but exclude link -->
						<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>
					</div>
				</div>
				<!--add to calendar drop down-->
				<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
				<!--Event registration button-->
				<?php $form_id = get_field('workshop_reservation_form', 'option');;?>
				<?php dlinq_registration_check($form_id);?>
				<!--acf resources content-->
				<?php 

							if( have_rows('resources')):
									echo "<h2 id='event-resources'>Resources</h2>";
							//     // Loop through rows.
							    while( have_rows('resources') ) : the_row();
						
							        // Load sub field value.
							        $title = get_sub_field('resource_title');
							        $link = get_sub_field('resource_link');
							        $description = get_sub_field('resource_description');
							        // Do something...
							        echo "
							        	<h3><a href='{$link}''>{$title}</a></h3>
							        	<p>{$description}</p>
							        ";
							    // End loop.
							    endwhile;
								// No value.
								else :
								    // Do something...
								endif;
						
						
				?>
			</div>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

		</div> <!-- #post-x -->
		
		<!--Registered people display-->
		<?php dlinq_registered_people($form_id);?>
	
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->

<!--EVENT REGISTRATION MODAL-->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="registrationModalLabel">Register</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <?php
       		 global $post;       		
       		 //$bulk = dlinq_event_bulk_registration($post->ID);
       		 $terms = get_the_terms($post->ID,'tribe_events_cat');
       		 $bulk = dlinq_event_no_registration($terms,'bulk');
       		if($bulk === TRUE){
       			$gform_id = get_field('workshop_bulk_request_form', 'option');//show bulk enrollment form
       		} else {
	       		$gform_id = get_field('workshop_registration_form', 'option');//show regular form       			
       		}
       		$values = array(
       					'event_name' => get_the_title(),
       					'event_id' => get_the_ID(),
       					'zoom_link' => get_field('zoom_link'),
       					'event_date' => tribe_get_start_date(),
       					'resources' => dlinq_event_resources()
       				);
       		$past = dlinq_tribe_is_past_event( get_the_ID());
  			if( $past != TRUE){ 
       			gravity_form( $gform_id, false, false, false, $values, true, null, true, null, null);
       		}
       		?>
      </div>
    </div>
  </div>
</div>
