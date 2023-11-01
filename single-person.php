<?php
/**
 * The template for displaying all single people
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="person-wrapper">
	 <div class="major-container">
			<div id="particles-js"></div>
			<div class="container">
				<div class="major-row row">						
						<div class="col-md-6">
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
							<h2 class="job-title">
								<?php the_field('job_title') ;?>
							</h2>
							<div class="person-details">
								<?php dlinq_person_details('pronouns'); ?>
								<?php dlinq_person_details('email'); ?>
								<?php dlinq_person_details('phone'); ?>
								<?php dlinq_person_details('office_location'); ?>
							</div>
						</div>
						<div class="col-md-4 offset-md-2">
							    <?php echo get_the_post_thumbnail( $post->ID, 'medium', array( 'class' => 'img-fluid aligncenter bio-pic') ); ?>
						</div>
				</div>
			</div>
	</div>
	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			//get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'single-person' );
					understrap_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}
				?>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			//get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
