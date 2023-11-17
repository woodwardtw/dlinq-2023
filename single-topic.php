<?php
/**
 * The template for displaying all single topics
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="topic-wrapper">
	 <div class="major-container">
		<div id="particles-js"></div>
			<div class="container">
				<div class="major-row row">						
						<div class="col-md-6">
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
						</div>
						<div class="col-md-4 offset-md-2">
							    <?php echo get_the_post_thumbnail( $post->ID, 'medium', array( 'class' => 'img-fluid aligncenter topic-pic') ); ?>
						</div>
				</div>
			</div>
		</div>
		<!--breadcrumbs-->
	<div class="container">
			<div class="row">
				<div class="col-md-12">	
					<?php dlinq_custom_breadcrumbs();?>
				</div>
			</div>
	</div>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			//get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="topic">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'single-topic' );
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
