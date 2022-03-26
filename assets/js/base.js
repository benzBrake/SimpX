$(document).ready(function(){
    $(".main-menu li.has-dropdown").hover(function () {
        $(this).addClass('block')
    },function () {
        $(this).removeClass('block');
    })
    $("#container").css('min-height', $("#left-sidebar").height());
    $("#goTop").click(function (){
        $(window).scrollTop(0);
    });
});