window.jumpBetween = function(from, to)
{
    $(from).click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(to).offset().top
        }, 1000);
    });
}