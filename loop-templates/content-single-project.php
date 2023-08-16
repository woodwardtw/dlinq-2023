<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content row">
        <div class="col-md-5">
			<div class="bio">
                <h2>About</h2>
				<?php the_field('project_summary'); ?>
			</div>
        </div>
        <div class="col-md-5 offset-md-2">
            <?php echo get_the_post_thumbnail( $post->ID, 'large', array( 'class' => 'img-fluid aligncenter bio-pic') ); ?>
        </div>
        <div class="col-md-5">
            <?php dlinq_projects_people();?>
        </div>
        <div class="col-md-5 offset-md-2">
            <?php dlinq_projects_cats();?>
        </div>
	</div><!-- .entry-content -->
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
