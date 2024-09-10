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

	<div class="entry-content workshop-report">

		<?php
		the_content();
		?>
		<?php if(is_user_logged_in()):?>
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
	<?php else:?>
		Login to see this content.
	<?php endif;?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
