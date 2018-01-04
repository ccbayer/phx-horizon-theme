<?php
/**
 * Template Name: Custom Template
 */

 $hero = get_field('page_hero');
 $hero_content = [
   'img' => get_field('hero_background_image'),
   'headline' => get_field('hero_headline'),
   'subheadline' => get_field('hero_subheadline'),
   'cta' => get_field('hero_call_to_action')
 ];
?>

<?php while (have_posts()) : the_post(); ?>
  <div class="layer layer-1 lazyload" data-bg="<?= $hero_content['img']['url'] ?? '' ?>">
    <?php include(locate_template('templates/hero.php')); ?>
  </div>
  <div class="layer layer-2" id="next">

    <?php
      $flex_content = get_field('flexible_content');
      //var_dump($flex_content);
      foreach($flex_content as $content) {
        if($content['acf_fc_layout'] === 'product-module'):
          // which style
          include(locate_template('templates/'.$content['acf_fc_layout'].'-'.$content['product_module_style'].'.php'));
        else:
          include(locate_template('templates/'.$content['acf_fc_layout'].'.php'));
        endif;
      }
    ?>
    <?php
      get_template_part('templates/footer');
    ?>
  </div>
<?php endwhile; ?>
