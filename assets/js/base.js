jQuery.getPos = function (e)
{
	var l = 0;
	var t  = 0;
	var w = jQuery.intval(jQuery.css(e,'width'));
	var h = jQuery.intval(jQuery.css(e,'height'));
	var wb = e.offsetWidth;
	var hb = e.offsetHeight;
	while (e.offsetParent){
		l += e.offsetLeft + (e.currentStyle?jQuery.intval(e.currentStyle.borderLeftWidth):0);
		t += e.offsetTop  + (e.currentStyle?jQuery.intval(e.currentStyle.borderTopWidth):0);
		e = e.offsetParent;
	}
	l += e.offsetLeft + (e.currentStyle?jQuery.intval(e.currentStyle.borderLeftWidth):0);
	t  += e.offsetTop  + (e.currentStyle?jQuery.intval(e.currentStyle.borderTopWidth):0);
	return {x:l, y:t, w:w, h:h, wb:wb, hb:hb};
};
jQuery.getClient = function(e)
{
	if (e) {
		w = e.clientWidth;
		h = e.clientHeight;
	} else {
		w = (window.innerWidth) ? window.innerWidth : (document.documentElement && document.documentElement.clientWidth) ? document.documentElement.clientWidth : document.body.offsetWidth;
		h = (window.innerHeight) ? window.innerHeight : (document.documentElement && document.documentElement.clientHeight) ? document.documentElement.clientHeight : document.body.offsetHeight;
	}
	return {w:w,h:h};
};
jQuery.getScroll = function (e)
{
	if (e) {
		t = e.scrollTop;
		l = e.scrollLeft;
		w = e.scrollWidth;
		h = e.scrollHeight;
	} else  {
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
jQuery.intval = function (v)
{
	v = parseInt(v);
	return isNaN(v) ? 0 : v;
};
jQuery.fn.ScrollTo = function(s) {
	o = jQuery.speed(s);
	return this.each(function(){
		new jQuery.fx.ScrollTo(this, o);
	});
};
jQuery.fx.ScrollTo = function (e, o)
{
	var z = this;
	z.o = o;
	z.e = e;
	z.p = jQuery.getPos(e);
	z.s = jQuery.getScroll();
	z.clear = function(){clearInterval(z.timer);z.timer=null};
	z.t=(new Date).getTime();
	z.step = function(){
		var t = (new Date).getTime();
		var p = (t - z.t) / z.o.duration;
		if (t >= z.o.duration+z.t) {
			z.clear();
			setTimeout(function(){z.scroll(z.p.y, z.p.x)},13);
		} else {
			st = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.y-z.s.t) + z.s.t;
			sl = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.x-z.s.l) + z.s.l;
			z.scroll(st, sl);
		}
	};
	z.scroll = function (t, l){window.scrollTo(l, t)};
	z.timer=setInterval(function(){z.step();},13);
};
(function($)
{
$(document).ready(function() {

	$("a[rel='external'],a[rel='external nofollow']").click(function(){window.open(this.href);return false});
	$('.gotop').click(function(){$('#header').ScrollTo(800);return false;});
	$('.addcomment').click(function(){$('#respond').ScrollTo(1000);return false;});
	$('.re_icon a').click(function(){$('#respond').ScrollTo(800);return false;});
	$(".applyalt li:odd").addClass("alternative");
	
	//Reply
	$('.comment-author').hover(function(){$(this).find('.re_icon').show()},function(){$(this).find('.re_icon').hide()});
	
	var $author = jQuery('#author');
    var $author_email = jQuery('#email');
    if ($author.val() != '' && $author_email.val() != '') {
        $author = $author.parent().css('display','none');
        $author_email = $author_email.parent().css('display','none');
        var $author_url = jQuery('#url').parent().css('display','none');
        $author.before(jQuery('<div class="form_line">Welcome Back, '+ $author.find('#author').val() +' </div>').append(
            jQuery('<a href="#">Change &raquo;</a>').click(function(){
                 $author.slideDown(500);
                 $author_email.slideDown(500);
                 $author_url.slideDown(500);
                 jQuery(this).parent().remove();
                 return false;
            })
        ));
    }
	
		$('.re_icon a').click(function(){
			$('textarea#comment').clone().appendTo('#re-use');					
			$('textarea#comment:first').remove();
			$('#cancel-comment-reply').show();
			var atname = $(this).parents(".message_head").find("cite").text();
			var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
			$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
		});
		
		$('ul.children').each(function() {
			$(this).find("li:first .message_head").addClass("ph-adjust");
		});
		$('.atclass').click(function() {
			$('textarea#comment').clone().appendTo('#re-use');					
			$('textarea#comment:first').remove();
			$('#cancel-comment-reply').show();
			var atname = $(this).parents(".message_head").find("cite").text();
			var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
			$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
		});
		
		$('#cancel-comment-reply-link').click(function() {
			$("#comment").empty();
		});

	$('.re_icon').click(function(){
		$('#cancel-comment-reply').show();
	});

});

})(jQuery);