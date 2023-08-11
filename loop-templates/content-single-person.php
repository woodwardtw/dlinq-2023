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

	<header class="entry-header row">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->


	<div class="entry-content row">
        <div class="col-md-5">
			<h2><?php the_field('job_title') ;?></h2>           
            Pronouns: <?php the_field('pronouns'); ?>
		  <!--bio details-->
            <div class="bio">
                    <?php the_field('biography'); ?>
            </div>
        </div>
        <div class="col-md-5 offset-md-2">
            <?php 
            $image = get_field('bio_image');
            if( !empty( $image ) ): ?>
                <img class="img-fluid bio-pic" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
            <?php endif; ?>
            	<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
        </div>
	</div><!-- .entry-content -->
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
