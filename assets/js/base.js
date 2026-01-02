jQuery.getPos = function (e) {
	var l = 0;
	var t = 0;
	var w = jQuery.intval(jQuery.css(e, 'width'));
	var h = jQuery.intval(jQuery.css(e, 'height'));
	var wb = e.offsetWidth;
	var hb = e.offsetHeight;
	while (e && e.offsetParent) {
		l += e.offsetLeft + (e.currentStyle ? jQuery.intval(e.currentStyle.borderLeftWidth) : 0);
		t += e.offsetTop + (e.currentStyle ? jQuery.intval(e.currentStyle.borderTopWidth) : 0);
		e = e.offsetParent;
	}
	if (e) {
		l += e.offsetLeft + (e.currentStyle ? jQuery.intval(e.currentStyle.borderLeftWidth) : 0);
		t += e.offsetTop + (e.currentStyle ? jQuery.intval(e.currentStyle.borderTopWidth) : 0);
	}
	return { x: l, y: t, w: w, h: h, wb: wb, hb: hb };
};
jQuery.getClient = function (e) {
	var w, h;
	if (e && e.clientWidth && e.clientHeight) {
		w = e.clientWidth;
		h = e.clientHeight;
	} else {
		w = (window.innerWidth) ? window.innerWidth : (document.documentElement && document.documentElement.clientWidth) ? document.documentElement.clientWidth : (document.body ? document.body.offsetWidth : 0);
		h = (window.innerHeight) ? window.innerHeight : (document.documentElement && document.documentElement.clientHeight) ? document.documentElement.clientHeight : (document.body ? document.body.offsetHeight : 0);
	}
	return { w: w, h: h };
};
jQuery.getScroll = function (e) {
	if (e) {
		t = e.scrollTop;
		l = e.scrollLeft;
		w = e.scrollWidth;
		h = e.scrollHeight;
	} else {
		if (document.documentElement && document.documentElement.scrollTop) {
			t = document.documentElement.scrollTop;
			l = document.documentElement.scrollLeft;
			w = document.documentElement.scrollWidth;
			h = document.documentElement.scrollHeight;
		} else if (document.body) {
			t = document.body.scrollTop;
			l = document.body.scrollLeft;
			w = document.body.scrollWidth;
			h = document.body.scrollHeight;
		}
	}
	return { t: t, l: l, w: w, h: h };
};
jQuery.intval = function (v) {
	v = parseInt(v);
	return isNaN(v) ? 0 : v;
};
jQuery.fn.ScrollTo = function (s) {
	var o = jQuery.speed(s);
	return this.each(function () {
		new jQuery.fx.ScrollTo(this, o);
	});
};
jQuery.fx.ScrollTo = function (e, o) {
	var z = this;
	z.o = o;
	z.e = e;
	z.p = jQuery.getPos(e);
	z.s = jQuery.getScroll();
	z.clear = function () { clearInterval(z.timer); z.timer = null };
	z.t = (new Date).getTime();
	z.step = function () {
		var t = (new Date).getTime();
		var p = (t - z.t) / z.o.duration;
		if (t >= z.o.duration + z.t) {
			z.clear();
			setTimeout(function () { z.scroll(z.p.y, z.p.x) }, 13);
		} else {
			var st = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.y - z.s.t) + z.s.t;
			var sl = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.x - z.s.l) + z.s.l;
			z.scroll(st, sl);
		}
	};
	z.scroll = function (t, l) { window.scrollTo(l, t) };
	z.timer = setInterval(function () { z.step(); }, 13);
};
(function ($) {
	$(document).ready(function () {
		var isIE6 = false;
		var isIE7 = false;
		if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
			var ieversion = new Number(RegExp.$1);
			if (ieversion == 6) {
				isIE6 = true;
			} else if (ieversion == 7) {
				isIE7 = true;
			}
		}

		$('.nav-item-has-dropdown').hover(
			function () {
				$(this).addClass('nav-item-active');
				if (isIE6) {
					$('.nav-dropdown', this).show();
				} else {
					$('.nav-dropdown', this).slideDown('fast');
				}
			},
			function () {
				$(this).removeClass('nav-item-active');
				if (isIE6) {
					$('.nav-dropdown', this).hide();
				} else {
					$('.nav-dropdown', this).slideUp('fast');
				}
			}
		);

		$('.nav-dropdown li').hover(
			function () {
				$(this).addClass('nav-item-active');
			},
			function () {
				$(this).removeClass('nav-item-active');
			}
		);

		if ($('.post-content pre').length) {
			$('.post-content pre').addClass('sh');
			var js_url = SimpX.assets.js + '/syntaxhighlighter.js';
			var css_url = SimpX.assets.css + '/syntaxhighlighter.css';
			$('head').append('<link rel="stylesheet" href="' + css_url + '" />');

			var s = document.createElement('script');
			s.src = js_url;
			s.onload = s.onreadystatechange = function () {
				if (!this.readyState || /loaded|complete/.test(this.readyState)) {
					s.onload = s.onreadystatechange = null;
					window.SyntaxHighlighter && SyntaxHighlighter.all();
				}
			};
			document.getElementsByTagName('head')[0].appendChild(s);
		}

		if ($('.post-content img').length) {
			// 1. 动态添加 CSS
			var css_url = SimpX.assets.css + '/jquery.fancybox-1.3.4.css';
			$('head').append('<link rel="stylesheet" href="' + css_url + '" type="text/css" />');

			// 2. 动态加载 JS
			var js_url = SimpX.assets.js + '/jquery.fancybox-1.3.4.js';
			var s = document.createElement('script');
			s.type = 'text/javascript';
			s.src = js_url;
			s.onload = s.onreadystatechange = function () {
				if (!this.readyState || /loaded|complete/.test(this.readyState)) {
					s.onload = s.onreadystatechange = null;

					// 3. 初始化 Fancybox
					$('.post-content img').each(function () {
						var $img = $(this);

						// 为每个图片包裹 <a>，防止重复包裹
						if (!$img.parent().is('a.fancybox')) {
							$img.wrap('<a href="' + $img.attr('src') + '" class="fancybox" rel="gallery"></a>');
						}
					});

					// 绑定 Fancybox
					$('a.fancybox').fancybox({
						// 1.3.4 默认选项
						'overlayShow': true,
						'overlayOpacity': 0.7,
						'overlayColor': '#000',
						'transitionIn': 'elastic',
						'transitionOut': 'elastic',
						'titlePosition': 'outside'
					});
				}
			};
			document.getElementsByTagName('head')[0].appendChild(s);
		}

		if (isIE6) {

		}

		if (isIE6 || isIE7) {
			updateIcon();
			fixFixedElements();
		}

		$('.has-tooltip').each(function () {
			var $el = $(this);
			var title = $el.attr('title');
			if (!title) {
				title = $el.attr('tooltip');
			}
			if (!title) {
				title = $el.attr('alt');
			}
			if (!title) return;

			var alignX = 'center', alignY = 'top', offsetX = 0, offsetY = 5;

			if ($el.is('[tooltip-left]')) {
				alignX = 'left'; alignY = 'center'; offsetX = -5; offsetY = 0;
			} else if ($el.is('[tooltip-right]')) {
				alignX = 'right'; alignY = 'center'; offsetX = 5; offsetY = 0;
			} else if ($el.is('[tooltip-top]')) {
				offsetY = -5;
			} else if ($el.is('[tooltip-bottom]')) {
				alignY = 'bottom';
			}

			$el.poshytip({
				className: 'tip-twitter',
				showOn: 'hover',
				alignTo: 'target',
				alignX: alignX,
				alignY: alignY,
				offsetX: offsetX,
				offsetY: offsetY,
				content: title
			});
		});


		$('.go-top').click(function () { try { $('#header').ScrollTo(800); } catch (e) { } return false; });

		setTagCloudStyle();


		function updateIcon (isIE6) {

			var icons = {
				'icon-arrow-right': '&#xe61b;',
				'icon-arrow-left': '&#xe61c;',
				'icon-arrow-down': '&#xe606;',
				'icon-arrow-up': '&#xe61f;',
				'icon-pencil': '&#xe61d;',
				'icon-paperclip': '&#xe620;',
				'icon-users': '&#xe621;',
				'icon-user': '&#xe622;',
				'icon-star1': '&#xe623;',
				'icon-star2': '&#xe624;',
				'icon-thumbs-up': '&#xe625;',
				'icon-thumbs-down': '&#xe626;',
				'icon-chat': '&#xe627;',
				'icon-comment': '&#xe628;',
				'icon-quote': '&#xe629;',
				'icon-share': '&#xe62a;',
				'icon-tag': '&#xe62b;',
				'icon-calendar': '&#xe62c;',
				'icon-googleplus': '&#xe62d;',
				'icon-tumblr': '&#xe62e;',
				'icon-facebook': '&#xe62f;',
				'icon-list': '&#xe630;',
				'icon-layout': '&#xe61e;',
				'icon-text': '&#xe631;',
				'icon-rss': '&#xe632;',
				'icon-checkmark': '&#xe633;',
				'icon-lock': '&#xe634;',
				'icon-export': '&#xe635;',
				'icon-heart2': '&#xe636;',
				'icon-heart3': '&#xe637;',
				'icon-forward': '&#xe638;',
				'icon-reply': '&#xe639;',
				'icon-earth': '&#xe63a;',
				'icon-info': '&#xe63b;',
				'icon-warning': '&#xe63c;',
				'icon-shuffle': '&#xe63d;',
				'icon-resize-enlarge': '&#xe63e;',
				'icon-resize-shrink': '&#xe63f;',
				'icon-sina-weibo': '&#xe640;',
				'icon-renren': '&#xe641;',
				'icon-qq': '&#xe642;',
				'icon-pinterest': '&#xe643;',
				'icon-linkedin': '&#xe644;',
				'icon-paypal': '&#xe645;',
				'icon-picasa': '&#xe646;',
				'icon-mixi': '&#xe647;'
			};

			$.each(icons, function (key, value) {
				var icon = $('.' + key);
				icon.html(value);
				icon.addClass('ie-icon');
			});
		}

		// 修复 position:fixed
		function fixFixedElements () {
			var $fixedEls = $('[style*="position:fixed"], [data-fixed]');
			$fixedEls.each(function () {
				var $el = $(this);
				var top = parseInt($el.css('top'), 10) || 0;
				var left = parseInt($el.css('left'), 10) || 0;
				$el.data('_fixedTop', top).data('_fixedLeft', left).css('position', 'absolute');
			});

			function updatePosition () {
				var scrollTop = $(window).scrollTop();
				var scrollLeft = $(window).scrollLeft();
				$fixedEls.each(function () {
					var $el = $(this);
					$el.css({
						top: $el.data('_fixedTop') + scrollTop,
						left: $el.data('_fixedLeft') + scrollLeft
					});
				});
			}

			$(window).on('scroll resize', updatePosition);
			updatePosition();
		}

		function setTagCloudStyle () {
			var colors = new Array("color0", "color1", "color2", "color3", "color4", "color5", "color6");
			var sizes = new Array("size0", "size1", "size2", "size3", "size4", "size5", "size6");
			var weights = new Array("weight0", "weight1", "weight2", "weight3", "weight4", "weight5", "weight6");
			var colorsLen = colors.length;
			var sizesLen = sizes.length;
			var weightsLen = weights.length;

			// jQuery版本：直接选择tagCloud中的所有a标签
			$(".widget-tags a").each(function () {
				var randomColor = colors[Math.floor(colorsLen * Math.random())];
				var randomSize = sizes[Math.floor(sizesLen * Math.random())];
				var randomWeight = weights[Math.floor(weightsLen * Math.random())];

				// 使用jQuery的addClass()方法设置样式
				$(this).addClass(randomColor + " " + randomSize + " " + randomWeight);
			});
		}

	});


})(jQuery);