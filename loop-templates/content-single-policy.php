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
		<div class='col-md-5  policy-details'>
			<h2>Contacts</h2>
			<div class="senior-admin detail">				
				Responsible senior administrator: <?php the_field('responsible_senior_administrator');?>	
			</div>
			<div class="policy-contact detail">
				Policy contact: <?php the_field('policy_contact');?>	
			</div>
		</div>
		<div class='col-md-5 offset-md-1 policy-details'>
			<h2>Relevant dates</h2>
			<div class="date detail">			
				Effective date: <?php the_field('effective_date');?>
			</div>	
			<div class="date detail">			
				Last updated: <?php echo dlinq_last_edit();?>
			</div>
			<div class="date detail">			
				Next review date: <?php echo dlinq_policy_review_date();?>	
			</div>
		</div>

	</div>
	<?php echo dlinq_acf_maker('purpose'); ?>
	<?php echo dlinq_acf_maker('scope'); ?>
	<?php echo dlinq_acf_maker('exclusions'); ?>
	<?php echo dlinq_policy_definitions();?>
	<?php echo dlinq_acf_maker('policy'); ?>
    
    <div class="topic-row row">
		<div class="col-md-8 offset-md-2">
			<?php echo dlinq_acf_policies(); ?>
        </div>       
    </div>
    <?php echo dlinq_policy_changes();?>
    
	<?php get_template_part( 'loop-templates/content', 'flexcontent' );?>
  
	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
