<?
if (isset($_GET['capture']) && !empty($_GET['capture']))
    $capture = $_GET['capture'];
else {
    header('Location: index.php');
    exit();
}
$width = (isset($_GET['size']) && !empty($_GET['capture'])) ? $width = $_GET['size'] : $width = "100%";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Screen Capture</title>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<input type="hidden" name="image" value="<?= $capture ?>">
<input type="hidden" name="width" value="<?= $width ?>">
<div class="website">
    <div id="content"></div>
</div>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/html2canvas.min.js"></script>
<script>
    function iframeLoad(iframe) {
        var body = $(iframe).contents().find('body');
        html2canvas(body, {
            onrendered: function (canvas) {
                $("#content").empty().append(canvas);
            },
            allowTaint: true,
            taintTest: false,
            logging: true
        });
    }

    $(document).ready(function () {
        var url = $('input[name=image]').val();
        var size = $('input[name=width]').val();
        var urlParts = document.createElement('a');
        urlParts.href = url;

        $.getJSON("http://html2canvas.appspot.com/query?callback=?", {
            xhr2: false,
            url: urlParts.href
        }, function (html) {
            iframe = document.createElement('iframe');
            $(iframe).css({'visibility': 'hidden'}).width(size).height($(window).height());
            $('#content').append(iframe);
            d = iframe.contentWindow.document;
            d.open();
            $(iframe.contentWindow).load(iframeLoad.bind(null, iframe));
            $('base').attr('href', urlParts.protocol + "//" + urlParts.hostname + "/" + urlParts.pathname);
            html = html.replace("<head>", "<head><base href='" + urlParts.protocol + "//" + urlParts.hostname + "/" + urlParts.pathname + "'  />");
            if ($("#disablejs").prop('checked')) {
                html = html.replace(/\<script/gi, "<!--<script");
                html = html.replace(/\<\/script\>/gi, "<\/script>-->");
            }
            d.write(html);
            d.close();
        });

    });
</script>
</body>
</html>