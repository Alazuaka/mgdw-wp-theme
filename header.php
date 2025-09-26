<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?> <!-- Здесь WP добавит стили, JS и мета из functions.php и плагинов -->
</head>

<body <?php body_class(); ?>>
  <!-- <body> -->
  <header class="header">
    <div class="header__top">
      <div class="container header__top-container">
        <a class="header__logo" href="<?= home_url(); ?>">
          <img class="header__logo-img logo" src="<?php echo get_theme_mod('logo_header', get_template_directory_uri() . '/assets/img/logo-header.svg'); ?>" alt="<?php bloginfo('name'); ?>">
        </a>
        <div class="header__topbar topbar">
          <ul class="list-reset hidden-xs topbar__about topbar__nav">
            <?php
            wp_nav_menu([
              'theme_location' => 'header_submenu',
              'container' => false,
              'menu_class' => '',
              'menu_id' => '',
              'items_wrap' => '%3$s',
              // 'walker' => new Custom_Walker_Nav_Menu(), // Твой кастомный walker
              // 'depth' => 1
            ]);
            ?>
          </ul>
          <a class="topbar__contact">
            <span class="topbar__phone phone-number hidden-xs">+7(812) 448-08-10</span>
            <img class="topbar__phone-icon hidden-xl" src="/html/phone_icon.svg">
          </a>
          <a class="btn topbar__call-back btn-call-me hidden-xs">Перезвоните мне</a>
          <button type="button" class="topbar__toggle toggle hidden-xl">
            <span class="toggle__sr-only">Переключатель навигации</span>
            <span class="toggle__ico"></span>
            <span class="toggle__ico"></span>
            <span class="toggle__ico"></span>
          </button>
        </div>
      </div>
    </div>

    <div class="header__bottom">
      <div class="container header__bottom-container">
        <div class="header__contact-xs contact-xs hidden-xl">
          <a class="btn contact-xs__btn btn-call-me link">Перезвоните мне</a>
          <a class="contact-xs__phone phone-number link">+7(812) 448-08-10</a>
        </div>
        <nav class="header__nav">
          <ul class="list-reset header__nav-list">
            <?php
            wp_nav_menu([
              'theme_location' => 'header_main_menu',
              'container' => false,
              'menu_class' => '',
              'menu_id' => '',
              'items_wrap' => '%3$s',
              'walker' => new Custom_Walker_Nav_Menu(), // Твой кастомный walker
              'depth' => 2
            ]);
            ?>
          </ul>
          <ul class="list-reset header__nav-extra-list hidden-xl">
            <?php
            wp_nav_menu([
              'theme_location' => 'header_submenu',
              'container' => false,
              'menu_class' => '',
              'menu_id' => '',
              'items_wrap' => '%3$s',
              'walker' => new Custom_Walker_Nav_Menu(), // Твой кастомный walker
              'depth' => 2
            ]);
            ?>
          </ul>
        </nav>
      </div>
    </div>
  </header>