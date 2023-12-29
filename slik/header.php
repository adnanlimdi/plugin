<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$we_are_hiring_link     = get_field('we_are_hiring_link','option');
$join_us_link           = get_field('join_us_link','option');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->

  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
  <meta name="theme-color" content="#ebf9ff">
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/assets/images/favicon.svg">

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
  
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/vender/fontawesome/css/all.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/vender/swiper/css/swiper-bundle-min.css">
  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/vender/bootstrap/css/bootstrap.min.css">

  <!-- CSS Front Template -->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/responsive.css">
</head>

<body <?php body_class(); ?>>
  <!-- Header -->
  <header>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="<?php echo home_url(); ?>" title="Casaclub"><img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.svg" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <?php
            wp_nav_menu(
              array(
              'theme_location' => 'primary',
              'menu_class'     => '',
              'items_wrap' => '<ul class="navbar-nav">%3$s</ul>',
              )
            );
          ?>
          <div class="header-right">
            <?php if($we_are_hiring_link) { ?>
            <div class="hiring-btn">
              <a href="<?php echo $we_are_hiring_link['url']; ?>" target="<?php echo $we_are_hiring_link['target']; ?>" class="btn" title="<?php $we_are_hiring_link['title']; ?>"><?php echo $we_are_hiring_link['title']; ?></a>
            </div>
            <?php } ?>

            <?php if ( !is_user_logged_in() ) { ?>
            <?php if($join_us_link) { ?>
            <div class="join">
              <a href="<?php echo $join_us_link['url']; ?>" target="<?php echo $we_are_hiring_link['target']; ?>" title="<?php $join_us_link['title']; ?>"><?php echo $join_us_link['title']; ?></a>
            </div>
           <?php } }?>
           <?php if ( is_user_logged_in() ) { ?>
            <?php $class = ''; if(is_page( 'my-account' )){ 
              $class = 'active'; } ?>
            <a href="<?php echo site_url(); ?>/my-account" class="login my-account <?php echo $class; ?>" title="My Account">My Account</a>

            <a class="login-out my-account" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
           <?php }else{ ?>
           <a href="<?php echo site_url(); ?>/login" class="login" title="Login">Login</a>
           <?php } ?>  
          </div>
        </div>

      </nav>
    </div>
  </header>
  <!-- End Header -->