function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(function () {
    var screen, sibling, width, height, capture_url, specs, url, iframe_url;
    screen = $(window).outerWidth(true);
    iframe_url = $('.capture_url').text();
    $('.width').each(function () {
        if ($(this).next().length > 0) {
            sibling = (parseInt($(this).css('width')) - parseInt($(this).next().css('width'))) / 2;
        } else {
            sibling = (parseInt($(this).prev().css('width')) - parseInt($(this).css('width'))) / 2;
        }
        $(this).find('span').css('width', sibling);
    });
    $('iframe').attr('width', $('.width:first-child').outerWidth());
    $('.screen-width span').prepend(screen);
    $('.screen-width').css('width', screen);
    $('.width:first-child').addClass('active');
    $('.width').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
        width = $(this).outerWidth();
        $('.website iframe').attr('width', width);
    });
    $('.ruler').removeClass('hidden');
    $('.refresh').click(function () {
        var cache = Math.floor((Math.random() * 100000) + 1);
        $('iframe').attr('src', iframe_url + "?" + cache);
    });
    $('.ruler span i').click(function (e) {
        width = $(this).parent('span').text();
        width = parseInt(width);
        height = $(window).outerHeight(true);
        height = parseInt(height);
        specs = "location=no, scrollbar=no, menubar=no, toolbars=no, resizable=yes, left=0, top=0, width=" + width + ", height=" + height;
        url = 'resizable.php?url=' + $('iframe').attr('src');
        e.preventDefault();
        window.open(url, width, specs);
    });
    $('.capture').click(function (e) {
        width = $('.active span:first-child').text();
        height = $(window).outerHeight(true);
        specs = "location=no, scrollbar=no, menubar=no, toolbars=no, resizable=yes, left=0, top=0, width=" + width + ", height=" + height;
        url = "capture.php?url=" + $('iframe').attr('src') + "&w=" + width + "&h=" + height;
        e.preventDefault();
        window.open(url, width, specs);
    });
    $('.screens').click(function () {
        $(this).find('i').toggleClass('hide');
        if ($(this).hasClass('screen-dropdown')) {
            $('.screens-option li').removeClass('visible');
            $(this).removeClass('screen-dropdown');
        } else {
            $(this).addClass('screen-dropdown');
            $.each($('.screens-option li'), function (i, el) {
                setTimeout(function () {
                    $(el).addClass('visible');
                }, 100 + ( i * 250 ));

            });
        }
    });
});