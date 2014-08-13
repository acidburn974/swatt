$("#header-login").click(function(event) {
    event.preventDefault();
    $("#l-toplogin").slideDown();
});

$(document).mouseup(function (e)
{
    var container = $("#l-toplogin");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.slideUp();
    }
});