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
                <!-- <h2>About</h2> -->
				<?php the_field('biography');?>
				<?php dlinq_person_links();?>
			</div>
        </div>
        <div class="col-md-6 offset-md-1">
			<div class="person-project-box">
           		<?php dlinq_person_projects();?>
			</div>
        </div>
	</div><!-- .entry-content -->
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
