$(document).ready(function(){
    $(".main-menu li.has-dropdown").hover(function () {
        $(this).addClass('block')
    },function () {
        $(this).removeClass('block');
    })
	// $("a[rel='external'],a[rel='external nofollow']").click(function(){window.open(this.href);return false});
	// $('.gotop').click(function(){$('#header').ScrollTo(800);return false;});
	// $('.addcomment').click(function(){$('#respond').ScrollTo(1000);return false;});
	// $('.re_icon a').click(function(){$('#respond').ScrollTo(800);return false;});
	// $(".applyalt li:odd").addClass("alternative");
	//
	// //Reply
	// $('.comment-author').hover(function(){$(this).find('.re_icon').show()},function(){$(this).find('.re_icon').hide()});
	//
	// var $author = jQuery('#author');
    // var $author_email = jQuery('#email');
    // if ($author.val() != '' && $author_email.val() != '') {
    //     $author = $author.parent().css('display','none');
    //     $author_email = $author_email.parent().css('display','none');
    //     var $author_url = jQuery('#url').parent().css('display','none');
    //     $author.before(jQuery('<div class="form_line">Welcome Back, '+ $author.find('#author').val() +' </div>').append(
    //         jQuery('<a href="#">Change &raquo;</a>').click(function(){
    //              $author.slideDown(500);
    //              $author_email.slideDown(500);
    //              $author_url.slideDown(500);
    //              jQuery(this).parent().remove();
    //              return false;
    //         })
    //     ));
    // }
	//
	// 	$('.re_icon a').click(function(){
	// 		$('textarea#comment').clone().appendTo('#re-use');
	// 		$('textarea#comment:first').remove();
	// 		$('#cancel-comment-reply').show();
	// 		var atname = $(this).parents(".message_head").find("cite").text();
	// 		var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
	// 		$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
	// 	});
	//
	// 	$('ul.children').each(function() {
	// 		$(this).find("li:first .message_head").addClass("ph-adjust");
	// 	});
	// 	$('.atclass').click(function() {
	// 		$('textarea#comment').clone().appendTo('#re-use');
	// 		$('textarea#comment:first').remove();
	// 		$('#cancel-comment-reply').show();
	// 		var atname = $(this).parents(".message_head").find("cite").text();
	// 		var atid = '"' + $(this).parents(".message_head").find(".get-id").text() + '"';
	// 		$("#comment").append("&lt;a href=" + atid + "&gt;@" + atname + "&nbsp;&lt;/a&gt;").focus();
	// 	});
	//
	// 	$('#cancel-comment-reply-link').click(function() {
	// 		$("#comment").empty();
	// 	});
    //
	// $('.re_icon').click(function(){
	// 	$('#cancel-comment-reply').show();
	// });
});