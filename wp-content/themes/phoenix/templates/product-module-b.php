<?php
/**
* Partial: product module b
**/
use Roots\Sage\Extras;

$product_module = [
  'background_color' => get_field('product_module_background_color') ?: $content['product_module_background_color'],
  'headline' => get_field('product_module_headline_animated_headline_group') ?: $content['product_module_headline_animated_headline_group'],
  'body_copy' =>  get_field('product_module_body_copy_animated_body_copy_group') ?: $content['product_module_body_copy_animated_body_copy_group'],
  'link' =>  get_field('product_module_link_animated_link_group') ?: $content['product_module_link_animated_link_group'],
  'image' => get_field('product_module_image_animated_image_group') ?: $content['product_module_image_animated_image_group'],
  'section_animate' => get_field('product_module_animation_options_section_animate') ?: $content['product_module_animation_options_section_animate'] ?? false,
  'section_animation_options' => ' animated ',
  'component_animation' => '',
  'id' => get_field('id') ?: $content['id'] ?: uniqid('prod-mod-b-')
];

if($product_module['section_animate']):
  $product_module['section_animation_options'].= get_field('intro_animation_options_section_animation_options') ?: $content['intro_animation_options_section_animation_options'];
else:
  $product_module['section_animation_options'] = '';
  $product_module['component_animation'] = ' data-animation="true" data-offset=".5"';
endif;
?>
<style>
  <?php if($product_module['background_color']['background_color_hex']): ?>
  #<?= $product_module['id'] ?> .container {
    background-color: <?= $product_module['background_color']['background_color_hex'] ?> !important;
  }
  <?php endif; ?>
  <?php if($product_module['headline']['animated_headline_color_text_color']): ?>
    #<?= $product_module['id'] ?>  h2 {
      color: <?= $product_module['headline']['animated_headline_color_text_color'] ?> !important;
    }
  <?php endif;?>
  <?php if($product_module['link']['animated_link_color_text_color']): ?>
    #<?= $product_module['id'] ?>  .cta-wrapper p a {
      color: <?= $product_module['link']['animated_link_color_text_color'] ?> !important;
    }
  <?php endif;?>
</style>

<section id="<?= $product_module['id'] ?>" class="product-module -version-b <?= $product_module['section_animation_options'] ?> off" <?= $product_module['component_animation']; ?>>
  <div class="container off">
    <div class="row">
      <div class="col-md-8 mx-auto text-center">
        <h2 <?= Extras\constructAnimationAttributes($product_module, 'headline')?>><?= $product_module['headline']['animated_headline'] ?></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 mx-auto text-center">
        <img src="<?= $product_module['image']['animated_image']['url'] ?>" alt="<?= $product_module['image']['animated_image']['alt'] ?>" class="img-primary"<?= Extras\constructAnimationAttributes($product_module, 'image'); ?>/>
      </div>
    </div>
    <div class="row">
      <div class="col-10 mx-auto" <?= Extras\constructAnimationAttributes($product_module, 'body_copy');?>>
        <?= $product_module['body_copy']['animated_body_copy'] ?>
      </div>
    </div>
    <div class="row cta cta-wrapper">
      <div class="col-6 mx-auto text-center" <?= Extras\constructAnimationAttributes($product_module, 'link');?>>
        <p><a href="<?= $product_module['link']['animated_link']['url'] ?>" target="<?= $product_module['link']['animated_link']['target'] ?>" class="fancyHover"><?= $product_module['link']['animated_link']['title']; ?></a></p>
      </div>
    </div>
  </div>
</section>
