<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Listify
 */
?>
	<div id="secondary" class="widget-area col-md-4 col-sm-5 col-xs-12" role="complementary">
		<?php //if ( ! dynamic_sidebar( 'widget-area-sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="meta" class="widget">
				<h3 class="widget-title">ANSWERS FOR CUSTOMERS AND PROFESSIONALS.</h3>
				<ul id="help-tabs" class="nav nav-pills nav-stacked" data-tabs="tabs">
					<li role="tabpanel" class="active"><a href="#customer" data-toggle="tab">Customers</a></li>
					<li role="tabpanel"><a href="#professional" data-toggle="tab">Professionals</a></li>
				</ul>
			</aside>

		<?php // endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
