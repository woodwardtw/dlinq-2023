<?php
/**
 * Single policy partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
		<?php dlinq_topic_events($post->post_name);?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="topic-row row">
        <div class="col-md-8 offset-md-2">
        	<?php echo dlinq_last_edit();?>
			<?php //the_field('topic_summary'); ?>
			<?php echo dlinq_acf_maker('purpose'); ?>
        </div>        
	</div>
	<div class="topic-row row">
		<div class="col-md-8 offset-md-2">
			<?php echo dlinq_acf_maker('scope'); ?>
        </div>
    </div>
    <div class="topic-row row">
		<div class="col-md-8 offset-md-2">
			<?php echo dlinq_acf_maker('exclusions'); ?>
        </div>
    </div>
    <div class="topic-row row">
		<div class="col-md-8 offset-md-2">
			<?php echo dlinq_acf_maker('policy'); ?>
        </div>
    </div>
    <div class="topic-row row">
		<div class="col-md-8 offset-md-2">
			<?php echo dlinq_acf_policies(); ?>
        </div>       
    </div>
	<?php get_template_part( 'loop-templates/content', 'flexcontent' );?>
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
