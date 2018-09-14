<?
$url = (isset($_GET['url']) AND !empty($_GET['url'])) ? $_GET['url'] : '';
$size = array();
define('API_KEY', '16d5c7170b8385c8'); // API Key require from (http://www.page2images.com)
if((isset($_GET['w']) && !empty($_GET['w'])) AND (isset($_GET['h']) && !empty($_GET['h']))) {
    $size[] = $_GET['w'];
    $size[] = $_GET['h'];
}
if((!empty($url)) AND (!empty($size))) {
    list($width, $height) = $size;
    $capture_url = "http://api.page2images.com/directlink?p2i_url=$url&p2i_device=6&p2i_screen=" . $width . "x" . $height . "&p2i_size=" . $width . "x0&p2i_fullpage=1&p2i_refresh=1&p2i_key=" . API_KEY;
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Capture Website</title>
        <meta charset="utf-8">
        <style>
            html, body {
                margin:0;
                padding: 0
            }
        </style>
    </head>
    <body>
        <div class="website">
            <a><img id="p2i_demo" src="<?=$capture_url?>" alt="screen"></a>
            <script src="http://www.page2images.com/js/p2i.js"></script><script type="text/javascript" >
                var p2i=new page2images();
                p2i.thumbnail('p2i_demo');
            </script>
        </div>
        <script src="js/jquery.js"></script>
    </body>
</html>