<?php
/**
 * Single topic partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="topic-row row">
        <div class="col-md-5">
			<?php the_field('topic_summary'); ?>
        </div>
        <div class="col-md-5 offset-md-2">
			<?php dlinq_topic_menu(); ?>
        </div>
	</div><!-- .entry-content -->
	<?php get_template_part( 'loop-templates/content', 'flexcontent' );?>
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
