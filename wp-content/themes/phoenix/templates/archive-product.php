<?php get_template_part('templates/page', 'header'); ?>

<?php
$title = get_field('headline') ?: get_the_title();
?>
<?php while (have_posts()) : the_post(); ?>
<section class="generic-template">
   <div class="container">
   <div class="row">
     <div class="col text-center">
       <h1 class="h2"><?= $title ?></h1>
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
<?php endwhile; ?>
<?php get_template_part('templates/footer'); ?>
