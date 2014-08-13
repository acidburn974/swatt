$("#header-signup").click(function(event) {
    event.preventDefault();
    $("#l-topsignup").slideDown();
});

$(document).mouseup(function (e)
{
    var container = $("#l-topsignup");

    if (!container.is(e.target) 
        && container.has(e.target).length === 0)
    {
        container.slideUp();
    }
});