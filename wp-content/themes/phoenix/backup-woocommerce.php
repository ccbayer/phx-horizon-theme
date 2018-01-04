<?php
  if(is_archive('product')):
    $content = get_field('product_page', 'options');
    // get cateogories for products

   $args = array(
          'taxonomy'     => 'product_cat',
   );
   $all_categories = get_categories( $args );
  else:
    $content['headline'] = the_title();
  endif;
?>
<?php if ( have_posts() ) : ?>
<section class="generic-template">
 <div class="container">
    <?php if($content['featured_image'] ?? false): ?>
   <div class="row">
     <div class="col text-center">
       <img src="<?= $content['featured_image']['url']?>" class="featured-img img-fluid" alt=""/>
     </div>
   </div>
  <?php endif;?>
   <div class="row">
     <div class="col text-center">
       <h1 class="h2"><?= $content['headline'] ?></h1>
      </div>
   </div>
   <div class="row">
     <div class="col">
       <div class="body-container">
         <?php woocommerce_content(); ?>
      </div>
     </div>
   </div>
 </div>
</section>
<?php endif; ?>
<?php get_template_part('templates/footer'); ?>
