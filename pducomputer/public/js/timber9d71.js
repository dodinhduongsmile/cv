/* Jonathan Snook - MIT License - https://github.com/snookca/prepareTransition */
(function(a){a.fn.prepareTransition=function(){return this.each(function(){var b=a(this);b.one("TransitionEnd webkitTransitionEnd transitionend oTransitionEnd",function(){b.removeClass("is-transitioning")});var c=["transition-duration","-moz-transition-duration","-webkit-transition-duration","-o-transition-duration"];var d=0;a.each(c,function(a,c){d=parseFloat(b.css(c))||d});if(d!=0){b.addClass("is-transitioning");b[0].offsetWidth}})}})(jQuery);

/* replaceUrlParam - http://stackoverflow.com/questions/7171099/how-to-replace-url-parameter-with-javascript-jquery */
function replaceUrlParam(e,r,a){var n=new RegExp("("+r+"=).*?(&|$)"),c=e;return c=e.search(n)>=0?e.replace(n,"$1"+a+"$2"):c+(c.indexOf("?")>0?"&":"?")+r+"="+a};

/*============================================================================
  Money Format
  - Haravan.format money is defined in option_selection.js.
    If that file is not included, it is redefined here.
==============================================================================*/
if ((typeof Haravan) === 'undefined') { Haravan = {}; }

// Timber functions
window.timber = window.timber || {};

timber.cacheSelectors = function () {
	timber.cache = {
		// General
		$html                    : $('html'),
		$body                    : $(document.body),

		// Navigation
		$navigation              : $('#AccessibleNav'),
		$mobileSubNavToggle      : $('.mobile-nav__toggle'),


		// Customer Pages
		$recoverPasswordLink     : $('#RecoverPassword'),
		$hideRecoverPasswordLink : $('#HideRecoverPasswordLink'),
		$recoverPasswordForm     : $('#RecoverPasswordForm'),
		$customerLoginForm       : $('#CustomerLoginForm'),
		$passwordResetSuccess    : $('#ResetSuccess'),
	};
};

timber.init = function () {
	FastClick.attach(document.body);
	timber.cacheSelectors();
	timber.accessibleNav();
	timber.drawersInit();
	timber.mobileNavToggle();

};

timber.accessibleNav = function () {
	var $nav = timber.cache.$navigation,
			$allLinks = $nav.find('a'),
			$topLevel = $nav.children('li').find('a'),
			$parents = $nav.find('.site-nav--has-dropdown'),
			$subMenuLinks = $nav.find('.site-nav__dropdown').find('a'),
			activeClass = 'nav-hover',
			focusClass = 'nav-focus';

	// Mouseenter
	$parents.on('mouseenter touchstart', function(evt) {
		var $el = $(this);

		if (!$el.hasClass(activeClass)) {
			evt.preventDefault();
		}

		showDropdown($el);
	});

	// Mouseout
	$parents.on('mouseleave', function() {
		hideDropdown($(this));
	});

	$subMenuLinks.on('touchstart', function(evt) {
		// Prevent touchstart on body from firing instead of link
		evt.stopImmediatePropagation();
	});

	$allLinks.focus(function() {
		handleFocus($(this));
	});

	$allLinks.blur(function() {
		removeFocus($topLevel);
	});

	// accessibleNav private methods
	function handleFocus ($el) {
		var $subMenu = $el.next('ul'),
				hasSubMenu = $subMenu.hasClass('sub-nav') ? true : false,
				isSubItem = $('.site-nav__dropdown').has($el).length,
				$newFocus = null;

		// Add focus class for top level items, or keep menu shown
		if (!isSubItem) {
			removeFocus($topLevel);
			addFocus($el);
		} else {
			$newFocus = $el.closest('.site-nav--has-dropdown').find('a');
			addFocus($newFocus);
		}
	}

	function showDropdown ($el) {
		$el.addClass(activeClass);

		setTimeout(function() {
			timber.cache.$body.on('touchstart', function() {
				hideDropdown($el);
			});
		}, 250);
	}

	function hideDropdown ($el) {
		$el.removeClass(activeClass);
		timber.cache.$body.off('touchstart');
	}

	function addFocus ($el) {
		$el.addClass(focusClass);
	}

	function removeFocus ($el) {
		$el.removeClass(focusClass);
	}
};

timber.drawersInit = function () {
	timber.LeftDrawer = new timber.Drawers('NavDrawer', 'right');
	 };

timber.mobileNavToggle = function () {
 timber.cache.$mobileSubNavToggle.on('click', function() {
	 $(this).parent().toggleClass('mobile-nav--expanded');
 });
};



	 /*============================================================================
  Drawer modules
  - Docs http://haravan.github.io/Timber/#drawers
==============================================================================*/
	 timber.Drawers = (function () {
		 var Drawer = function (id, position, options) {
			 var defaults = {
				 close: '.js-drawer-close',
				 open: '.js-drawer-open-' + position,
				 openClass: 'js-drawer-open',
				 dirOpenClass: 'js-drawer-open-' + position
			 };

			 this.$nodes = {
				 parent: $('body, html'),
				 page: $('#PageContainer'),
				 moved: $('.is-moved-by-drawer'),
				 overlay: $('.cart-overlay')
			 };

			 this.config = $.extend(defaults, options);
			 this.position = position;

			 this.$drawer = $('#' + id);

			 if (!this.$drawer.length) {
				 return false;
			 }

			 this.drawerIsOpen = false;
			 this.init();
		 };

		 Drawer.prototype.init = function () {
			 $(this.config.open).on('click', $.proxy(this.open, this));
			 this.$drawer.find(this.config.close).on('click', $.proxy(this.close, this));
			 this.$nodes.overlay.on('click', $.proxy(this.close, this));
		 };

		 Drawer.prototype.open = function (evt) {
			 // Keep track if drawer was opened from a click, or called by another function
			 var externalCall = false;

			 // Prevent following href if link is clicked
			 if (evt) {
				 evt.preventDefault();
			 } else {
				 externalCall = true;
			 }

			 // Without this, the drawer opens, the click event bubbles up to $nodes.page
			 // which closes the drawer.
			 if (evt && evt.stopPropagation) {
				 evt.stopPropagation();
				 // save the source of the click, we'll focus to this on close
				 this.$activeSource = $(evt.currentTarget);
			 }

			 if (this.drawerIsOpen && !externalCall) {
				 return this.close();
			 }

			 // Notify the drawer is going to open
			 timber.cache.$body.trigger('beforeDrawerOpen.timber', this);

			 // Add is-transitioning class to moved elements on open so drawer can have
			 // transition for close animation
			 this.$nodes.moved.addClass('is-transitioning');
			 this.$drawer.prepareTransition();

			 this.$nodes.parent.addClass(this.config.openClass + ' ' + this.config.dirOpenClass);
			 this.$nodes.overlay.addClass('open');
			 this.drawerIsOpen = true;

			 // Set focus on drawer
			 this.trapFocus(this.$drawer, 'drawer_focus');

			 // Run function when draw opens if set
			 if (this.config.onDrawerOpen && typeof(this.config.onDrawerOpen) == 'function') {
				 if (!externalCall) {
					 this.config.onDrawerOpen();
				 }
			 }

			 if (this.$activeSource && this.$activeSource.attr('aria-expanded')) {
				 this.$activeSource.attr('aria-expanded', 'true');
			 }

			 // Lock scrolling on mobile
			 this.$nodes.page.on('touchmove.drawer', function () {
				 return false;
			 });

			 this.$nodes.page.on('click.drawer', $.proxy(function () {
				 this.close();
				 return false;
			 }, this));

			 // Notify the drawer has opened
			 timber.cache.$body.trigger('afterDrawerOpen.timber', this);
		 };

		 Drawer.prototype.close = function () {
			 if (!this.drawerIsOpen) { // don't close a closed drawer
				 return;
			 }

			 // Notify the drawer is going to close
			 timber.cache.$body.trigger('beforeDrawerClose.timber', this);
			 // deselect any focused form elements
			 $(document.activeElement).trigger('blur');

			 // Ensure closing transition is applied to moved elements, like the nav
			 this.$nodes.moved.prepareTransition({ disableExisting: true });
			 this.$drawer.prepareTransition({ disableExisting: true });

			 this.$nodes.parent.removeClass(this.config.dirOpenClass + ' ' + this.config.openClass);
			 this.$nodes.overlay.removeClass('open');

			 this.drawerIsOpen = false;

			 // Remove focus on drawer
			 this.removeTrapFocus(this.$drawer, 'drawer_focus');

			 this.$nodes.page.off('.drawer');

			 // Notify the drawer is closed now
			 timber.cache.$body.trigger('afterDrawerClose.timber', this);

		 };

		 Drawer.prototype.trapFocus = function ($container, eventNamespace) {
			 var eventName = eventNamespace ? 'focusin.' + eventNamespace : 'focusin';

			 $container.attr('tabindex', '-1');

			 $container.focus();

			 $(document).on(eventName, function (evt) {
				 if ($container[0] !== evt.target && !$container.has(evt.target).length) {
					 $container.focus();
				 }
			 });
		 };

		 Drawer.prototype.removeTrapFocus = function ($container, eventNamespace) {
			 var eventName = eventNamespace ? 'focusin.' + eventNamespace : 'focusin';

			 $container.removeAttr('tabindex');
			 $(document).off(eventName);
		 };

		 return Drawer;
	 })();

	 // Initialize Timber's JS on docready
	 $(timber.init);

//chitietsanpham
jQuery(document).ready(function($) {
 /*quick view cart ở mobie*/
   function initCartHeader() {

    var box2 = document.querySelector('.desktop-cart-wrapper1 .quickview-cart');

    function show2() {
     box2.style.display = 'block'; 
   };

   function hide2() {
     box2.style.display = 'none';  
   };

   $("body").on("click",".desktop-cart-wrapper1 .btnCloseQVCart",function(){
     hide2();
   });

   var outside2 = function(event) {
     if (!box2.contains(event.target)) {
      hide2();
      this.removeEventListener(event.type, outside2);
    }
  };

  var el =  document.querySelector('.desktop-cart-wrapper1 > a');
  if(el){
    el.addEventListener("click", function(event) {
     event.preventDefault();
     event.stopPropagation();
     show2();
     document.addEventListener('click', outside2);
   });
  };


}
initCartHeader();
	/*
  1. lấy phần tử tác động
  - tác động vào A thì vị trí tương tự B add active
  console.log(src);
   */
if($('#albumedu_slide').length){
	/*hover hoặc đợi 3s sẽ add backgroup*/
  var hover = "ok";
  var elm_tar = $('#albumedu_slide .item .zoompdu');
var elm_tar2 = $('#albumedu_slide .item');
function background_dot() {
  let img_arr = $("#albumedu_slide .image_dot");
  let dot_arr = $("#albumedu_slide .owl-dot span");
    $.each(img_arr,function(index, el) {
      let src = el.getAttribute("data-src");
      
      dot_arr[index].style.backgroundImage = "url("+src+")";
    });

};
function background() {
    elm_tar.each(function () {
      $(this).css({
        'background-image': 'url(' + $(this).attr('data-src') + ')'
      });
    });
    hover = 'nook';
    clearTimeout(timeout);
}
  elm_tar.hover(function () {
    if (hover == 'ok') {
      background();
      background_dot();
    }
  });
  let timeout = setTimeout(function () {
    background();
    background_dot();
  }, 3000);

   elm_tar2.on('mouseover', function () {
    $(this).children('.zoompdu').css({
      'transform': 'scale(3)'
    });
  });
  elm_tar2.on('mouseout', function () {
    $(this).children('.zoompdu').css({
      'transform': 'scale(1)'
    });
  });
  elm_tar2.on('mousemove', function (e) {
    $(this).children('.zoompdu').css({
      'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%'
    });
  });
    
	$("#albumedu_slide").owlCarousel({
        items: 1,
        responsive: {
            480: { items: 1, },
            0: { items: 1, }
        },
        autoplay: false,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        smartSpeed: 500,

        dots: true,
        dotsEach: false,
        loop: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left icon_slider"></i>', '<i class="fa fa-angle-right icon_slider"></i>'],
        autoWidth: false,
        margin: 10,
        lazyContent: false,
        lazyLoad: true,
        center: true,
        URLhashListener: false,
        video: true,
    }).on('changed.owl.carousel', syncPosition);
var current_ = 0;
var dots_ = $("#albumedu_slide.owl-carousel.owl-theme .owl-dots");
function syncPosition(el) {
      /*
      1. click vào ptu trước hay sau
      - lưu vị trí index hiện tại
      - khi click thì so sánh vị trí click và vị trí trước đó để nhận biết
      -> tính temp để transform
      dots_.css({
          transform: "translateX("+temp_+"px)"
        });
       */
      let number_ = el.item.index;
      let temp_ = 0;
      var leftPos = dots_.scrollLeft();
      if(number_ > current_){
        current_ = number_;
        dots_.animate({scrollLeft: leftPos + 110}, 700);
        
      }else if(number_ < current_){
        current_ = number_;
        dots_.animate({scrollLeft: (leftPos - 110)}, 700);
      }  
    }
  
}

})