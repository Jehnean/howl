<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Listify
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!-- <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"> -->

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,100' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div class="primary-header">
			<div class="container">
				<div class="primary-header-inner">
					<div class="site-branding">
							<?php if(is_front_page() || is_page("professional-services") || is_page("how-it-works-professionals") || is_page("about") || is_page("contact-us") || is_page("help") || is_page("join-as-pro")){ ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="custom-header"><img src="/howl-content/uploads/2016/01/howl-logo-white-small.png" alt=""></a>
							<?php }else{ ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="custom-header"><img src="/howl-content/themes/listify/images/howl-dark-logo.png" alt=""></a>
							<?php } ?>

						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>

					<div class="mini-menu-container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'mini-menu',
								'container_class' => 'mini-menu'
							) );
						?>
					</div>

					<div class="primary nav-menu">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'container_class' => 'nav-menu-container'
							) );
						?>
					</div>
				</div>

			</div>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<a href="#" class="navigation-bar-toggle">
					<i class="ion-navicon-round"></i>
					<?php echo listify_get_theme_menu_name( 'primary' ); ?>
				</a>

				<div class="navigation-bar-wrapper">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container_class' => 'primary nav-menu',
							'menu_class' => 'primary nav-menu'
						) );
					?>
					<!-- notifications -->

				</div>


			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php do_action( 'listify_content_before' ); ?>

	<div id="content" class="site-content">
