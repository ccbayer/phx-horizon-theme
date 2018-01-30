<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use Roots\Sage\Assets;

if( function_exists('acf_add_options_page') ) {

  acf_add_options_sub_page('General Site Settings');
  acf_add_options_sub_page('Footer');
  acf_add_options_sub_page('WooCommerce Settings');
}

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  // set theme class on body
  // to do: wire this up to CMS
  $theme = get_field('site_theme', 'options');
  if($theme) {
    $classes[] = 'theme-'.$theme;
  } else {
    // fallback
    $classes[] = 'theme-horizon';
  }
  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
* CUSTOM EDITOR
*/

function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2',  __NAMESPACE__.'\\wpb_mce_buttons_2');
/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {

// Define the style_formats array

    $style_formats = array(
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
*/
        array(
            'title' => 'Paragraph - Body Copy 1',
            'block' => 'p',
            'classes' => 'body-1',
            'wrapper' => false
        ),
        array(
            'title' => 'Paragraph - Body Copy 2',
            'block' => 'p',
            'classes' => 'body-2',
            'wrapper' => false
        ),
        array(
            'title' => 'Paragraph - Body Copy 3',
            'block' => 'p',
            'classes' => 'body-3',
            'wrapper' => false
        ),
        array(
            'title' => 'Paragraph - Body Copy 4',
            'block' => 'p',
            'classes' => 'body-4',
            'wrapper' => false
        ),
        array(
            'title' => 'Paragraph - Body Copy 5',
            'block' => 'p',
            'classes' => 'body-5',
            'wrapper' => false
        ),
        array(
            'title' => 'Paragraph - Body Copy 6',
            'block' => 'p',
            'classes' => 'body-6',
            'wrapper' => false
        ),
        array(
            'title' => ' Body Copy 1',
            'block' => 'span',
            'classes' => 'body-1',
            'wrapper' => false
        ),
        array(
            'title' => 'Body Copy 2',
            'block' => 'span',
            'classes' => 'body-2',
            'wrapper' => false
        ),
        array(
            'title' => 'Body Copy 3',
            'block' => 'span',
            'classes' => 'body-3',
            'wrapper' => false
        ),
        array(
            'title' => 'Body Copy 4',
            'block' => 'span',
            'classes' => 'body-4',
            'wrapper' => false
        ),
        array(
            'title' => 'Body Copy 5',
            'block' => 'span',
            'classes' => 'body-5',
            'wrapper' => false
        ),
        array(
            'title' => 'Body Copy 6',
            'block' => 'span',
            'classes' => 'body-6',
            'wrapper' => false
        ),
        array(
            'title' => 'Headline 1',
            'block' => 'h1',
            'classes' => '',
            'wrapper' => false
        ),
        array(
            'title' => 'Headline 2',
            'block' => 'h2',
            'classes' => '',
            'wrapper' => false
        ),
        array(
            'title' => 'Subhead 1',
            'block' => 'h3',
            'classes' => '',
            'wrapper' => false
        )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}

add_filter( 'tiny_mce_before_init', __NAMESPACE__.'\\my_mce_before_init_insert_formats' );

/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
function cd_add_editor_styles() {
 add_editor_style( Assets\asset_path('styles/editor-styles.css') );
}
add_action( 'init',  __NAMESPACE__.'\\cd_add_editor_styles' );

/**
* ANIMATION FUNCTIONS
*/
function hasAnimation($array, $field){
  // eg: $intro['headline']['animated_headline_add_animation']...
  return $array[$field]['animated_'.$field.'_add_animation'] ?? false;
}

function constructAnimationAttributes($array, $field) {
  $output = '';
  if(hasAnimation($array, $field)) {
    $output .= " data-animate='true' data-animations='[";
    // option the data attribute; an array objects
    $size = sizeof($array[$field]['animated_'.$field.'_animations']);
    foreach($array[$field]['animated_'.$field.'_animations'] as $key=>$value) {

      // trigger hook settings:
      $triggerHook = $value['animated_'.$field.'_animation_trigger_hook'] ? '"triggerHook": "'.$value['animated_'.$field.'_animation_trigger_hook'].'",' : null;
      // attach to scroll settings:
      $attachToScroll = $value['animated_'.$field.'_animation_attach_to_scroll'] ? 'true' : 'false';

      $type = 'fromTo';
      $fromProps = [];
      $toProps = [];

      if($value['animated_'.$field.'_animation_attach_to_scroll']):
        $distance = '
        "distance": "'.$value['animated_'.$field.'_animation_distance'].'",';
      else:
        $distance = false;
      endif;

      // construct options object and array.
      if($value['animated_'.$field.'_animation_animation_properties']):
        foreach($value['animated_'.$field.'_animation_animation_properties'] as $prop) {
            // each prop has a start and stop value
            // the "start" values go into the 'from' property
            // the "end" values to into the 'to' property
              $fromProps[$prop['property']] = $prop['starting_value'];
              $toProps[$prop['property']] = $prop['ending_value'];
        }
        // add rotation
/*        if($value['animated_'.$field.'_animation_rotate']['enable_rotation']):
            $fromProps['rotation'] = 0;
            $toProps['rotation'] = $value['animated_'.$field.'_animation_rotate']['degrees'];
        endif;
*/
        $fromValue = $fromProps ? '"from": '.json_encode($fromProps).',' : '';
        $toValue = $toProps ? '"to": '.json_encode($toProps) : '';
      else:
        $fromValue = $toValue = '';
        if($value['animated_'.$field.'_animation_rotate']['enable_rotation']):
            $fromProps['rotation'] = 0;
            $toProps['rotation'] = $value['animated_'.$field.'_animation_rotate']['degrees'];
        endif;
        $fromValue = $fromProps ? '"from": '.json_encode($fromProps).',' : '';
        $toValue = $toProps ? '"to": '.json_encode($toProps) : '';
      endif;
      /*
      if($value['animated_'.$field.'_animation_rotate']['enable_rotation']):
          $toValue = '"to": { "rotation": '.$value['animated_'.$field.'_animation_rotate']['degrees'].' }';
          $fromValue = false;
      endif;
      */


      $duration = $value['animated_'.$field.'_animation_duration'] ?: '1.5';
      $output.= '
      {
        "attachToScroll": '.$attachToScroll.',
        '.$triggerHook.'
        "duration": "'.$duration.'",'.$distance.'
        "type": "'.$type.'",
        '.$fromValue
        .$toValue.'
      }';
      if($key + 1 !== $size) {
        $output.=',';
      }
    }
    // close the array.
    $output .= "]'";
  }
  return $output;
}


/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


/* WOO COMMERCE */
add_filter('woocommerce_show_page_title', '__return_false');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

function enqueue_font_awesome() {

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );

}

// woocommerce ajax commands
function product_remove() {
    $cart = WC()->instance()->cart;
    $id = $_POST['product_id'];
    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);

    if($cart_item_id) {
       $cart->set_quantity($cart_item_id, 0);
    }
    return $cart->cart_contents_count;
}

function product_change_quantity() {
    $cart = WC()->instance()->cart;
    $dir = $_POST['dir'];
    $id = $_POST['product_id'];
    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);
    $count = $cart->cart_contents[$cart_item_id]['quantity'];
    if($cart_item_id) {
       if($dir === 'subtract'):
         $count--;
       else:
         $count++;
       endif;
       $cart->set_quantity($cart_item_id, $count);
    }
    wp_send_json_success(array(
     'quantity' => $cart->cart_contents[$cart_item_id]['quantity'],
     'total' => $cart->cart_contents_count
   ));
}


function get_cart_contents_count() {
  $cart = WC()->instance()->cart;
  if($cart) {
    return $cart->cart_contents_count;
  }
}

function get_cart_contents() {
  $cart = WC()->instance()->cart;
  $returnCart = array();
  if($cart) {
    foreach($cart->cart_contents as $item):
      $product = wc_get_product($item['product_id']);
      $itemArray = [
        'product_id' => $item['product_id'],
        'image' => $product->get_image(),
        'title' => $product->get_title(),
        'quantity' => $item['quantity']
      ];
      endforeach;
      // push into return array
      array_push($returnCart, $itemArray);
  }
  wp_send_json_success(array(
   'cart' => $returnCart
 ));
}

// woocommerce ajax commands

add_action( 'wp_ajax_product_remove',  __NAMESPACE__ . '\\product_remove' );
add_action( 'wp_ajax_nopriv_product_remove',  __NAMESPACE__ . '\\product_remove' );

add_action( 'wp_ajax_nopriv_product_change_quantity',  __NAMESPACE__ . '\\product_change_quantity' );
add_action( 'wp_ajax_product_change_quantity',  __NAMESPACE__ . '\\product_change_quantity' );

add_action( 'wp_ajax_get_cart_contents',  __NAMESPACE__ . '\\get_cart_contents' );
add_action( 'wp_ajax_nopriv_get_cart_contents',  __NAMESPACE__ . '\\get_cart_contents' );


add_action( 'wp_ajax_get_cart_contents_count',  __NAMESPACE__ . '\\get_cart_contents_count' );
add_action( 'wp_ajax_nopriv_get_cart_contents_count',  __NAMESPACE__ . '\\get_cart_contents_count' );


add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_font_awesome' );


// custom category display on product archive
function phx_product_subcategories( $args = array() ) {

  $parentid = get_queried_object_id();

  $args = array(
      'parent' => $parentid
  );

  $terms = get_terms( 'product_cat', $args );

if ( $terms ) {
    echo '<ul class="product-cats">';

        foreach ( $terms as $term ) {

            echo '<li class="category">';

                woocommerce_subcategory_thumbnail( $term );

                echo '<h2>';
                    echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
                        echo $term->name;
                    echo '</a>';
                echo '</h2>';

            echo '</li>';


    }

    echo '</ul>';

  }

}
add_action( 'woocommerce_before_shop_loop',  __NAMESPACE__ . '\\phx_product_subcategories', 50 );


function sk_wcmenucart() {

	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location


	ob_start();
		global $woocommerce;
		$viewing_cart = __('View your shopping cart', 'your-theme-slug');
		$start_shopping = __('Start shopping', 'your-theme-slug');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( wc_get_page_id( 'cart' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'your-theme-slug'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// if ( $cart_contents_count > 0 ) {
  //  $menu_item = '<a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
    $menu_item = '<span class="cart-count">'.$cart_contents_count.'</span>';
    // $menu_item .= '</a>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// }
		echo $menu_item;
	$social = ob_get_clean();
	echo $social;

}

// gravity forms hooks and config
add_filter( 'gform_confirmation_anchor', '__return_true' );
