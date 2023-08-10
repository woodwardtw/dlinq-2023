<?php
/**
 * Partial template for content in fullwidthpage-home.php
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

        <?php      
		//the_content();
		understrap_link_pages();
		?>

		<?php if ( have_rows('main_topics') ) : ?>
			<?php while( have_rows('main_topics') ) : the_row(); ?>
				<div class="row topic-row">
					<div class="col-md-5">
						<h2>
							<?php the_sub_field('title'); ?>
						</h2>
						<div class="topic-descriptor">
							<?php the_sub_field('description'); ?>
						</div>
					</div>
					<div class="col-md-5 offset-md-1">
						<ul class="topic-list">
							<?php dlinq_topic_list(get_sub_field('associated_pages'));?>
						</ul>
					</div>
				</div>
				<?php endwhile; ?>
			<?php endif; ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
