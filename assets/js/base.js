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
		var isLtIE7 = (navigator.userAgent.indexOf("MSIE") != -1 && parseFloat(navigator.appVersion.split("MSIE")[1]) < 7);
		if (isLtIE7) {
			updateIcon();
		}

		$("a[rel='external'],a[rel='external nofollow']").click(function () { window.open(this.href); return false });
		$('.gotop').click(function () { try { $('#header').ScrollTo(800); } catch (e) { } return false; });
		$('.addcomment').click(function () { try { $('#respond').ScrollTo(1000); } catch (e) { } return false; });
		$('.re_icon a').click(function () { try { $('#respond').ScrollTo(800); } catch (e) { } return false; });
		$(".applyalt li:odd").addClass("alternative");

		//Reply
		$('.comment-author').hover(function () { $(this).find('.re_icon').show() }, function () { $(this).find('.re_icon').hide() });

		var $author = jQuery('#author');
		var $author_email = jQuery('#email');
		if ($author.val() != '' && $author_email.val() != '') {
			$author = $author.parent().css('display', 'none');
			$author_email = $author_email.parent().css('display', 'none');
			var $author_url = jQuery('#url').parent().css('display', 'none');
			$author.before(jQuery('<div class="form_line">Welcome Back, ' + $author.find('#author').val() + ' </div>').append(
				jQuery('<a href="#">Change &raquo;</a>').click(function () {
					$author.slideDown(500);
					$author_email.slideDown(500);
					$author_url.slideDown(500);
					jQuery(this).parent().remove();
					return false;
				})
			));
		}

		$('.re_icon a').click(function () {
			$('textarea#comment').clone().appendTo('#re-use');
			$('textarea#comment:first').remove();
			$('#cancel-comment-reply').show();
			var atname = $(this).parents(".message_head").find("cite").text();
			var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
			$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
		});

		$('ul.children').each(function () {
			$(this).find("li:first .message_head").addClass("ph-adjust");
		});
		$('.atclass').click(function () {
			$('textarea#comment').clone().appendTo('#re-use');
			$('textarea#comment:first').remove();
			$('#cancel-comment-reply').show();
			var atname = $(this).parents(".message_head").find("cite").text();
			var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
			$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
		});

		$('#cancel-comment-reply-link').click(function () {
			$("#comment").empty();
		});

		$('.re_icon').click(function () {
			$('#cancel-comment-reply').show();
		});

	});

	function updateIcon () {

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
			icon.css('font-family', 'SimpX');
			icon.css('font-style', 'normal');
			icon.css('font-weight', 'normal');
			icon.css('font-variant', 'normal');
			icon.css('text-transform', 'none');
			icon.css('line-height', 1);
			icon.css('speak', 'none');
		});
	}


})(jQuery);