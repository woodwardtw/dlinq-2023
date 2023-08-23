<?php
/**
 * Template Name: Home
 *
 * Template for the home page
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

if ( is_front_page() ) {
	get_template_part( 'global-templates/hero' );
}

$wrapper_id = 'full-width-home-wrapper';
if ( is_page_template( 'page-templates/no-title.php' ) ) {
	$wrapper_id = 'no-title-page-wrapper';
}
?>

<div class="wrapper" id="<?php echo $wrapper_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ok. ?>">
    <div class="major-container" id="particles-js">
		<div class="container">
			<div class="major-row row">
				<?php if ( get_field('dlinq_description') ) : ?>
					<div class="dlinq-description col-md-4">
						<h1 class="major-title">DLINQ</h1>
						<!-- <img src="<?php //echo get_template_directory_uri( )?>/imgs/dlinq-logo.svg" class="img-fluid logo"> -->
						<?php the_field('dlinq_description'); ?>
					</div>
					<div class="dlinq-description col-md-5 offset-md-3">
						<?php if ( have_rows('main_topics') ) : ?>
						<h1>We can help.</h1>
							<ul id="home-top-menu">
							<?php while( have_rows('main_topics') ) : the_row(); ?>
									<li><?php dlinq_top_menu_list(get_sub_field('title')); ?></li>
							<?php endwhile;?>
							</ul>
						<?php endif;?>
					</div>
				<?php endif; ?>
			</div>
		</div>
    </div>
	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'loop-templates/content', 'page-home' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					}
					?>

				</main>

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #<?php echo $wrapper_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ok. ?> -->

<?php
get_footer();
