<?php
/**
 * Single workshop partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content row">
        <div class="col-md-5">
			<div class="workshop">
                <h2>Workshop description</h2>
				<?php the_field('workshop_description'); ?>
			</div>
        </div>
        <div class="col-md-5 offset-md-2">
            <?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'img-fluid aligncenter project-pic') ); ?>
        </div>
        <div class="col-md-4 offset-md-4">
            <?php dlinq_project_button();;?>
        </div>
	</div><!-- .entry-content -->
    <div class="topic-row row">
        <div class="col-md-5">
            <?php dlinq_projects_people();?>
        </div>
        <div class="col-md-6 offset-md-1">
            <?php dlinq_projects_cats();?>
        </div>
    </div>
    <?php get_template_part( 'loop-templates/content', 'flexcontent' );?>

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
