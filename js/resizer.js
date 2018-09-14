/* function getParameterByName(name, url) {
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

 */

var ruler_class, form_structure, screen, max_size, pattern, url, dataString, guide_size, current_device, capture_url, valid_url, resizer_active, main, submit_btn;
resizer_active = false;
main = $('.main');

function isURL(str) {
    pattern = /^(http|https):\/\/(([a-zA-Z0-9$\-_.+!*'(),;:&=]|%[0-9a-fA-F]{2})+@)?(((25[0-5]|2[0-4][0-9]|[0-1][0-9][0-9]|[1-9][0-9]|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9][0-9]|[1-9][0-9]|[0-9])){3})|localhost|([a-zA-Z0-9\-\u00C0-\u017F]+\.)+([a-zA-Z]{2,}))(:[0-9]+)?(\/(([a-zA-Z0-9$\-_.+!*'(),;:@&=]|%[0-9a-fA-F]{2})*(\/([a-zA-Z0-9$\-_.+!*'(),;:@&=]|%[0-9a-fA-F]{2})*)*)?(\?([a-zA-Z0-9$\-_.+!*'(),;:@&=\/?]|%[0-9a-fA-F]{2})*)?(\#([a-zA-Z0-9$\-_.+!*'(),;:@&=\/?]|%[0-9a-fA-F]{2})*)?)?$/;
    return pattern.test(str);
}

$('form').submit(function() {
    url = $('#url').val();
    valid_url = '';
    submit_btn = $('#submitted');
    if (isURL(url)) {
        valid_url = url;
        dataString = 'url=' + url;
        dataString += resizer_active == false ? '&resize=true' : '&resize=false';
        submit_btn.val('TRUE');
        dataString += '&submitted=' + submit_btn.val();
    } else {
        dataString = null;
    }
    if (dataString != null) {
        $.ajax({
            type: "POST",
            url: "resizer_submit.php",
            data: dataString,
            cache: true,
            success: (function (result) {
                main.append(result);
                if(resizer_active == true) {
                    $('.device iframe').attr('src',valid_url);
                }
            })
        });
    }
    if (main.hasClass('resizer-field-active'))
        main.removeClass('resizer-field-active');
    return false;
});

$('body').on('resizer', function(event,default_url) {
    if (typeof default_url === 'undefined') {
        default_url = "";
    }
    if($('#url').val().length == 0) {
        $('#url').val(default_url);
    }
    $("#url").focus(function() {
        $('.main').addClass("resizer-field-active");
    }).blur(function() {
        $('.main').removeClass("resizer-field-active");
    });
});

$('body').on('resize_active', function() {
    $('.full-form').removeClass('full-form').addClass('resizer-filter');
    form_structure = $('.resizer-filter fieldset').html();
    $('.resizer-filter form').append(form_structure);
    $('.resizer-filter form > fieldset').remove();
    $('.resizer-filter form > legend').remove();
    $('body').trigger('resizer', [url]);
    screen = $(window).outerWidth(true);
    $('.screen-width .guide-start').prepend(screen);
    $('.screen-width .guide-end').append(screen);
    max_size = $('.default-size span.guide-start').text() + 'px';
    $('.device').css('width', max_size);
    $('.guide').click(function() {
        if(!$(this).hasClass('guide-active')) {
            if (current_device == null)
                current_device = $('.device').attr('class');
            if ($(this).hasClass('screen-width')) {
                $('.device').attr('class', current_device);
            } else {
                guide_size = $(this).attr('class');
                guide_size = guide_size.split(' ');
                guide_size = current_device + ' ' + guide_size[2] + '-device';
                $('.device').attr('class', guide_size);
            }
            $('.guide-active').removeClass('guide-active');
            $(this).addClass('guide-active');
        }
    });
    $('.ruler span i').click(function (e) {
        e.stopPropagation();
        width = $(this).parent('span').text();
        width = parseInt(width);
        height = $(window).outerHeight(true);
        height = parseInt(height);
        specs = "location=no, scrollbar=no, menubar=no, toolbars=no, resizable=yes, left=0, top=0, width=" + width + ", height=" + height;
        url = 'resizable.php?url=' + $('iframe').attr('src');
        e.preventDefault();
        window.open(url, width, specs);
    });
    resizer_active = true;

    $('.devices-option a').click(function() {
        $(this).closest('li').addClass('devices-active');
        $(this).closest('li').siblings().each(function() {
            $(this).removeClass('devices-active');
        });
        url = $('.capture_url').text();
        device = $(this).attr('title');
        device = device.replace(" ","_");
        if (isURL(url)) {
            dataString = 'url=' + url;
            dataString += resizer_active == false ? '&resize=true' : '&resize=false';
            dataString += '&device=' + device;
        } else {
            dataString = null;
        }
        if (dataString != null) {
            $.ajax({
                type: "POST",
                url: "resizer_submit.php",
                data: dataString,
                cache: true,
                success: (function (result) {
                    main.append(result);
                    ruler_class= device.replace("_Screens", "");
                    device_class= 'device ' + ruler_class.toLowerCase() + '-device';
                    ruler_class= 'ruler ' + ruler_class.toLowerCase() + '-ruler';
                    $('.ruler').attr('class', ruler_class);
                    $('.ruler').attr('width', ruler_class);
                    $('.device').attr('class', device_class);
                })
            });
        }
    });
    $('.refresh').click(function () {
        var cache = url + "?ver=" + Math.floor((Math.random() * 100000) + 1);
        $('iframe').attr('src', cache);
    });
    $('.capture').click(function (e) {
        width = $('.guide-active .guide-start').text();
        height = $(window).outerHeight(true);
        specs = "location=no, scrollbar=no, menubar=no, toolbars=no, resizable=yes, left=0, top=0, width=" + width + ", height=" + height;
        capture_url = "capture.php?url=" + $('iframe').attr('src') + "&w=" + width + "&h=" + height;
        e.preventDefault();
        window.open(capture_url, width, specs);
    });
    $('.resize-widget a').click(function() {
        $(this).closest('.resize-widget').toggleClass('resize-widget-active');
    });
});
