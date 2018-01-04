<?php
  //
  use Roots\Sage\Extras;
  $logo = get_field('logo', 'options');
?>
<header class="banner" id="header">
  <div class="container">
    <div class="row">
      <div class="brand-col">
        <a class="brand" href="<?= esc_url(home_url('/')); ?>">
          <img class="logo" src="<?= $logo['url'] ?? ''?>" alt="<?php bloginfo('name'); ?>"/>
        </a>
      </div>
      <div class="nav-col text-right">
        <div class="cart-nav">
          <?php
          Extras\sk_wcmenucart();
          ?>
        </div>
    </div>
  </div>
  <nav class="nav-primary">
    <div class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <?php
    if (has_nav_menu('primary_navigation')) :
      wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
    endif;
    ?>
  </nav>
  <?php get_template_part('templates/cart-overlay'); ?>
</header>
