<?php
/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-summary">

		<?php the_excerpt(); ?>
		<?php if(!the_excerpt()){
					the_field('topic_summary'); 
					the_field('project_summary'); 
				}
			?>


	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">
			<div class="col-md-4">
				  <?php the_field('footer_left','option');?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-left', 'container_class' => 'footer-menu' ) ); ?>
				</div>
				<div class="col-md-4">
					<?php the_field('footer_middle','option');?>
					<?php get_sidebar('footercenter');?>
				</div>
				<div class="col-md-4">
					<?php the_field('footer_right','option');?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-right', 'container_class' => 'footer-menu' ) ); ?>
				</div>
				<div class="col-lg-3">

          <a href="https://www.middlebury.edu">
            <img src="https://www.middlebury.edu/themes/custom/middlebury_theme/images/middlebury-logo-white.svg" alt="Middlebury" width="195" height="71">
          </a>

      </div>
      <div class="col-lg-9">

        <ul class="midd-footer__list">
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/about" class="midd-footer__link">About Middlebury</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/alumni-and-families" class="midd-footer__link">Giving</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/human-resources/work-middlebury" class="midd-footer__link">Employment</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/offices-services" class="midd-footer__link">Offices and Services</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/about/copyright" class="midd-footer__link">Copyright</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/about/website-privacy-policy" class="midd-footer__link">Privacy</a>
          </li>
          <li class="midd-footer__item">
            <a href="https://www.middlebury.edu/emergency-response" class="midd-footer__link">Emergency</a>
          </li>         
        </ul>

      </div>

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">
						<div class="row">
								<?php the_field('footer_full','option');?>
						</div>

						<?php //understrap_site_info(); ?>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!-- col -->

		</div><!-- .row -->

	</div><!-- .container(-fluid) -->

</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<!--form modal-->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-slideout">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="formModalLabel">Contact DLINQ</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php  
        		$gf_id = get_field('contact_gravity_form', 'option');
        		gravity_form( $gf_id, false, false, false, false, true, false, true ); 
        		?>
      </div>     
    </div>
  </div>
</div>

<!--search modal-->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-slideout">
    <div class="modal-content">
    	<div class="modal-header">
    		<h2 class="modal-title" id="searchModalLabel">Search</h2>
    	 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    	</div>    	 
			<form role="search" method="get" class="search-form" action="/">
				<label>
					<span class="screen-reader-text">Search for:</span>
					<input type="search" class="search-field" placeholder="Search …" name="s"
			          data-rlvlive="true" data-rlvparentel="#rlvlive" data-rlvconfig="default">
				</label>
				<input type="submit" class="search-submit" value="Search">
			    <div id="rlvlive"></div>
			</form>
		</div>
	</div>
</div>

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
