$(document).ready(function(){
    $(".main-menu li.has-dropdown").hover(function () {
        $(this).addClass('block')
    },function () {
        $(this).removeClass('block');
    })
    $("#container").css('min-height', $("#left-sidebar").height());
    $("#goTop").click(function (){
        $('html,body').animate({ scrollTop: 0 }, '200');
        return false;
    });
});