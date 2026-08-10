<?php
/**
 * Partial template for content in data-page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	echo get_the_post_thumbnail( $post->ID, 'large' );
	?>

	<div class="entry-content">
        <div class="topic-row row">
            <div class="col-md-5">
                <?php the_field('topic_summary'); ?>
            </div>
            <div class="col-md-5 offset-md-2">
                <?php dlinq_topic_menu(); ?>
            </div>
        </div>

		<?php
		the_content();

        dlinq_workshop_counter(2025);
        dlinq_workshop_counter(2024);
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->
    <?php get_template_part( 'loop-templates/content', 'flexcontent' );?>
	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
