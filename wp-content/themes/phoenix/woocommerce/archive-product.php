<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$page_id = get_option( 'woocommerce_shop_page_id' );
get_header( 'shop' ); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>


  <section class="generic-template has-featured-image">
     <div class="container">
       <?php if(get_the_post_thumbnail_url($page_id) ?? false): ?>
      <div class="row">
        <div class="col text-center">
          <img src="<?= get_the_post_thumbnail_url($page_id);?>" class="featured-img img-fluid" alt=""/>
        </div>
      </div>
     <?php endif;?>
     <div class="row">
       <div class="col">
         <h1 class="h2 text-center"><?= the_field('headline', $page_id) ?></h1>
        <header class="woocommerce-products-header body-container">

      		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

      			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

      		<?php endif; ?>

      		<?php
      			/**
      			 * woocommerce_archive_description hook.
      			 *
      			 * @hooked woocommerce_taxonomy_archive_description - 10
      			 * @hooked woocommerce_product_archive_description - 10
      			 */
      			do_action( 'woocommerce_archive_description' );
      		?>

        </header>

    </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="body-container">



		<?php if ( have_posts() ) : ?>

      <?php
      // get all terms for the products
      $terms = get_terms('product_cat');
      foreach($terms as $term):
        $product_category_query = new WP_Query( array(
             'post_type' => 'product',
             'tax_query' => array(
                 array(
                     'taxonomy' => 'product_cat',
                     'field' => 'slug',
                     'terms' => array( $term->slug ),
                     'operator' => 'IN'
                 )
             )
         ) );
         ?>
          <div class="product-selector product-archive">
            <div class="row">
               <div class="col-12">
                 <h4 class="body-3 text-center"><?php echo $term->description; ?></h4>
               </div>
            </div>
            <div class="row justify-content-center product-container ">
           <?php
           if ( $product_category_query->have_posts() ) : while ( $product_category_query->have_posts() ) : $product_category_query->the_post(); ?>
           <?php
            $id = get_the_ID();
            $image = get_field('cropped_image', $id);
           ?>
            <div class="col-md-4">
              <figure>
                <a href="<?= get_permalink(); ?>">
                  <img class="product-shot" src="<?= $image['url']; ?>" alt=""/>
                </a>
                <figcaption>
                  <?php
                    $product_attributes = array(
                      'volume' => get_the_terms($id, 'pa_jar-vol-fl-oz')[0]->name ?? false,
                      'diameter' => get_the_terms($id, 'pa_diameter')[0]->name ?? false,
                      'depth' => get_the_terms($id, 'pa_jar-vol-dram')[0]->name ?? false
                    );
                  ?>
                  <ul class="product-attributes">
                    <?= $product_attributes['diameter'] ? '<li>'.$product_attributes['diameter'].'</li>' : ''?>
                    <?= $product_attributes['volume'] ? '<li>'.$product_attributes['volume'].'</li>' : ''?>
                    <?= $product_attributes['depth'] ? '<li>'.$product_attributes['depth'].'</li>' : ''?>
                  </ul>
                  <a rel="nofollow" href="/cart/?add-to-cart=<?= $id ?>" data-quantity="1" data-product_id="<?= $id ?>" data-product_sku="" class="button product_type_simple add_to_cart_button ajax_add_to_cart">Buy</a>
                </figcaption>
              </figure>
            </div>
           <?php endwhile; endif; ?>
          </div>
           <?php
           // Reset things, for good measure
           $product_category_query = null;
           wp_reset_postdata();
           ?>
        </div>
         <?php
      endforeach;

      ?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>

<?php
$content = get_field('product_module', $page_id);
 if($content):
?>
   <section class="product-module -less-padding -version-<?= $content['product_module_style']?> off">
     <div class="container off">
       <div class="row">
         <div class="col mx-auto text-center">
           <img src="<?= $content['animated_image_group']['animated_image']['url'] ?>" alt="<?= $content['animated_image_group']['animated_image']['alt'] ?>" class="img-primary"/>
         </div>
       </div>
       <div class="row">
         <div class="col-md-8 mx-auto text-center">
           <h2><?= $content['animated_headline_group']['animated_headline'] ?></h2>
         </div>
       </div>
       <div class="row">
         <div class="col-10 mx-auto">
           <?= $content['animated_body_copy_group']['animated_body_copy'] ?>
         </div>
       </div>
       <div class="row cta cta-wrapper">
         <div class="col-6 mx-auto text-center">
           <p><a href="<?= $content['animated_link_group']['animated_link']['url'] ?>" target="<?= $content['animated_link_group']['animated_link']['target'] ?>" class="fancyHover"><?= $content['animated_link_group']['animated_link']['title']; ?></a></p>
         </div>
       </div>
     </div>
   </section>
<?php
 endif;
?>

  </div>
  </div>
  </div>
  </div>
  </section>
<?php get_template_part('templates/footer'); ?>
