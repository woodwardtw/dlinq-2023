<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content">

		<div class="topic-descriptor">
			<?php
			//the_content();
			the_field('topic_summary');
			//understrap_link_pages();
			?>
		</div>
	</div><!-- .entry-content -->
	<?php get_template_part( 'loop-templates/content', 'flexcontent' );?>

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
