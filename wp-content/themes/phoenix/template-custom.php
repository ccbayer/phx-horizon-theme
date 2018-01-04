<?php
/**
 * Template Name: Custom Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <div class="layer layer-1" style="background-image:url('<?= get_stylesheet_directory_uri(); ?>/dist/images/_tmp/hero.jpg');">
    <?php get_template_part('templates/hero'); ?>
  </div>
  <div class="layer layer-2">
    <?php get_template_part('templates/intro'); ?>
    <?php get_template_part('templates/side-by-side'); ?>
    <?php get_template_part('templates/product-module', 'a'); ?>
    <?php get_template_part('templates/product-module', 'b'); ?>
    <?php get_template_part('templates/product-selector'); ?>
    <?php get_template_part('templates/footer'); ?>
  </div>
<?php endwhile; ?>
