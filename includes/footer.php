</div> <br> <br><hr>

<div class="text-center">
	Copyright &copy; Bumi House  <?php echo date("Y")?>


</div>



<!-- footer -->
 <!-- <div class="contact-us"> -->


<script>
	document.addEventListener( 'DOMContentLoaded', function () {
		new Splide( '.splide' ).mount();
	} );

  var splide = new Splide( '#splide' );

  splide.on( 'autoplay:playing', function ( rate ) {
  console.log( rate ); // 0-1
  } );

  splide.mount();

  new Splide( '#splide', {
	type   : 'loop',
	perPage: 3,
} );

</script>






<script>
 jQuery(window).scroll(function()
 {
  var vscroll = jQuery(this).scrollTop();
  jQuery('#logotext').css({
    "transform" : "translate(0px, "+vscroll/2+"px)"
  });

  var vscroll = jQuery(this).scrollTop();
  jQuery('#back-flower').css({
    "transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
  });

  var vscroll = jQuery(this).scrollTop();
  jQuery('#fore-flower').css({
    "transform" : "translate(0px, -"+vscroll/1+"px)"
  });

});

  function detailsmodal(id){
    var data ={"id" : id};
    jQuery.ajax({
      url : '/includes/detailsmodal.php',
      method : "post",
      data : data,
      success : function(data){
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');
      },
        error : function(){
          alert("Something went wrong!");
        }
    });


  }



  function update_cart(mode, edit_id, edit_size){
    var data = {"mode": mode, "edit_id": edit_id, "edit_size" : edit_size};
    jQuery.ajax({

      url : '/admin/parsers/update_cart.php',
      method : "post",
      data : data,
      success : function(){
        location.reload();
      },
      error : function(){
        alert("Something went wrong!");
      }
    });
  }

  function add_to_cart(){
    // alert("works");
  jQuery('#modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = jQuery('#quantity').val();

  var available = parseInt(jQuery('#available').val());
  // var available = parseInt(available);
  var error = '';
  var data = jQuery('#add_product_form').serialize();

  // if  cart is empty
  if (size == '' || quantity == '' || quantity == 0) {
    error += '<p class="text-danger text-center bg-danger"> You must choose a size and quantity!</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else if(quantity > available) {
    error += '<p class="text-danger text-center bg-danger"> There are only '+available+' available.</p>';
    jQuery('#modal_errors').html(error);
    return ;

    // location.reload();
  }else {
    jQuery.ajax({
      url : '/admin/parsers/add_cart.php',
      method : 'post',
      data : data,
      success : function(){

        alert("successfully added to cart")
        location.reload();
      },
      error : function(){
        alert("Oops something went wrong!");}
    });
  }

  }




	$('ht').append('<div style="" id="loadingDiv"><div class="loader"> Loading...</div></div>');

// let	element=$('#loadingDiv').get(0);
		 // element.requestFullscreen();
	$(window).on('load', function(){
		setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds
	});
	function removeLoader(){
		$("#loadingDiv").fadeOut(500, function(){ //fadeOut complete, remove the loading div

			$("#loadingDiv").remove(); // makes page more lightweight
		});
	}


	$(function(){
		$('ht').fotorama({
			'loop':true, 'autoplay':true,
			spinner: {
				lines: 13,
				color: 'rgba(0, 0, 0, .75)'
			}
		});
	});




	$('.toggle').click(function(){

    $('.nav').toggleClass("justify-content-end");
    $('.toggle').toggleClass("text-light");
});


document.addEventListener("DOMContentLoaded", function(){
  window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        document.getElementById('navbar_top').classList.add('fixed-top');
        // add padding top to show content behind navbar
        navbar_height = document.querySelector('.navbar').offsetHeight;
        document.body.style.paddingTop = navbar_height + 'px';
      } else {
        document.getElementById('navbar_top').classList.remove('fixed-top');
         // remove padding top from body
        document.body.style.paddingTop = '0';
      }
  });
});

document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
    everydropdown.addEventListener('shown.bs.dropdown', function () {
        el_overlay = document.createElement('span');
        el_overlay.className = 'screen-darken';
        document.body.appendChild(el_overlay)
    });

    everydropdown.addEventListener('hide.bs.dropdown', function () {
      document.body.removeChild(document.querySelector('.screen-darken'));
    });
  });

});

$('.dropdown-toggle').click(function (){
            dropDownFixPosition($('button'),$('.dropdown-menu'));
        });
function dropDownFixPosition(button,dropdown){
      var dropDownTop = button.offset().top + button.outerHeight();
        dropdown.css('top', dropDownTop + "px");
        dropdown.css('left', button.offset().left + "px");
}





//
//
// $('.dropdown').on('show.bs.dropdown', function() {
//   $('body').append($('.dropdown').css({
//     position: 'absolute',
//     left: $('.dropdown').offset().left,
//     top: $('.dropdown').offset().top
//   }).detach());
// });
//
// $('.dropdown').on('hidden.bs.dropdown', function() {
//   $('.bs-example').append($('.dropdown').css({
//     position: false,
//     left: false,
//     top: false
//   }).detach());
// });
'use strict';
!function utilities()
{
  // setup "gc" root object for all custom global variables and functions
  // Why gc? I work at Goshen College. Learn more at goshen.edu!
  var gc = {};

  // debounce
  gc.debounce = function(func, wait) {
		var timeout;return function() {
		var context = this,
		args = arguments;
		var later = function() {
			timeout = null;
			func.apply(context, args);
		};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	};

  // setup window resize debouncer that triggers callbacks (passing them starting & ending width)
  // window.innerWidth is cached as gc.width to prevent layout thrashing: https://gist.github.com/paulirish/5d52fb081b3570c81e3a
  gc.width = window.innerWidth;
  var callbacks = {}; // 'name' => callbackFunction

  window.addEventListener('resize', gc.debounce( function handleWindowResize()
  {
    var endWidth = window.innerWidth;
    for (var name in callbacks) {
      if (callbacks.hasOwnProperty(name)) {
        callbacks[name](gc.width, endWidth);
      }
    }
    gc.width = endWidth;
  }, 200 ));

  gc.addResizeCallback = function( name, callbackFunction ) {
    if ( !callbacks.hasOwnProperty(name) ) {
      callbacks[name] = callbackFunction;
    }
  }

  gc.removeResizeCallback = function( name ) {
    delete callbacks[name];
  }

  // make gc globally accessible!
  window.gc = gc;
}();

/**
 * Setup buttons on horizontally-scrolling nav bar
 *
 * Active/deactivate site nav bar to toggle visibility of wrappers.
 *    When wrappers are visible, dropdowns can be seen and scrolled over, but nothing at the top of the page can be clicked
 *    When wrappers are invisible, dropdowns cannot be seen but the rest of the page can be interacted with fine
 */
!function scrollSiteNavBar()
{
  /**
   * Setup buttons for horizontal scrolling
   */
  var component = document.getElementById('nav');

  // 'wrapper' that gets scrolled. Changes depending on screen width
  var outerWrap = document.getElementById('nav__outer-wrap'); // for <480 wide screens
  var innerWrap = document.getElementById('nav__inner-wrap'); // for 480+ wide screens

  // don't run if there's no site nav bar on this page (e.g. homepage)
  if (outerWrap === null) { return; }

  // buttons for automatic scrolling
  var leftBtn = document.getElementById('nav__scroll--left');
  var rightBtn = document.getElementById('nav__scroll--right');

  // spacer on the right side of menu that rightBtn covers up
  var rightSpacerWidth = 28;

  // sticky left-aligned header on 480+ wide screens
  var header = document.getElementById('nav__heading');

  // initialize buttons once font has been loaded (the size of the wrappers change)
	// (timeout of 3s by default)
  var font = new FontFaceObserver('Source Sans Pro');
  font.load()
    .then(function ()
    {
      // Hack: use setTimeout to ensure the correct clientWidth of 'header' has been calculated.
      // (Perhaps this is a bug w/ the FontFaceObserver library?)
      setTimeout(init, 200);
    })
    .catch(function ()
    {
      setTimeout(init, 200);
    });

  // Initialize component
  function init()
  {
    // Update component properties based on screen width
    reset(gc.width);

    // add click listeners on buttons
    leftBtn.addEventListener('click', scrollLeft);
    rightBtn.addEventListener('click', scrollRight);

    // on scroll, show/hide buttons (e.g. don't show scroll-left button when you're already on the left side)
    // re-calculate wrapper.scrollLeft every time, of course, b/c this changes with scrolling
    outerWrap.addEventListener('scroll', gc.debounce( function () { toggleButtons(wrapper.scrollLeft); }, 100 ));
    innerWrap.addEventListener('scroll', gc.debounce( function () { toggleButtons(wrapper.scrollLeft); }, 100 ));

    // reset when screen width changes
    gc.addResizeCallback('siteNavWrapper', function (startWidth, endWidth) {
      reset(endWidth);
    });
  }

  /*
    the "wrapper" is the element with accurate scrollLeft and scrollWidth
      at < 480px, wrapper is outerWrap
      at >= 480px, wrapper is innerWrap
  */
  var wrapper, limit, amount;

  // Update component properties so it adapts to screen width
  function reset(screenWidth)
  {
    if (screenWidth < 480) {
      // scrolling menu is fullwidth. header scrolls as well
      wrapper = outerWrap;
      // left button is up against left side of screen
      leftBtn.style.left = 0;
      // limit is the amount of pixels that the navigation can be horizontally scrolled
      // here, scroll area is entire width of screen.
      limit = wrapper.scrollWidth - screenWidth;
      // scroll by 250 each time button is pressed
      amount = 250;
    }
    else {
      // scrolling menu is almost fullwidth. header is fixed in place on left side
      wrapper = innerWrap;
      // left button should be to the right of the header
      leftBtn.style.left = header.clientWidth +'px';
      // scroll area is VISIBLE width of scrollable area (the "window" you can see)
      limit = wrapper.scrollWidth - wrapper.clientWidth;
      // scroll by 300 every time button is pressed
      amount = 300;
    }

    // show/hide spacer depending on whether scrolling is possible
    if (limit <= 0) {
      // no scrolling is possible. hide spacer
      component.classList.remove('nav--scrollable');
    }
    // scrolling is possible. show spacer if hidden
    else {
      component.classList.add('nav--scrollable');
      // adjust limit to take into account the spacer that was just added
      limit += rightSpacerWidth;
    }

    // calculate which buttons should be visible
    toggleButtons(wrapper.scrollLeft);
  }

  function scrollLeft() {
    scroll( -amount );
  }
  function scrollRight() {
    scroll( amount );
  }

  function scroll(amount) {
    var start = wrapper.scrollLeft;
    var end = start + amount;

    tween( start, end, 1000, easeInOutQuad);
  }

  function toggleButtons(scrollPos) {
    // console.log('toggleButtons', scrollPos, 'of', limit);

    // screen too wide for scrolling
    if (limit <= 0) {
      show(leftBtn);
      show(rightBtn);
    }
    // leftmost position (give 10px so it hides a bit prematurely)
    else if (scrollPos <= 10) {
      show(leftBtn);
      show(rightBtn);
    }
    // rightmost position (compensate for rightSpacer)
    else if (scrollPos >= limit - rightSpacerWidth) {
      show(rightBtn);
      show(leftBtn);
    }
    // anywhere in between
    else {
      show(leftBtn);
      show(rightBtn);
    }
  }

  function show(elem) {
    elem.classList.remove('hide');
    // why the delay? so buttons can fade in/out (transitions defined in CSS classes)
    setTimeout(function () {
      elem.classList.add('nav__scroll--visible');
    }, 100);
  }
  function hide(elem) {
    elem.classList.remove('nav__scroll--visible');
    setTimeout(function () {
      elem.classList.add('hide');
    }, 300);
  }

  function tween(start, end, duration, easing) {
    var delta = end - start;
    var startTime = performance.now();
    var tweenLoop = function (time) {
      var t = (!time ? 0 : time - startTime);
      var factor = easing(null, t, 0, 1, duration);
      wrapper.scrollLeft = start + delta * factor;
      if (t < duration && wrapper.scrollLeft != end) {
        requestAnimationFrame(tweenLoop);
      }
    }
    tweenLoop();
  };

  function easeInOutQuad(x, t, b, c, d)
  {
    if ((t/=d/2) < 1) return c/2*t*t + b;
    return -c/2 * ((--t)*(t-2) - 1) + b;
  }

  /**
   * Setup activation/deactivation
   * Both wrappers are very tall so that the dropdown menus (below nav) can be seen.
   * However, this means that the wrappers cover up the page below the menu so things
   * can't be interacted with. Thus, we need to listen for when the menu's being interacted
   * with and show/hide the wrappers as needed.
   */
  handle(activate, true);

  function activate()
  {
    requestAnimationFrame(function () {
      component.classList.add('nav--hovered');
      handle(deactivate, true);
    });
    handle(activate, false);
  }

  function deactivate(evt)
  {
    if (evt.target === outerWrap || evt.target === innerWrap) {
      component.classList.remove('nav--hovered');
      handle(deactivate, false);
      handle(activate, true);
    }
  }

  function handle(callback, addOrRemove)
  {
    if (addOrRemove) {
      outerWrap.addEventListener('touchstart', callback);
      outerWrap.addEventListener('mouseover', callback);
    }
    else {
      outerWrap.removeEventListener('touchstart', callback);
      outerWrap.removeEventListener('mouseover', callback);
    }
  }
}();

/**
 * Keep dropdowns open when their child links are focused by a keyboard
 */
!function accessibleDropdowns()
{
  // for site nav bar, always setup dropdowns
  var nav = document.getElementById('nav');
  var siteNavOptions = {
    selector: '.nav__item',
    onFocusIn: function(elem) {
      elem.classList.add('nav__item--has-focus');
      nav.classList.add('nav--focused');
    },
    onFocusOut: function(elem) {
      elem.classList.remove('nav__item--has-focus');
    },
    onAllFocusOut: function() {
      nav.classList.remove('nav--focused');
    }
  }
  init( siteNavOptions );

  /**
   * Listen for "focusin" and "focusout" events and toggle dropdowns accordingly
   * @param  {Object} options {
   *  selector: '.nav__item', // dropdown
   *  onFocusIn: function(elem) {...}, // dropdown focused
   *  onFocusOut: function(elem) {...} // dropdown unfocused
   *  onAllFocusOut: function() {...} // all dropdowns unfocused
   * }
   */
  function init( options )
  {
    var focusedDropdownId = '';
    var lastFocusTime = 0;
    $(options.selector).on('focusin', function (evt)
    {
      // a new dropdown was focused
      lastFocusTime = window.performance.now();
      if (this.id !== focusedDropdownId) {
        focusedDropdownId = this.id;
        // display dropdown (until unfocused)
        options.onFocusIn( this );
      }
    });
    $(options.selector).on('focusout', function (evt)
    {
      // Remove unfocused dropdown.
      // Wait a bit (25ms) first b/c the event firing of focus in/out is unpredictable and we need to be sure
      // that focusedDropdownId is set correctly before hiding and dropdowns
      var self = this;
      var wait = 25;
      setTimeout(function ()
      {
        // Hide unfocused dropdown if...
        // 1. a different dropdown has been focused
        if (self.id !== focusedDropdownId) {
          options.onFocusOut( self );
        }
        // 2. a new item in this dropdown hasn't been focused
        else if ( window.performance.now() - lastFocusTime > wait * 2 ) {
          focusedDropdownId = '';
          options.onFocusOut( self );
          options.onAllFocusOut();
        }
      }, wait);
    });
  }
}();




</script>
<!-- <script src="fun.js"></script> -->


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
 integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

</body>
</html>
