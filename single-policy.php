<?php
/**
 * The template for displaying all single policies
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
			<div class="container">
				<div class="major-row row">						
						<div class="col-md-10 offset-md-2">
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
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

			<main class="site-main" id="policy">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'single-policy' );
					understrap_post_nav();
					
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
