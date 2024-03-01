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
		<!--EVENTS-->
			<?php dlinq_home_events();?>

		<!--FOCUS-->
		<?php if ( have_rows('focus') ) : ?>
		<div class="focus-holder">
			<?php while( have_rows('focus') ) : the_row(); ?>
				<div class="row alert-row">
					<div class="col-md-10 offset-md-1">
						<?php dlinq_topic_title(get_sub_field('title')); ?>
					</div>
					<div class="col-md-6 offset-md-1">
						<div class="topic-descriptor">
							<?php the_sub_field('description'); ?>							
						</div>
					</div>
					<div class="col-md-4 offset-md-1">
						<?php dlinq_focus_image(get_sub_field('image'));?>
					</div>
					<div class="col-md-10 offset-md-1">
						<a class="btn btn-dlinq" href="<?php the_sub_field('link');?>" aria-label="Learn more about <?php the_sub_field('title'); ?>.">
								Learn more
							</a>	
					</div>

				</div>
				
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
		
		<!--TOPICS-->
		<?php if ( have_rows('main_topics') ) : ?>
		<div class="topic-holder">
			<?php while( have_rows('main_topics') ) : the_row(); ?>
				<div class="row topic-row">
					<div class="col-md-5">
						<?php dlinq_topic_title(get_sub_field('title')); ?>
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
		</div>
			<?php endif; ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
