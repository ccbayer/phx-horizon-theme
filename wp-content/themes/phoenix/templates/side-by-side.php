<?php
/**
* Partial: side-by-side
**/

use Roots\Sage\Extras;

$side_by_side = array(
  'background_color' => get_field('background_color_group') ?: $content['background_color_group'],
  'headline' => get_field('side_by_side_headline_animated_headline_group') ?: $content['side_by_side_headline_animated_headline_group'],
  'body_copy' => get_field('side_by_side_body_copy_animated_body_copy_group') ?: $content['side_by_side_body_copy_animated_body_copy_group'],
  'image' => get_field('side_by_side_image_animated_image_group') ?: $content['side_by_side_image_animated_image_group'],
  'link' => get_field('side_by_side_link_animated_link_group') ?: $content['side_by_side_link_animated_link_group'],
  'section_animate' => get_field('side_by_side_animation_options_section_animate') ?: $content['side_by_side_animation_options_section_animate'] ?? false,
  'section_animation_options' => ' animated ',
  'component_animation' => '',
  'id' => get_field('id') ?: $content['id'] ?: uniqid('sbs-')
);

if($side_by_side['section_animate']):
  $side_by_side['section_animation_options'].= get_field('intro_animation_options_section_animation_options') ?: $content['intro_animation_options_section_animation_options'];
else:
  $side_by_side['section_animation_options'] = '';
  $side_by_side['component_animation'] = ' data-animation="true" data-offset=".5"';
endif;


?>
<style>
  <?php if($side_by_side['background_color']['background_color']['background_color_hex']): ?>
  #<?= $side_by_side['id'] ?> .bg {
    background: linear-gradient(90deg, <?= $side_by_side['background_color']['background_color']['background_color_hex'] ?> 50%,transparent 0) !important;
  }
  <?php endif; ?>
  <?php if($side_by_side['headline']['animated_headline_color_text_color']): ?>
    #<?= $side_by_side['id'] ?> .content h2 {
      color: <?= $side_by_side['headline']['animated_headline_color_text_color'] ?> !important;
    }
  <?php endif;?>
  <?php if($side_by_side['link']['animated_link_color_text_color']): ?>
    #<?= $side_by_side['id'] ?> .content .cta-wrapper a {
      color: <?= $side_by_side['link']['animated_link_color_text_color'] ?> !important;
    }
  <?php endif;?>
</style>
<section id="<?= $side_by_side['id'] ?>" class="side-by-side <?= $side_by_side['section_animation_options'] ?>  off" <?= $side_by_side['component_animation']; ?>>
  <div class="bg" data-animate="true" data-animations='[
    {
      "triggerHook": ".66",
      "attachToScroll": false,
      "duration": ".5",
      "type": "fromTo",
      "from": {"left": "-500", "opacity": "0"},
      "to": {"left": "0", "opacity": "1"}
    }
  ]'></div>
  <div class="container">
    <div class="row no-gutters align-items-center">
      <div class="col-md-6">
        <div class="content">
          <h2<?= Extras\constructAnimationAttributes($side_by_side, 'headline');?>><?= $side_by_side['headline']['animated_headline']; ?></h2>
          <div<?= Extras\constructAnimationAttributes($side_by_side, 'body_copy');?>><?= $side_by_side['body_copy']['animated_body_copy']; ?></div>
          <p<?= Extras\constructAnimationAttributes($side_by_side, 'link');?> class="cta-wrapper"><a href="<?= $side_by_side['link']['animated_link']['url'] ?>" target="<?= $side_by_side['link']['animated_link']['target'] ?>" class="fancyHover"><?= $side_by_side['link']['animated_link']['title'] ?> ></a></p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="image-container left">
          <img <?= Extras\constructAnimationAttributes($side_by_side, 'image');?> src="<?= $side_by_side['image']['animated_image']['url']?>" alt="<?= $side_by_side['image']['animated_image']['alt'] ?>" class="side-by-side-img <?= $side_by_side['image']['animated_image_add_rotation'] ? 'image-rotate' : '' ?>"/>
        </div>
      </div>
    </div>
  </div>
</section>
