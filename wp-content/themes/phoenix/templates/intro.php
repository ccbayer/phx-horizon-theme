<?php
/**
* Partial: INTRO
**/

use Roots\Sage\Extras;
$intro = [
  'headline' => get_field('intro_headline_animated_headline_group') ?: $content['intro_headline_animated_headline_group'],
  'body_copy' => get_field('intro_body_copy_animated_body_copy_group') ?: $content['intro_body_copy_animated_body_copy_group'],
  'image' => get_field('intro_image_animated_image_group') ?: $content['intro_image_animated_image_group'],
  'content_block_columns' => get_field('intro_content_block_columns') ?: $content['intro_content_block_columns'],
  'section_animate' => get_field('intro_animation_options_section_animate') ?: $content['intro_animation_options_section_animate'],
  'section_animation_options' => ' animated ',
  'component_animation' => '',
  'id' => get_field('id') ?: $content['id'] ?: uniqid('intro-')
];

if($intro['section_animate']):
  $intro['section_animation_options'].= get_field('intro_animation_options_section_animation_options') ?: $content['intro_animation_options_section_animation_options'];
else:
  $intro['section_animation_options'] = '';
  $intro['component_animation'] = ' data-animation="true" data-offset=".5"';
endif;
?>
<style>
  <?php if($intro['headline']['animated_headline_color_text_color']): ?>
    #<?= $intro['id'] ?> h2 {
      color: <?= $intro['headline']['animated_headline_color_text_color'] ?> !important;
    }
  <?php endif;?>
</style>
<section id="<?= $intro['id'] ?>" class="intro <?= $intro['section_animation_options'] ?> off" <?= $intro['component_animation']; ?>>
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto text-center">
        <h2<?= Extras\constructAnimationAttributes($intro, 'headline');?>><?= $intro['headline']['animated_headline']; ?></h2>
        <div<?= Extras\constructAnimationAttributes($intro, 'body_copy');?>><?= $intro['body_copy']['animated_body_copy']; ?></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto text-center">
        <img<?= Extras\constructAnimationAttributes($intro, 'image');?> src="<?= $intro['image']['animated_image']['url'] ?>" alt="<?=$intro['image']['animated_image']['alt'] ?>" class="intro-image img-fluid"/>
      </div>
    </div>
    <div class="row justify-content-center">
      <?php foreach($intro['content_block_columns'] as $col): ?>
      <div class="col-md-5">
        <?php foreach($col['intro_content_blocks'] as $block): ?>
          <?php
            $arr = [
              'container' => $block['container']['animated_container_group']
            ];
          ?>
          <div<?= Extras\constructAnimationAttributes($arr, 'container');?> class="content-block <?= $block['padding_top'] ? 'offset' : '' ?>">
            <h3><?= $block['headline']; ?></h3>
            <?= $block['body_copy']; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
