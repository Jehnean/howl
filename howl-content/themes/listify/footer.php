<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Listify
 */
?>

	</div><!-- #content -->

	<div class="footer-wrapper">

		<?php if ( ! listify_is_job_manager_archive() ) : ?>

			<?php get_template_part( 'content', 'cta' ); ?>

			<?php get_template_part( 'content', 'aso' ); ?>

		<?php endif; ?>

		<?php if ( is_active_sidebar( 'widget-area-footer-1' ) || is_active_sidebar( 'widget-area-footer-2' ) || is_active_sidebar( 'widget-area-footer-3' ) || is_active_sidebar( 'widget-area-footer-4' ) ) : ?>

			<footer class="site-footer-widgets">
				<div class="container">
					<div class="row">

						<div class="footer-widget-column col-xs-12 col-sm-12 col-lg-3">
							<?php dynamic_sidebar( 'widget-area-footer-1' ); ?>
						</div>

						<div class="footer-widget-column col-xs-12 col-sm-6 col-lg-3">
							<?php dynamic_sidebar( 'widget-area-footer-2' ); ?>
						</div>

						<div class="footer-widget-column col-xs-12 col-sm-6 col-lg-3">
							<?php dynamic_sidebar( 'widget-area-footer-3' ); ?>
						</div>

						<div class="footer-widget-column col-xs-12 col-sm-6 col-lg-3">
							<?php dynamic_sidebar( 'widget-area-footer-4' ); ?>
						</div>

					</div>
				</div>
			</footer>

		<?php endif; ?>



		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">

				<div class="site-info">
					<?php echo listify_theme_mod( 'copyright-text' ); ?>
				</div><!-- .site-info -->

				<div class="site-social">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'menu_class' => 'nav-menu-social',
						'fallback_cb' => '',
						'depth' => 1
					) ); ?>
				</div>

			</div>
		</footer><!-- #colophon -->

	</div>

</div><!-- #page -->

<div id="ajax-response"></div>

<?php wp_footer(); ?>

</body>
</html>
