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
	<div class='topic-row row'>
		<div class='col-md-4 offset-md-2 policy-details'>
			<h2>Contacts</h2>
			<div class="senior-admin detail">				
				Responsible senior administrator: <?php the_field('responsible_senior_administrator');?>	
			</div>
			<div class="senior-admin detail">
				Policy contact: <?php the_field('policy_contact');?>	
			</div>
		</div>
		<div class='col-md-4 policy-details'>
			<h2>Relevant dates</h2>			
			Last updated: <?php echo dlinq_last_edit();?>
		</div>

	</div>
	<?php echo dlinq_acf_maker('purpose'); ?>
	<?php echo dlinq_acf_maker('scope'); ?>
	<?php echo dlinq_acf_maker('exclusions'); ?>
	<?php echo dlinq_acf_maker('policy'); ?>
    
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
