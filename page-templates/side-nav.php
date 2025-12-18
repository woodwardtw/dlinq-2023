<?php
/**
 * Template Name: Side Nav
 *
 * This template displays a page with flexible content including side navigation
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
//$template_slug = sanitize_title(array_keys(wp_get_theme()->get_page_templates())[0]);
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php
					while ( have_posts() ) {
						the_post();
						?>

						<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
							<?php 
							if( have_rows('content') ):

								// Loop through rows.
								while ( have_rows('content') ) : the_row();
									$big_group = get_sub_field('big_group', get_the_ID());
									// Create an array of big group titles
									$big_titles_array = array();
									foreach($big_group as $group){
										$title = $group['big_group_title'];
										array_push($big_titles_array, $title);
									}
								endwhile;
							endif;
								dlinq_side_top_nav_builder($big_titles_array);
							?>

							<div class="entry-content">
								<?php the_content(); ?>
							</div><!-- .entry-content -->

							<?php
							// Include the flexible content template
							get_template_part( 'loop-templates/content', 'flexcontent' );
							?>

							<footer class="entry-footer">
								<?php understrap_entry_footer(); ?>
							</footer><!-- .entry-footer -->

						</article><!-- #post-<?php the_ID(); ?> -->

						<?php
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

</div><!-- #page-wrapper -->

<?php
get_footer();
