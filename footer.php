<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">
			<div class="col-md-3">
					<?php wp_nav_menu( array( 'theme_location' => 'footer-left', 'container_class' => 'footer-menu' ) ); ?>
				</div>
				<div class="col-md-6">
					<?php get_sidebar('footercenter');?>
				</div>
				<div class="col-md-3">
					<?php wp_nav_menu( array( 'theme_location' => 'footer-right', 'container_class' => 'footer-menu' ) ); ?>
				</div>

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">
						<div class="row">
							
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

<?php wp_footer(); ?>

<!--form modal-->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-slideout">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="formModalLabel">Contact DLINQ</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <?php  
        		$gf_id = get_field('contact_gravity_form', 'option');
        		gravity_form( $gf_id, false, false, false, false, true, false, true ); ?>
      </div>     
    </div>
  </div>
</div>

<!--search modal-->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-slideout">
    <div class="modal-content">
    	 <h2 class="modal-title" id="searchModalLabel">Search</h2>
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

</body>

</html>

