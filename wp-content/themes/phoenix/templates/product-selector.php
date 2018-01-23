<?php
/**
* Partial: product selector
**/

$product_module = [
  'headline' => get_field('product_selector_headline') ?: $content['product_selector_headline'],
  'description' =>  get_field('product_selector_description') ?: $content['product_selector_description'],
  'products' => get_field('product_selector_categories') ?: $content['product_selector_categories']
];

// set up product array
$productArray = array();

foreach($product_module['products'] as $cat):
  $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $cat['product_category']
                    )
                )
            );
  $products = new WP_Query( $args );
  if($products -> have_posts()):
   $productArray['product_'.$cat['product_category']] = $products->posts;
  endif;
  wp_reset_postdata();
endforeach;

// var_dump($productArray);
?>
<section class="product-selector">
  <div class="container">
    <div class="row">
      <div class="col-md-10 mx-auto text-center">
        <h2><?= $product_module['headline'] ?></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="row no-gutters">
          <?php if($product_module['description']):?>
          <div class="col-12 text-center">
            <p class="tertiary"><?= $product_module['description'] ?></p>
          </div>
          <?php endif; ?>
          <div class="col-12 text-center">
            <ul class="selector-list">
              <?php foreach($product_module['products'] as $key=>$value): ?>
                <?php
                  $thisCat = get_term_by('id', $value['product_category'], 'product_cat');
                ?>
                <li <?= $key > 0 ? 'class="selected"' : '' ?>><a href="#<?= $thisCat->slug ?>"><?= $thisCat->name ?></a></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php foreach($product_module['products'] as $key=>$value): ?>
      <?php
        if($key > 0):
          $hide = 'hide';
        else:
          $hide = false;
        endif;
		$thisCat = get_term_by('id', $value['product_category'], 'product_cat');
      ?>
      <div class="row justify-content-center product-container <?= $hide ?>" id="<?= $thisCat->slug ?>">
        <?php
          foreach($productArray['product_'.$value['product_category']] as $prod):
        ?>
        <div class="col-md-4">
          <figure class="product-figure-loop">
            <a rel="nofollow" href="<?= get_permalink($prod->ID);?>">
              <img class="product-shot" src="<?= get_the_post_thumbnail_url($prod->ID) ?>" alt=""/>
            </a>
            <figcaption>
              <?php
                $product_attributes = array(
                  'volume' => get_the_terms($prod->ID, 'pa_jar-vol-fl-oz')[0]->name ?? false,
                  'diameter' => get_the_terms($prod->ID, 'pa_diameter')[0]->name ?? false,
                  'depth' => get_the_terms($prod->ID, 'pa_jar-vol-dram')[0]->name ?? false
                );
              ?>
              <ul class="product-attributes">
                <?= $product_attributes['diameter'] ? '<li>'.$product_attributes['diameter'].'</li>' : ''?>
                <?= $product_attributes['volume'] ? '<li>'.$product_attributes['volume'].'</li>' : ''?>
                <?= $product_attributes['depth'] ? '<li>'.$product_attributes['depth'].'</li>' : ''?>
              </ul>
              <a rel="nofollow" href="/cart/?add-to-cart=<?= $prod->ID ?>" data-quantity="1" data-product_id="<?= $prod->ID ?>" data-product_sku="" class="button product_type_simple add_to_cart_button ajax_add_to_cart">Buy</a>
            </figcaption>
          </figure>
        </div>
        <?php
          endforeach;
        ?>
      </div>
    <?php endforeach ?>
  </div>
</section>
