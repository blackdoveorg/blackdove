window.jumpScroll = function(from, to, position)
{
    $(from).click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(to).offset().top
        }, 1000);
    });
}