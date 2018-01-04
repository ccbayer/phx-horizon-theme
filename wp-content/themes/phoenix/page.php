<?php while (have_posts()) : the_post(); ?>
  <section class="generic-template <?= has_post_thumbnail() ? 'has-featured-image' : '' ?>">
     <div class="container">
      <?php if(has_post_thumbnail()): ?>
     <div class="row">
       <div class="col text-center">
         <img src="<?= the_post_thumbnail_url();?>" class="featured-img img-fluid" alt=""/>
       </div>
     </div>
    <?php endif;?>
     <div class="row">
       <div class="col text-center">
         <h1 class="h2"><?= get_field('headline') ?></h1>
        </div>
     </div>
     <div class="row">
       <div class="col">
         <div class="body-container">
           <?php get_template_part('templates/content', 'page'); ?>
         </div>
        </div>
      </div>
    </div>
  </section>
<?php endwhile; ?>
<?php get_template_part('templates/footer'); ?>
