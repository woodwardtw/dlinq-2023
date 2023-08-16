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
				<?php the_field('summary'); ?>
			</div>
        </div>
        <div class="col-md-5 offset-md-2">
            <h2>People</h2>
        </div>
	</div><!-- .entry-content -->
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
