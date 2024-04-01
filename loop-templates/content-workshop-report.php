<?php
/**
 * Partial template for workshop-report.php
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
		the_content();
		?>

		<table id="workshop-report-table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Date</th>
					<th>Registered</th>
					<th>Attended</th>
				<tr>
			</thead>
			<tbody>
				<?php dlinq_workshop_report();?>
			</tbody>
		</table>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
