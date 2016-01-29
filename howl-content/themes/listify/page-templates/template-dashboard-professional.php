<?php
/**
 * Template Name: Professional Dashboard
 *
 * @package Listify
 */

get_header(); ?>

    <div class="page-cover entry-cover no-image">
        <h1 class="page-title cover-wrapper"><?php the_post(); the_title(); rewind_posts(); ?></h1>
    </div>

    <?php do_action( 'listify_page_before' ); ?>

    <div id="primary" class="container">
        <div class="row content-area">

            <main id="main" class="site-main col-md-10 col-md-offset-1 col-xs-12" role="main">

                <?php if ( listify_has_integration( 'woocommerce' ) ) : ?>
                    <?php wc_print_notices(); ?>
                <?php endif; ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>

            </main>

        </div>
    </div>

<?php get_footer(); ?>
