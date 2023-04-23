/*!
	Zoom 1.7.20
	license: MIT
	http://www.jacklmoore.com/zoom
*/

/*common functions*/
function setCookie(name, value, days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

function eraseCookie(name) {
	document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
/*common functions end*/

(function ($) {
	var defaults = {
		url: false,
		callback: false,
		target: false,
		duration: 120,
		on: 'mouseover', // other options: grab, click, toggle
		touch: true, // enables a touch fallback
		onZoomIn: false,
		onZoomOut: false,
		magnify: 1
	};

	// Core Zoom Logic, independent of event listeners.
	$.zoom = function (target, source, img, magnify) {
		var targetHeight,
			targetWidth,
			sourceHeight,
			sourceWidth,
			xRatio,
			yRatio,
			offset,
			$target = $(target),
			position = $target.css('position'),
			$source = $(source);

		// The parent element needs positioning so that the zoomed element can be correctly positioned within.
		target.style.position = /(absolute|fixed)/.test(position) ? position : 'relative';
		target.style.overflow = 'hidden';
		img.style.width = img.style.height = '';

		$(img)
			.addClass('zoomImg')
			.css({
				position: 'absolute',
				top: 0,
				left: 0,
				opacity: 0,
				width: img.width * magnify,
				height: img.height * magnify,
				border: 'none',
				maxWidth: 'none',
				maxHeight: 'none'
			})
			.appendTo(target);

		return {
			init: function () {
				targetWidth = $target.outerWidth();
				targetHeight = $target.outerHeight();

				if (source === target) {
					sourceWidth = targetWidth;
					sourceHeight = targetHeight;
				} else {
					sourceWidth = $source.outerWidth();
					sourceHeight = $source.outerHeight();
				}

				xRatio = (img.width - targetWidth) / sourceWidth;
				yRatio = (img.height - targetHeight) / sourceHeight;

				offset = $source.offset();
			},
			move: function (e) {
				var left = (e.pageX - offset.left),
					top = (e.pageY - offset.top);

				top = Math.max(Math.min(top, sourceHeight), 0);
				left = Math.max(Math.min(left, sourceWidth), 0);

				img.style.left = (left * -xRatio) + 'px';
				img.style.top = (top * -yRatio) + 'px';
			}
		};
	};

	$.fn.zoom = function (options) {
		return this.each(function () {
			var
				settings = $.extend({}, defaults, options || {}),
				//target will display the zoomed image
				target = settings.target && $(settings.target)[0] || this,
				//source will provide zoom location info (thumbnail)
				source = this,
				$source = $(source),
				img = document.createElement('img'),
				$img = $(img),
				mousemove = 'mousemove.zoom',
				clicked = false,
				touched = false;

			// If a url wasn't specified, look for an image element.
			if (!settings.url) {
				var srcElement = source.querySelector('img');
				if (srcElement) {
					settings.url = srcElement.getAttribute('data-src') || srcElement.currentSrc || srcElement.src;
				}
				if (!settings.url) {
					return;
				}
			}

			$source.one('zoom.destroy', function (position, overflow) {
				$source.off(".zoom");
				target.style.position = position;
				target.style.overflow = overflow;
				img.onload = null;
				$img.remove();if (errors) {
								showErrors(errors);
							}
						    $(element).find('button,input[type="submit"]').attr('disabled', false);
			}.bind(this, target.style.position, target.style.overflow));

			img.onload = function () {
				var zoom = $.zoom(target, source, img, settings.magnify);

				function start(e) {
					zoom.init();
					zoom.move(e);

					// Skip the fade-in for IE8 and lower since it chokes on fading-in
					// and changing position based on mousemovement at the same time.
					$img.stop()
						.fadeTo($.support.opacity ? settings.duration : 0, 1, $.isFunction(settings.onZoomIn) ? settings.onZoomIn.call(img) : false);
				}

				function stop() {
					$img.stop()
						.fadeTo(settings.duration, 0, $.isFunction(settings.onZoomOut) ? settings.onZoomOut.call(img) : false);
				}

				// Mouse events
				if (settings.on === 'grab') {
					$source
						.on('mousedown.zoom',
							function (e) {
								if (e.which === 1) {
									$(document).one('mouseup.zoom',
										function () {
											stop();

											$(document).off(mousemove, zoom.move);
										}
									);

									start(e);

									$(document).on(mousemove, zoom.move);

									e.preventDefault();
								}
							}
						);
				} else if (settings.on === 'click') {
					$source.on('click.zoom',
						function (e) {
							if (clicked) {
								// bubble the event up to the document to trigger the unbind.
								return;
							} else {
								clicked = true;
								start(e);
								$(document).on(mousemove, zoom.move);
								$(document).one('click.zoom',
									function () {
										stop();
										clicked = false;
										$(document).off(mousemove, zoom.move);
									}
								);
								return false;
							}
						}
					);
				} else if (settings.on === 'toggle') {
					$source.on('click.zoom',
						function (e) {
							if (clicked) {
								stop();
							} else {
								start(e);
							}
							clicked = !clicked;
						}
					);
				} else if (settings.on === 'mouseover') {
					zoom.init(); // Preemptively call init because IE7 will fire the mousemove handler before the hover handler.

					$source
						.on('mouseenter.zoom', start)
						.on('mouseleave.zoom', stop)
						.on(mousemove, zoom.move);
				}

				// Touch fallback
				if (settings.touch) {
					$source
						.on('touchstart.zoom', function (e) {
							e.preventDefault();
							if (touched) {
								touched = false;
								stop();
							} else {
								touched = true;
								start(e.originalEvent.touches[0] || e.originalEvent.changedTouches[0]);
							}
						})
						.on('touchmove.zoom', function (e) {
							e.preventDefault();
							zoom.move(e.originalEvent.touches[0] || e.originalEvent.changedTouches[0]);
						})
						.on('touchend.zoom', function (e) {
							e.preventDefault();
							if (touched) {
								touched = false;
								stop();
							}
						});
				}

				if ($.isFunction(settings.callback)) {
					settings.callback.call(img);
				}
			};

			img.setAttribute('role', 'presentation');
			img.src = settings.url;
		});
	};

	$.fn.zoom.defaults = defaults;
}(window.jQuery));

$(document).ready(function () {
	$('#lightgallery').lightGallery({
		mode: 'lg-fade',
		download: false,
		enableDrag: false,
		pager: false,
		share: false,
		autoplay: false,
		actualSize: false,
		zoom: true
	});
	$('#lightgallery').on('onAferAppendSlide.lg', function () {
		// $('.lg-item').zoom({ on:'click' });              
	});
});

// toogle class
$('.side-menu').click(function () {
	$(this).toggleClass("active");
	$(".header-bottom.left-slider").toggleClass("active-menu");
	$("body").toggleClass("menu_toggle");
});

$('.x').click(function () {
	$(this).toggleClass("active");
	$(".header-bottom").removeClass("active-menu");
	$("body").removeClass("menu_toggle");
});

$('.mobile-search').click(function () {
	$("body .header-search-wrap .header-search").toggleClass("search-show");
});


$('.shopping-card-right').click(function () {
	$(this).toggleClass("active");
	$(".header-bottom.cart-sidebar").toggleClass("active-menu");
	$("body").toggleClass("menu_toggle");
});


// $(document).ready(function(){

//            $(window).on("scroll",function() {

//                if($(this).scrollTop() > 100) 

//                    $(".center-header").removeClass("normal").addClass("mobile-bar-sticky");

//                else 

//                    $(".center-header").removeClass("mobile-bar-sticky").addClass("normal");


//            })
//        })

$(document).ready(function () {

	$(window).on("scroll", function () {

		if ($(this).scrollTop() > 175)

			$(".header-bottom.left-slider").removeClass("menu_top").addClass("web-bar-sticky");

		else

			$(".header-bottom.left-slider").removeClass("web-bar-sticky").addClass("menu_top");


	})
})


jQuery('.banner-slider').owlCarousel({
	loop: true,
	margin: 0,
	nav: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 1,
			nav: false
		},
		767: {
			items: 1,
			nav: false,
			dots: true,
		},
		1000: {
			items: 1,
			dots: true,
		}
	}
})
jQuery(".owl-prev").html('<i class="fas fa-long-arrow-alt-left"></i>');
jQuery(".owl-next").html('<i class="fas fa-long-arrow-alt-right"></i>');

jQuery('.megatan-slider').owlCarousel({
	// loop:true,
	margin: 15,
	nav: false,
	dots: false,
	responsive: {
		0: {
			items: 2,
			nav: false,
			dots: true
		},
		600: {
			items: 2,
			nav: false,
			dots: true
		},
		767: {
			items: 4,
			nav: false,
			dots: true
		},
		1000: {
			items: 5,
		}
	}
})


jQuery('.feature-slider').owlCarousel({
	// loop:true,
	margin: 15,
	nav: false,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 2,
			nav: false,
		},
		975: {
			items: 2,
			nav: false,
		},
		1000: {
			items: 3,
		},
		1025: {
			items: 4,
		}
	}
})


jQuery('.feature-slider-1').owlCarousel({
	// loop:true,
	margin: 15,
	nav: false,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 2,
			nav: false,
		},
		975: {
			items: 2,
			nav: false,
		},
		1000: {
			items: 3,
		},
		1025: {
			items: 4,
		}
	}
})
jQuery('.Starter-slider').owlCarousel({
	// loop:true,
	margin: 15,
	nav: false,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false,
		},
		1000: {
			items: 4,
		}
	}
})

jQuery('.megatan-blog-slider').owlCarousel({
	// loop:true,
	margin: 15,
	nav: true,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false,
		},
		1000: {
			items: 3,
		}
	}
})

jQuery('.megatan-blog-slider-1').owlCarousel({
	// loop:true,
	margin: 15,
	nav: true,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false,
		},
		1000: {
			items: 3,
		}
	}
})


jQuery('.about-us-slider').owlCarousel({
	// loop:true,
	margin: 30,
	nav: true,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false
		},
		1000: {
			items: 3
		}
	}
})
jQuery(".owl-prev").html('<i class="fas fa-chevron-left"></i>');
jQuery(".owl-next").html('<i class="fas fa-chevron-right"></i>');




jQuery('.megatan-tab-slider').owlCarousel({
	margin: 15,
	nav: false,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false,
		},
		1000: {
			items: 4,
		}
	}
})

jQuery('.megatan-tab-slider-1').owlCarousel({
	margin: 15,
	nav: false,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		767: {
			items: 3,
			nav: false,
		},
		1000: {
			items: 4,
		}
	}
})


// 210812
jQuery('.aside-slider').owlCarousel({
	loop: true,
	margin: 15,
	nav: true,
	dots: true,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 1,
			nav: false
		},
		767: {
			items: 1,

		},
		1000: {
			items: 1,
		}
	}
})

jQuery('.People-Bought-slider').owlCarousel({
	loop: true,
	margin: 15,
	nav: false,
	dots: false,
	responsive: {
		0: {
			items: 1,
			nav: false
		},
		600: {
			items: 2,
			nav: false
		},
		991: {
			items: 4,
			nav: false,
		},
		1200: {
			items: 5,
		}
	}
})
// 210812 end
//----------------------LOADER------------------------

function callLoader(time = 300) {
	$("#overlay").fadeIn(time);
}

function endLoader(time) {
	$("#overlay").fadeOut(time);
}
//----------------------LOADER END------------------------
//---------------------------------------------SHOP-PAGE------------------------------------------------------
let params = {

	'cId'       : getUrlParameter('cId'),
	'search'    : getUrlParameter('search'),
	'price_from': getUrlParameter('price_from'),
	'price_to'  : getUrlParameter('price_to'),
	'sort'      : $('select[name="sort"]').val(),
	'limit'     : $('select[name="limit"]').val(),
	'stock'     : getUrlParameter('stock'),
	'page'      : 1,

};

//----------------------------------Functin-to-url-parameter-value----------------------------------
function getUrlParameter(sParam) {

	var sPageURL = window.location.search.substring(1),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		}
	}

	return null;
};
//------------------------------------------------------------------------------------------------------

//----------------------------------Functin-to-covert-object-to-url-parameter---------------------------
function createUrlParameterString(params) {
	// convert objec to a query string
	const qs = Object.keys(params)
		.map(function (key) {
			if (params[key] !== '' && params[key] !== null && params[key] !== undefined) {
				return `${key}=${params[key]}`;
			}

			return null;

		}).filter(function (el) {
			return el != null;
		}).join('&');

	return qs;
}
//window.history.pushState('shop', 'Title', window.location.pathname+"?"+createUrlParameterString(params));
//------------------------------------------------------------------------------------------------------

//----------------------------------shop-page-filters----------------------------------
$('select[name="limit"]').on('change', function (event) {
	params['limit'] = $(this).val();
	params['page'] = 1;
	window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
	getResults();
});

$('select[name="sort"]').on('change', function (event) {
	params['sort'] = $(this).val();
	params['page'] = 1;
	window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
	getResults();
});

$('input#stock[type="checkbox"]').on('click', function (event) {
	
	if($(this).is(':checked')){
		params['stock'] = 1;
	}
	else {
		params['stock'] = null;
	}
	window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
	getResults();
});
//---------------------------------------------------------------------------------------------------------------

//----------------------------------Pagination-------------------------------------------------------------------
$(document).on('click', '.pagination a', function (event) {
	event.preventDefault();

	$('.pagination li').removeClass('active');
	$(this).parent('li').addClass('active');

	var myurl = $(this).attr('href');
	var page = $(this).attr('href').split('page=')[1];
	params.page = page;

	window.history.pushState('page', 'Title', window.location.pathname + "?" + createUrlParameterString(params));

	getResults();
});
//-----------------------------------------------------------------------------------------------------------------

function getResults() {

	let qParam = createUrlParameterString(params);

	new Promise((resolve, reject) => {

			$.ajax({

				url: window.location.pathname + '?' + qParam,
				method: "GET",
				dataType: "html",
				async: true,
				beforeSend: function () {
					callLoader();
				},
				complete: function () {
					endLoader();
				},
				success: function (result) {
					resolve(result);
				},
				error: function () {
					reject(result);
				}
			});

		})
		.then((html) => {

			$('.main-products').html(html);

			$('html, body').animate({
				scrollTop: $('.right-content').offset().top
			}, 'slow');

		})
		.catch((error) => {

			console.log(error);

		});
}

$('.reset-filter-btn').on('click', function () {
	$('select[name="sort"] option:first').prop('selected', 'selected');
	$('select[name="limit"] option:first').prop('selected', 'selected');

	$from.val(min);
	$to.val(max);
	range.reset();

	params['price_from'] = null;
	params['price_to'] = null;
	params['sort'] = $('select[name="sort"]').val();
	params['limit'] = $('select[name="limit"]').val();
	params['page'] = 1;

	window.history.pushState('page', 'Title', window.location.pathname + "?" + createUrlParameterString(params));

	getResults();

});

//---------------------------------------------SHOP-PAGE-END-----------------------------------------------------

//---------------------------------------------PRODUCT-QUICK-VIEW-END-----------------------------------------------------
$(document).on('click', 'html body .quickview_show', function (event) {
	event.preventDefault();
	let productId = $(this).data('product-id');

	new Promise((resolve, reject) => {

			$.ajax({

				url: $(this).attr('href'),
				method: "GET",
				dataType: "html",
				async: true,
				success: function (result) {
					resolve(result);
				},
				error: function () {
					reject(result);
				}
			});
		})
		.then((html) => {
			$('#productQuickViewModal .modal-content').html(html);
			$('#productQuickViewModal').modal('show');
		})
		.catch((error) => {
			console.log(error);
		});
});
//---------------------------------------------PRODUCT-QUICK-VIEW-END-----------------------------------------------------

//---------------------------------------------RANGE-SILDER-----------------------------------------------------
//------Initialise variables---------
var $range = $(".js-range-slider"),
	$from = $(".from"),
	$to = $(".to"),
	range,
	min = $range.data('min'),
	max = $range.data('max'),
	from,
	to;

//------Initialise range slider instance---------
$range.ionRangeSlider({

	min: min,
	max: max,
	from: params['price_from'] === null ? min : params['price_from'],
	to: params['price_to'] === null ? max : params['price_to'],
	grid: true,
	onChange: function (data) {
		from = data.from;
		to = data.to;
		updateValues();
	},
	onFinish: function (data) {

		params['price_from'] = data.from;
		params['price_to'] = data.to;
		params['page'] = 1;
		window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
		getResults();
	},
});

//------Save instance to variable---------
range = $range.data("ionRangeSlider");

var updateValues = () => {

	$from.prop("value", from);
	$to.prop("value", to);

};

var updateRange = () => {

	range.update({
		from: from,
		to: to
	});
};

$from.on("input", function () {

	from = +$(this).prop("value");
	if (from < min) {
		from = min;
	}
	if (from > to) {
		from = to;
	}
	updateValues();
	updateRange();
});

$to.on("input", function () {
	to = +$(this).prop("value");
	if (to > max) {
		to = max;
	}
	if (to < from) {
		to = from;
	}
	updateValues();
	updateRange();
});

//----call-function-on-focusout
$from.on("focusout", function () {
	params['price_from'] = $(this).val();
	params['price_to'] = $to.val();
	params['page'] = 1;
	window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
	getResults();
});

$to.on("focusout", function () {
	params['price_from'] = $from.val();
	params['price_to'] = $(this).val();
	params['page'] = 1;
	window.history.pushState('shop', 'Title', window.location.pathname + "?" + createUrlParameterString(params));
	getResults();
});
//---------------------------------------------RANGE-SILDER END-----------------------------------------------------

//------------------------------------LIST-GRID-VIEW-----------------------------------------------------
// ---------------------------
let grid_class = 'product-grid';
let list_class = 'product-list';
let grid_list_ele = document.querySelector('div.right-content div.main-products');
// --------------------------- 
let view_cookie = getCookie('view');
// --------------------------- 
$(document).on('click', '.products-filters .grid-list button.view-btn', function () {
	view_cookie = getCookie('view');

	let view = $(this).attr('data-view');

	if (view_cookie === null || view_cookie != view) {

		setCookie('view', view);
		if (view == grid_class) {

			setAndRemoveClass(grid_list_ele, grid_class, list_class);
		} else {
			setAndRemoveClass(grid_list_ele, list_class, grid_class);
		}

	}
});
// --------------------------- 

// --------------------------- 
function setAndRemoveClass(ele, add_class_name, remove_class_name) {
	ele.classList.add(add_class_name);
	ele.classList.remove(remove_class_name);
}
// --------------------------- 

if (view_cookie !== null) {
	if (grid_list_ele !== null) {

		if (view_cookie == 'product-grid') {
			setAndRemoveClass(grid_list_ele, grid_class, list_class);
		} else {
			setAndRemoveClass(grid_list_ele, list_class, grid_class);
		}
	}
}



//------------------------------------Toastr-----------------------------------------------------
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});


toastr.options = {
	"closeButton": true,
	"debug": true,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut",

}
//------------------------------------Toastr-----------------------------------------------------

//------------------------------------LIST-GRID-VIEW END-----------------------------------------------------


//------------------------------------compare-products-----------------------------------------------------
var compare = {
	add: function (product_id) {

		$.ajax({

			url: globalUrls.compare.add,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			data: "product_id=" + product_id,
			dataType: "json",
			success: function (data) {

				toastr.clear();
				toastr.success(data.notification.message, data.notification.title, {
					timeOut: 3000
				});

				$('span.compare-total').html(data['count-html']);

			},
			error: function (error) {

				let data = error.responseJSON;

				toastr.clear();
				toastr.error(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			},

		});
	},
	remove: function () {},
};
//------------------------------------compare-products End-------------------------------------------------

//------------------------------------cart-up-down-button-----------------------------------------------------
$('html body').on('click', '.input-number-decrement, .input-number-increment', function (e) {

	const isNegative = $(e.target).closest('.input-number-decrement').is('.input-number-decrement');
	const input = $(e.target).closest('.stepper').find('input.cart-product-quantity');

	if (input.is('input')) {
		input[0][isNegative ? 'stepDown' : 'stepUp']();
	}
});
//------------------------------------cart-up-down-button End-------------------------------------------------

//------------------------------------cart-limit End-------------------------------------------------
$("html body").on('keyup', '.cart-product-quantity', function (e, ) {

	if ($(this).val() == '') {
		$(this).val(1);
		return false;
	}
	var cart_quantity = parseInt($(this).val());
	if (cart_quantity < 1 || cart_quantity > $(this).attr('max')) {
		var targ = $(e.target);
		$(this).val(1);
	}
});

// Numeric only control handler

$("html body").on('keydown', '.cart-product-quantity', function (e) {
	var key = e.charCode || e.keyCode || 0;

	// allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
	// home, end, period, and numpad
	return (
		key == 8 ||
		key == 9 ||
		key == 13 ||
		key == 46 ||
		(key >= 35 && key <= 40) ||
		(key >= 48 && key <= 57) ||
		(key >= 96 && key <= 105)
	);

});

//------------------------------------cart-limit End-------------------------------------------------


//------------------------------------Wishlist-------------------------------------------------
let wishlist = {
	'add': function (element, product_id) {
		$.ajax({
			url: globalUrls.wishlist.add,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function (successResp) {
				let data = successResp;
				$('span.wishlist-total').html(data['count-html']);
				$(element).find('i').toggleClass('heart-red-icon');
				toastr.clear();
				toastr.success(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			},
			error: function (errorResp) {

				let data = errorResp.responseJSON;
				toastr.clear();
				toastr.error(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			}
		});
	},
	'remove': function () {}
}
//------------------------------------Wishlist-----------------------------------------

//------------------------------------Cart----------------------------------------------
let cart = {

	'add': function (element) {

		let event = window.event;
		event.preventDefault();

		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {
                  $(element).find('button,input[type="submit"]').attr('disabled',true);
			},
			complete: function () {
                $(element).find('button,input[type="submit"]').attr('disabled',false);
			},
			success: function (json) {
				let data = json;

				if (data['redirect'] != '') {
					location = data['redirect'];
				}
				if (window.location.pathname == '/cart' || window.location.pathname == '/checkout') {
					window.location.reload();
				}
				$('body div.cart-wrap-content').html(data['cart-wrap-html']);
				if(parseInt(data['cart-count']) > 0)
				{
					$('body .cart-wrap .cart-inner-wrap .cart-info').html(`${data['cart-count']} item(s) - ${data['cart-subtotal']}`);
				}
				else
				{
					$('body .cart-wrap .cart-inner-wrap .cart-info').html('');
				}
				if(parseInt(data['cart-count']) > 0)
				{
					$('body .cart-wrap .cart-inner-wrap .show-cart-count .cart-total').remove('');
				    $('body .cart-wrap .cart-inner-wrap .show-cart-count').append(`<span class="cart-total"><span class="count-badge cart-badge">${data['cart-count']}</span></span>`);
				}
				else
				{
					$('body .cart-wrap .cart-inner-wrap .show-cart-count .cart-total').remove('');
				}

				toastr.clear();
				toastr.success(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			},
			error: function (errorResp) {
				let data = errorResp.responseJSON;
				toastr.clear();
				toastr.error(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			}
		});

		return false;
	},

	'remove': function (element) {

		let event = window.event;
		event.preventDefault();

		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {
              
                $(element).find('button,input[type="submit"]').attr('disabled',true);
			},
			complete: function () {
               $(element).find('button,input[type="submit"]').attr('disabled',false);
			},
			success: function (successResp) {
				let data = successResp;

				if (window.location.pathname == '/cart') {
					window.location.reload();
				}
				$('body div.cart-wrap-content').html(data['cart-wrap-html']);
				$('body div.cart-wrap-content').html(data['cart-wrap-html']);
				$('body .cart-wrap .cart-inner-wrap .cart-info').html(`${data['cart-count']} item(s) - ${data['cart-subtotal']}`);
				if(parseInt(data['cart-count']) > 0)
				{
					$('body .cart-wrap .cart-inner-wrap .cart-info').html(`${data['cart-count']} item(s) - ${data['cart-subtotal']}`);
				}
				else
				{
					$('body .cart-wrap .cart-inner-wrap .cart-info').html('');
				}
				if(parseInt(data['cart-count']) > 0)
				{
					$('body .cart-wrap .cart-inner-wrap .show-cart-count .cart-total').remove('');
				    $('body .cart-wrap .cart-inner-wrap .show-cart-count').append(`<span class="cart-total"><span class="count-badge cart-badge">${data['cart-count']}</span></span>`);
				}
				else
				{
					$('body .cart-wrap .cart-inner-wrap .show-cart-count .cart-total').remove('');
				}
				toastr.clear();
				toastr.success(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			},
			error: function (errorResp) {
				let data = errorResp.responseJSON;
				toastr.clear();
				toastr.error(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			}
		});


		return false;

	}
}
//------------------------------------Cart----------------------------------------------

//------------------------------------Tooltip-hide-on-click----------------------------------------------
$(document).ready(function () {
	$('[data-toggle="tooltip"]').click(function () {
		$('[data-toggle="tooltip"]').tooltip("hide", "slow");

	});
});
//------------------------------------Tooltip-hide-on-click End----------------------------------------------

//------------------------------------Cart----------------------------------------------
let addressbook = {

	'store': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');

		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
				callLoader();

			},
			complete: function () {

				 $(element).find('button,input[type="submit"]').attr('disabled', false);
				   endLoader();

			},
			success: function (json) {

				if (json['redirect'] && json['redirect'] != '') {
					window.location.href = json['redirect'];
				}

			},
			error: function (err) {
				let response = err.responseJSON;
				let errors = response.errors;
				showErrors(errors);
			}
		});

		return false;
	},

	'update': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');

		$.ajax({

			url: element.getAttribute('action'),
			type: 'patch',
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
				callLoader();

			},
			complete: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', false);
				 endLoader();

			},
			success: function (json) {

				if (json['redirect'] && json['redirect'] != '') {
					window.location.href = json['redirect'];
				}

			},
			error: function (err) {
				let response = err.responseJSON;
				let errors = response.errors;
				showErrors(errors);
			}
		});

		return false;
	},

	'destroy': function (element) {

		let event = window.event;
		event.preventDefault();

		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();

			},
			complete: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', false);
				endLoader();

			},
			success: function (successResp) {
				let data = successResp;
				$('html body div.cart-wrap-content').html(data['cart-wrap-html']);
				toastr.clear();
				toastr.success(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			},
			error: function (errorResp) {
				let data = errorResp.responseJSON;
				toastr.clear();
				toastr.error(data.notification.message, data.notification.title, {
					timeOut: 3000
				});
			}
		});


		return false;

	}
}

function showErrors(errors) {

	$.each(errors, function (key, error) {
		$('#' + key + '_error').text(error.pop());
	});
}
//------------------------------------Cart----------------------------------------------

//------------------------------------Country----------------------------------------------
$(document).delegate('select[name=\'countryId\']', 'change', function (e) {

	$.ajax({
		url: $(this).attr('action') + '?countryId=' + this.value,
		dataType: 'json',
		beforeSend: function () {
			$('select[name=\'countryId\']').prop('disabled', true);
		},
		complete: function () {
			$('select[name=\'countryId\']').prop('disabled', false);
		},
		success: function (json) {

			html = '<option value=""> --- Please Select --- </option>';

			if (json['states'] && json['states'] != '') {
				$.each(json['states'], function (index, state) {

					html += `<option value="${state['_id']}">${state['state_name']}</option>`;
				});
			}

			$('select[name=\'stateId\']').html(html);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//------------------------------------Country----------------------------------------------

//------------------------------------checkout----------------------------------------------
let checkout = {

	'login': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			data: $(element).serialize(),
			beforeSend: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();
			},
			complete: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				endLoader();
			},
			success: function (json) {

				if (json['redirect'] !== 'undeined') {
					window.location.href = json.redirect;
				} else {
					console.log(json);
				}
			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;
				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#' + key + '_error').html(error);
					});
				} else {
					console.log(errorResponse);
				}
			}
		});

	},

	'account_billing_register': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			data: $(element).serialize(),
			beforeSend: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();
			},
			complete: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				endLoader();
			},
			success: function (json) {

				if (json['redirect'] !== 'undeined') {
					window.location.href = json.redirect;
				} else {

					console.log(json);
				}
			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;
				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#checkout-checkout #account_billing_form #' + key + '_error').html(error);
					});
				} else {

					console.log(errorResponse);
				}
			}
		});

	},

	'payment_address_save': function (element) {


		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			async: false,
			beforeSend: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();
			},
			complete: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				endLoader();
			},
			data: $(element).serialize(),
			success: function (json) {

				if (json['payment_address'] == 'new') {
					$('#checkout-checkout #collapse-payment-address .panel-body').html(json['payment_address_html']);
				}

				$.ajax({

					url: window.location.pathname + '/shipping_address',
					dataType: 'html',
					beforeSend: function () {
						$(element).find('button,input[type="submit"]').attr('disabled', true);
						callLoader();
					},
					complete: function () {
						$(element).find('button,input[type="submit"]').attr('disabled', false);
						endLoader();
					},
					success: function (html) {

						$('#checkout-checkout #collapse-payment-address').parent('.panel.panel-default').nextAll('.panel-default').find('.panel-body').html('');
						$('#checkout-checkout #collapse-shipping-address .panel-body').html(html);
						$('#checkout-checkout a[href=\'#collapse-shipping-address\']').trigger('click');


					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});

			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;

				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#checkout-checkout #payment_address_save #' + key + '_error').html(error);
					});
				}
			}
		});

	},
	'shipping_address_save': function (element) {


		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			async: false,
			data: $(element).serialize(),
			beforeSend: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();
			},
			complete: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				 endLoader();
			},
			success: function (json) {

				if (json['shipping_address'] == 'new') {

					$('#checkout-checkout #collapse-shipping-address .panel-body').html(json['shipping_address_html']);
				}

				$.ajax({

					url: window.location.pathname + '/shipping_method',
					dataType: 'html',
					success: function (html) {
						$('#checkout-checkout #collapse-shipping-address').parent('.panel.panel-default').nextAll('.panel-default').find('.panel-body').html('');
						$('#checkout-checkout #collapse-shipping-method .panel-body').html(html);
						$('#checkout-checkout a[href=\'#collapse-shipping-method\']').trigger('click');
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});

			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;

				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#checkout-checkout #shipping_address_save #' + key + '_error').html(error);
					});
				}
			}
		});

	},
	'shipping_method_save': function (element) {


		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			async: false,
			data: $(element).serialize(),
			beforeSend: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', true);
		        callLoader();
			},
			complete: function () {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
		    	 endLoader();
			},
			success: function (json) {

				$.ajax({

					url: window.location.pathname + '/payment_method',
					dataType: 'html',
					success: function (html) {
						$('#checkout-checkout #collapse-shipping-method').parent('.panel.panel-default').nextAll('.panel-default').find('.panel-body').html('');
						$('#checkout-checkout #collapse-payment-method .panel-body').html(html);
						$('#checkout-checkout a[href=\'#collapse-payment-method\']').trigger('click');
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});

			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;

				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#checkout-checkout #shipping_method_save #' + key + '_error').html(error);
					});
				}
			}
		});

	},
	'payment_method_save': function (element) {


		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			async: false,
			data: $(element).serialize(),
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();

			},
			complete: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', false);
				 endLoader();

			},
			success: function (json) {

				$.ajax({

					url: window.location.pathname + '/checkout_confirm',
					dataType: 'html',
					success: function (html) {
						$('#checkout-checkout #collapse-payment-method').parent('.panel.panel-default').nextAll('.panel-default').find('.panel-body').html('');
						$('#checkout-checkout #collapse-checkout-confirm .panel-body').html(html);
						$('#checkout-checkout a[href=\'#collapse-checkout-confirm\']').trigger('click');
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});

			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;

				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#checkout-checkout #payment_method_save #' + key + '_error').html(error);
					});
				}
			}
		});

	},
	'order_placed': function (element) {
		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$(element).find('button,input[type="submit"]').attr('disabled', true);
		callLoader();
		$.ajax({

			url: $(element).attr('action'),
			method: 'post',
			async: false,
			data: $(element).serialize(),
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
			    callLoader();

			},
			complete: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', false);
				 endLoader();

			},
			success: function (json) {

				if (json['redirect']) {

					window.location.href = json['redirect'];
				}
			},
			error: function (errorResponse) {

				let errRes = errorResponse.responseJSON;
				let errors = errRes.errors;

				if (errors !== 'undefined') {

					$.each(errors, function (key, error) {
						$('#order_placed #' + key + '_error').html(error);
					});
				}
			}
		});
	}

}

let auth_check = $('meta[name="auth-check"]').attr('content');

if (auth_check !== 'undefined') {
	//---if user is not login show login form
	if (auth_check == 'false' && $('#checkout-checkout #collapse-checkout-option').length > 0) {
		$('#checkout-checkout a[href=\'#collapse-checkout-option\']').trigger('click');

	} //---if user is login show billing address form form
	else if (auth_check == 'true') {
		$.ajax({

			url: window.location.pathname + '/payment_address',
			dataType: 'html',
			success: function (html) {

				$('#checkout-checkout #collapse-payment-address .panel-body').html(html);
				$('#checkout-checkout a[href=\'#collapse-payment-address\']').trigger('click');

			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$(document).delegate('#checkout-checkout #button-account', 'click', function () {
	$.ajax({

		url: $(this).attr('action'),
		dataType: 'html',
		beforeSend: function () {
			$('#button-account').button('loading');
		},
		complete: function () {
			$('#button-account').button('reset');
		},
		success: function (html) {

			$('#collapse-payment-address .panel-body').html(html);
			$('a[href=\'#collapse-payment-address\']').trigger('click');

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

});

//-------------------------------show-hide------------------------------ 

$(document).delegate('#checkout-checkout input[name="payment_address"]', 'change', function () {
	$('span[id$="_error"]').html('');
	if (this.value == 'new') {
		$('#payment-existing').hide();
		$('#payment-new').show();

	} else {
		$('#payment-existing').show();
		$('#payment-new').hide();
	}

});

$(document).delegate('#checkout-checkout input[name="shipping_address"]', 'change', function () {
	$('span[id$="_error"]').html('');
	if (this.value == 'new') {
		$('#shipping-existing').hide();
		$('#shipping-new').show();

	} else {
		$('#shipping-existing').show();
		$('#shipping-new').hide();
	}

});

$(document).delegate('.accordion-toggle', 'click', function () {

	$('.panel.panel-default').each(function () {
		$(this).addClass('panel-collpase').removeClass('panel-active');
	});

	if ($(this).hasClass('collapsed')) {
		$(this).closest('.panel.panel-default').removeClass('panel-active').addClass('panel-collpase');
	} else {
		$(this).closest('.panel.panel-default').addClass('panel-active').removeClass('panel-collpase');
	}

});
//-------------------------------show-hide------------------------------ 

//------------------------------------checkout----------------------------------------------



//------------------------------------recently-viewed-products----------------------------------------------
let recentlyviewedproducts = {

	'add': function (productId, url) {

		let event = window.event;
		event.preventDefault();
		let recent_products_cookies = getCookie('RECENTLY_VIEWED_PRODUCTS');
		recent_products_arr = [];
		if (recent_products_cookies == null) {
			recent_products_arr.push(productId);
			recentlyviewedproducts.increaseProductViewCount(productId, url);
		} else {
			recent_products_arr = JSON.parse(recent_products_cookies);
			if (!recent_products_arr.includes(productId)) {
				if (recent_products_arr.length > 10) {
					recent_products_arr.shift();
				}
				recent_products_arr.push(productId);
				recentlyviewedproducts.increaseProductViewCount(productId, url);
			}
		}

		setCookie('RECENTLY_VIEWED_PRODUCTS', JSON.stringify(recent_products_arr), '1');
	},

	'increaseProductViewCount': function (productId, url) {

		$.ajax({

			url: url,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "post",
			data: "productId=" + productId,
			dataType: "json",
			beforeSend: function () {

			},
			complete: function () {

			},
			success: function (successResp) {

			},
			error: function (errorResp) {

			}
		});

	}

}



//------------------------------------recently-viewed-products----------------------------------------------

//------------------------------------Newsletter----------------------------------------------
let newsletter = {

	'subscribe': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');

		$.ajax({

			url: $(element).attr('action'),
			type: 'POST',
			data: $(element).serialize(),
			async: false,
			dataType: 'json',
			cache: false,
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled', true);
			},
			success: function (successResp) {
				toastr.clear();
				toastr.success(successResp.success, {
					timeOut: 3000
				});
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				$(element).trigger('reset');
			},
			error: function (errorResp) {
				$(element).find('button,input[type="submit"]').attr('disabled', false);
				let response = errorResp.responseJSON;
				let errors = response.errors;
				showErrors(errors);
			}
		});

	},


}



//------------------------------------Newsletter----------------------------------------------

//------------------------------------Coupon----------------------------------------------
let coupons = {

	'apply': function (element) {

		let event = window.event;
		    event.preventDefault();
		    $('span[id$="_error"]').html('');

		$.ajax({

			url        : $(element).attr('action'),
			type       : 'POST',
			data       : $(element).serialize(),
			async      : false,
			dataType   : 'json',
			cache      : false,
			beforeSend : function () {

							$(element).find('button,input[type="submit"]').attr('disabled', true);
							callLoader();
			},
			complete    : function() {

		                    $(element).find('button,input[type="submit"]').attr('disabled', false);
		                    endLoader();
			},
			success    : function (successResp) {

						    if(successResp.success) {

								toastr.clear();
							    toastr.success(successResp.success,'', {
								   timeOut: 2000
							    });
							}
							if(successResp.page == 'cart' && successResp.redirect_url != '') {
								window.location.href = successResp.redirect_url;
							}
							else if(successResp.page == 'checkout')
							{
								$('body #checkout-checkout .cart-checkout-details').html(successResp.html);
							}
						
			},
			error      : function (errorResp) {

							let response = errorResp.responseJSON;
							let errors   = response.errors;
							if (errors) {
								showErrors(errors);
							}
						    $(element).find('button,input[type="submit"]').attr('disabled', false);
			}
		});
	},

	'delete': function (element) {

		let event = window.event;
		    event.preventDefault();
		    $('span[id$="_error"]').html('');

		$.ajax({

			url        : $(element).attr('action'),
			type       : 'delete',
			data       : $(element).serialize(),
			async      : false,
			dataType   : 'json',
			cache      : false,
			beforeSend : function () {

						    $(element).find('button,input[type="submit"]').attr('disabled', true);
						    callLoader();
			},
			complete   : function()
			{
		                   $(element).find('button,input[type="submit"]').attr('disabled', false);
		                   endLoader();
			},
			success    : function (successResp) {

							if(successResp.success) {

								toastr.clear();
							    toastr.error(successResp.success,'', {
								   timeOut: 2000
							    });
							}
							if(successResp.page == 'cart' && successResp.redirect_url != '') {
								window.location.href = successResp.redirect_url;
							}
							else if(successResp.page == 'checkout')
							{
								$('body #checkout-checkout .cart-checkout-details').html(successResp.html);
							}
			},
			error      : function (errorResp) {

							console.log(errorResp);
							$(element).find('button,input[type="submit"]').attr('disabled', false);
			}
		});
	}


}

//------------------------------------Coupon----------------------------------------------------

//------------------------------------Header-Search----------------------------------------------

//setup before functions
var typingTimer; //timer identifier
var doneTypingInterval = 800; //time in ms (1 seconds)

$(document).delegate('.header-search-wrap input[name="search"]', 'keyup', function (event) {
	clearTimeout(typingTimer);
	if ($(this).val()) {
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	} else {
		$('html .header-search-wrap .search-result').html('<p>Search result empty</p>');
	}
	let url = $(this).data('search-url') + '?search=' + $(this).val();

	//----selectedcategoryId
	let selectcatId = $('select[name="cId"]').val();
	if (selectcatId != '') {
		url = url + '&cId=' + selectcatId;
	}

	//user is "finished typing," do something
	function doneTyping() {

		$.ajax({

			url: url,
			type: 'GET',
			dataType: 'html',
			beforeSend: function () {

			},
			complete: function () {

			},
			success: function (successResp) {
				$('html .header-search-wrap').replaceWith(successResp);
				$('body').find('.js-example-basic-single').select2();
				var searchInput = $('body .header-search-wrap input[name="search"]');
				var strLength = searchInput.val().length * 2;
				searchInput.focus();
				searchInput[0].setSelectionRange(strLength, strLength);
				$('html body').find('.tt-menu').css('display', 'block');
				$('body .header-search-wrap .header-search').addClass('search-show');
			},
			error: function (errorResp) {

			}
		});
	}
});

$(document).mouseup(function (e) {

	let container = $('body').find('.header-search');
	// If the target of the click isn't the container
    if(!container.is(e.target) && container.has(e.target).length === 0){
       $('html body').find('.tt-menu').css('display', 'none');
    }
	
});
$(document).delegate('.header-search-wrap input[name="search"]', 'focus', function (event) {
	if ($(this).val().length > 0) {
		$('html body').find('.tt-menu').css('display', 'block');
	}
});

$(document).delegate('ul.j-menu li a', 'click', function () {

	$(this).parents('html').find(".search-categories-button").html($(this).text() + ' <span class="caret"></span>');
	$(this).parents('html').find(".search-categories-button").val($(this).data('value'));

});

//------------------------------------Header-Search----------------------------------------------

//------------------------------------Responsive----------------------------------------------
$('.mobile-filter-trigger').click(function () {
	$('aside.side-column').addClass('mobile-filter');
	$("body").addClass("menu_toggle");
});

$('.x').click(function () {
	// $('aside.side-column').addClass('active');
	$('aside.side-column').removeClass('mobile-filter');
	// $('aside.side-column').removeClass('active');
	$("body").removeClass("menu_toggle");
});
//------------------------------------Responsive----------------------------------------------


//------------------------------------ProductReview----------------------------------------------
let productreview = {

	'add': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled',true);

			},
			complete: function () {
               $(element).find('button,input[type="submit"]').attr('disabled',false);
			},
			success: function (successResp) {

				if (successResp.success) {
					alert(successResp.success);
				}
				console.log(successResp);
				$(element).trigger('reset');
			},
			error: function (errorResp) {

				let response = errorResp.responseJSON;
				let errors = response.errors;
				showErrors(errors);
			}
		});

		return false;
	}
}
//------------------------------------ProductReview End----------------------------------------------


function activeTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};

//------------------------------------Prouctlist-page (write a review)----------------------------------------------
$('#write-review-link').on('click',function(e)
{
	e.preventDefault();
    e.stopImmediatePropagation();
	$.when(activeTab('all-review-link')).then(() => {

		setTimeout(function(){

					$('html, body').animate({
								scrollTop: $('#tabsContent form#form-review').offset().top
					}, 'slow');

		 }, 600);

	});
	
});


$('#list-all-reviews').on('click',function(e)
{
	e.preventDefault();
    e.stopImmediatePropagation();
	$.when(activeTab('all-review-link')).then(() => {

		setTimeout(function(){

					$('html, body').animate({
								scrollTop: $('.nav-tabs a[href="#all-review-link"]').offset().top
					}, 'slow');

		 }, 600);

	});
	
});



//------------------------------------ProductReview End----------------------------------------------


//------------------------------------Footer Accept Cookies-------------------------------------------
if(getCookie('accepted') == null)
{
	$('body').find('.cookies').css('display','block');
}else{
	$('body').find('.cookies').css('display','none');
}
$('.accept-cookies').on('click',function()
{
	if(getCookie('accepted') == null)
	{
		setCookie('accepted',true,0.25);
		$(this).parents('.cookies').css('display','none');
	}
})
//------------------------------------Footer Accept Cookies END---------------------------------------

//------------------------------------Blog Comments----------------------------------------------
let blogComment = {

	'add': function (element) {

		let event = window.event;
		event.preventDefault();
		$('span[id$="_error"]').html('');
		$.ajax({

			url: element.getAttribute('action'),
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: $(element).serialize(),
			dataType: 'json',
			beforeSend: function () {

				$(element).find('button,input[type="submit"]').attr('disabled',true);

			},
			complete: function () {
               $(element).find('button,input[type="submit"]').attr('disabled',false);
			},
			success: function (successResp) {

				if (successResp.success) {
					toastr.clear();
				    toastr.success(successResp.success,'', {
					   timeOut: 3000
				    });
				}
				$(element).trigger('reset');
			},
			error: function (errorResp) {

				let response = errorResp.responseJSON;
				let errors = response.errors;
				showErrors(errors);
			}
		});

		return false;
	}
}
//------------------------------------Blog Comments End-------------------------------------------

//---------------------------Show more less on quick view start----------------------------------

$(document).delegate('.view-more-wrap a.normal-link', 'click', function (event) {
    
    event.preventDefault();
    if($(this).hasClass('view-more'))
    {
	    $(this).closest('.description ').find('.expand-block').css('max-height','unset');
	    $(this).removeClass('view-more').addClass('view-less');
	    $(this).text('view less');
    }
    else
    {
    	$(this).closest('.description ').find('.expand-block').css('max-height','170px');
	    $(this).removeClass('view-less').addClass('view-more');
	    $(this).text('view more');
    }

});

//---------------------------Show more less on quick view end----------------------------------



