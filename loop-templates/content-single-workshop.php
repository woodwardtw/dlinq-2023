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
	</div><!-- .entry-content -->
    <div class="topic-row row">
        <div class="col-md-5">
            <h2>Resources</h2>
            <?php echo dlinq_workshop_resources();?>
        </div>
        <div class="col-md-6 offset-md-1">
            <h2>Request this workshop</h2>

            <?php  
                $gf_id = get_field('workshop_request_form', 'option');
                gravity_form( $gf_id, false, false, false, array('workshop' => get_the_title()), true, false, true ); 
            ?>
        </div>
    </div>
    <?php get_template_part( 'loop-templates/content', 'flexcontent' );?>

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
