/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

        // WAYPOINTS
        var waypoints = $('.animated').waypoint({
          handler: function(direction) {
            if(direction === 'down') {
              $(this.element).addClass('on');
            } else {
              $(this.element).removeClass('on');
            }
          },
          offset: '80%'
        });

        $('.hamburger').on('click', function(){
          $(this).toggleClass('on');
        });

        // selector
        $('.selector-list li a').on('click', function(event){
          event.preventDefault();

          var
            $this = $(this),
            target = $this.attr('href')
          ;

          $('.product-container').addClass('hide');
          $(target).removeClass('hide');
          $('.selector-list li').removeClass('selected');
          $this.parent('li').addClass('selected');
        });

        // cart
        $('.cart-count, .hide-cart-overlay').on('click', function(event) {
          event.preventDefault();
          $('.cart-overlay').toggleClass('on');
        });

        // updates TOTAL item count
        function updateItemCount(count) {
          if(count === 'null') {
            count = 0;
          }
          var items = count === 1 ? ' item' : ' items';
          $('.cart-count').html(count);
          $('.cart-overlay .count').html(count + items);
          if(count === 0) {
            $('.cart-overlay h4').removeClass('d-none');
          }
        }
        //woocommerce ajax functions

        // REMOVE ENTIRE ITEM FROM CART USING REMOVE FROM CART BUTTON
        $('.remove-from-cart').on('click', function (event){
          event.preventDefault();
          var
            options = {
              action: 'product_remove',
              product_id: $(this).data('product-id')
          };
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: phx.ajax_url,
              data: options,
              success: function(data) {
                $('#cart-overlay-' + options.product_id).fadeOut();
                updateItemCount(data);
              }
          });
      });

      // ADD OR SUBTRACT ITEM FROM CART ONE AT A TIME
      $('.ajax-change-quantity').on('click', function (event){
          event.preventDefault();
          var
            options = {
              action: 'product_change_quantity',
              dir: $(this).data('dir'),
              product_id: $(this).data('product-id')
          };

          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: phx.ajax_url,
              data: options,
              success: function(data){
                if(data.success) {
                  updateItemCount(data.data.total);
                  if(data.data.quantity > 0) {
                    // updates quantity inline
                    $('#cart-overlay-' + options.product_id + ' .quantity').html(data.data.quantity);
                  } else {
                    $('#cart-overlay-' + options.product_id).fadeOut();
                  }
                } else {
                  console.log('error updating cart');
                }
              }
          });
      });



      /*
      Placeholder:
      Dynamic Ajax Cart Updating
      Requires more work

      function rebuildCart(cart) {
        var output = '';
        for(var i = 0; i < cart.length; i++) {
          var template = Handlebars.templates['product-template'];
          output = output + template(cart[i]);
        }
        $('.products-wrapper').html(output);
      }


      $('.ajax_add_to_cart').on('click', function() {
        var count = $('.cart-count').html();
        count = parseInt(count, 10) + 1;
        updateItemCount(count);
        var options = {
          action: 'get_cart_contents'
        };

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: phx.ajax_url,
            data: options,
            success: function(data){
              rebuildCart(data.data.cart);
            },
            error: function(errorThrown){
              console.log(errorThrown);
            }
        });
      });
      */



      // fancy hover
      $('.fancyHover, #menu-main-hamburger-menu a').on('hover', function() {
        $(this).addClass('fh-hovered');
      });

        // nav / hero:
        // only delay slide-in if we are scrolled off the top.
        // tweens
        if($('body').hasClass('home')) {
          var heroTl = new TimelineMax();
          heroTl.add(TweenLite.fromTo($('#header'), 0.5,
          {
            top: $('#header').outerHeight() * -1,
            opacity: 0
          },
          {
            top: 0,
            opacity: 1
          }));

          heroTl.add(TweenLite.fromTo($('#header .logo'), 0.25,
          {
            opacity: 0
          },
          {
            opacity: 1
          }));

          var hero = new ScrollMagic.Controller();
          var header = new ScrollMagic.Scene({
            offset: $('#header').outerHeight()
          })
          .setTween(heroTl)
          .addTo(hero);
      }
        // Dynamically set up animations

        $('section[data-animation="true"]').each(function(){

          var
            $parent = $(this),
            $anim_els = $(this).find('[data-animate="true"]')
          ;
          // loop over each element and add to the timeline
          $anim_els.each(function(){
            var indicator = false;

            if($(this).hasClass('side-by-side-img')) {
              indicator = true;
            }

            var ctrl = new ScrollMagic.Controller({addIndicators: false});

            var
              tl = new TimelineMax(),
              tl2 = new TimelineMax(),
              tl_trigger_hook = parseFloat($parent.data('offset')),
              tl2_trigger_hook = parseFloat($parent.data('offset')),
              duration = 300,
              $this = $(this)
            ;
            if(typeof($this.data('animations')) !== 'undefined') {
              var d = $this.data('animations');
              for(var i = 0; i < d.length; i ++) {
                if(!d[i].attachToScroll) {
                  if(d[i].type === "fromTo") {
                    if(d[i].triggerHook) {
                      tl_trigger_hook = parseFloat(d[i].triggerHook);
                    }
                    tl.add(TweenLite.fromTo($this, parseFloat(d[i].duration), d[i].from, d[i].to));
                  }
                } else {
                  if(d[i].triggerHook) {
                    tl2_trigger_hook = parseFloat(d[i].triggerHook);
                  }
                  tl2.add(TweenLite.to($this, parseFloat(d[i].duration), d[i].to));
                }
                // set distance
                if(d[i].distance) {
                  if(d[i].distance === "-1") {
                    // height of parent
                    duration = $parent.outerHeight();
                  } else {
                    duration = parseFloat(d[i].distance);
                  }
                }
              }
            }
            var noScroll = new ScrollMagic.Scene({
              triggerElement: $this[0],
              triggerHook: tl_trigger_hook,
            })
            .setTween(tl)
            .addTo(ctrl);


            // attach the timeline to the scene
            var yesScroll = new ScrollMagic.Scene({
              triggerElement: $this[0],
              triggerHook: tl2_trigger_hook,
              duration: duration
            })
            .setTween(tl2)
            .addTo(ctrl);

          });


      });

      // rotation animations; jank free?
            ;(function() {
          var throttle = function(type, name) {
              var obj = obj || window;
              var running = false;
              var func = function() {
                  if (running) { return; }
                  running = true;
                  requestAnimationFrame(function() {
                      obj.dispatchEvent(new CustomEvent(name));
                      running = false;
                  });
              };
              obj.addEventListener(type, func);
          };
          throttle ("scroll", "optimizedScroll");
      })();

      window.addEventListener("optimizedScroll", function() {
        $('.image-rotate').each(function(){
          $(this)[0].style.transform = "rotate("+ window.pageYOffset*-1 +"deg)";
        });
      });

        // lazyload bg images
        document.addEventListener('lazybeforeunveil', function(e){
          var bg = e.target.getAttribute('data-bg');
          if(bg){
              e.target.style.backgroundImage = 'url(' + bg + ')';
          }
        });

      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
