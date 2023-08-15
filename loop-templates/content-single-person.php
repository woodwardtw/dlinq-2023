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
				<?php the_field('biography'); ?>
			</div>
        </div>
        <div class="col-md-5 offset-md-2">
            
        </div>
	</div><!-- .entry-content -->
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
