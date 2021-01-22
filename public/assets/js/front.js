//auth area
$("#auth_form").on("submit", function() {
    $(".auth_button").append("<i class=\"fa fa-spinner fa-pulse mt-1 float-right\"></i>").attr("disabled", true);
    setInterval(function(){ countTime(); }, 1000);
});
function countTime()
{
    var count = 0;
    count++;
    if(count===10)
    {
        window.location.reload();
    }
}
$(".filter-widget .category-menu li").hover( function(e) {
    $(this).addClass('active');
    e.preventDefault();
});

$('.filter-widget .category-menu li').mouseleave( function(e) {
    $(this).removeClass('active');
    e.preventDefault();
});


$(window).on('scroll',function(){
    if(
        $(this).scrollTop()>500){
        $(".scroll-to-top").fadeIn(400);
    }else{
        $(".scroll-to-top").fadeOut(400);
    }
});
$(".scroll-to-top").on('click',function(event){
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});
$(document).on('click', '.social-button', function (e) {
    var popupSize = {
        width: 780,
        height: 550
    };

    var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
        horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

    var popup = window.open($(this).prop('href'), 'social',
        'width=' + popupSize.width + ',height=' + popupSize.height +
        ',left=' + verticalPos + ',top=' + horisontalPos +
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

    if (popup) {
        popup.focus();
        e.preventDefault();
    }

});
