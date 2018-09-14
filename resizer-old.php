<?
require_once('inc/setting.php');
$url = NULL;
$device_size = NULL;
$screen = NULL;
if (isset($_GET['url']) && !empty($_GET['url']))
    $url = $_GET['url'];
else
    header('Location: index.php');

$arr = substr($url, 0, 7);
if (!empty($arr[1])) {
    $full_url = ($arr == "http://") ? $url : ($arr == "https:/") ? $url : "http://$url";
} else {
    $full_url = "http://$url";
}

$size = (isset($_GET['size'])) ? $_GET['size'] : "All";

switch ($size) {
    case("All"):
        $device_size = "All";
        break;
    case("Mobile"):
        $device_size = "Mobile";
        break;
    case("Tablet"):
        $device_size = "Tablet";
        break;
    case("Desktop"):
        $device_size = "Desktop";
        break;
    default:
        $device_size = "All";
        break;
}

$screen = ($device_size == "All") ? true : ($device_size == "Desktop") ? true : NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Responsive Checker</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="grid-bg">
<div class="ruler hidden">
    <? if (isset($screen)) : ?>
        <a href="javascript:void(0)" class="width screen-width" data-width="">
            <span><i class="fa fa-external-link"></i></span>
            <span><i class="fa fa-external-link"></i></span>
        </a>
    <? endif; ?>
    <? foreach ($resolution as $key => $value) {
        if (is_array($value) && $key == $device_size) {
            foreach ($value as $k => $v) { ?>
                <a href="javascript:void(0)" class="width" style="width: <?= $v ?>px">
                    <span><?= $v ?><i class="fa fa-external-link"></i></span>
                    <span><?= $v ?><i class="fa fa-external-link"></i></span>
                </a>
            <? }
        }
    } ?>
</div>
<div id="website" class="website">
    <iframe src="<?= $full_url ?>" frameborder="0">Invalid Url</iframe>
</div>
<a href="#" class="resizer-icon capture" title="Screen Capture"
   target="_blank">
    <i class="fa fa-camera"></i>
</a>
<a href="javascript:void(0)" class="resizer-icon screens" title="Change Size">
    <i class="fa fa-arrows-alt"></i>
    <i class="fa fa-times hide"></i>
</a>
<ul class="screens-option">
    <li><a href="inc/_resize.php?url=<?= $full_url ?>&size=Mobile" class="fa fa-mobile" title="View on Mobile Sizes"></a></li>
    <li><a href="inc/_resize.php?url=<?= $full_url ?>&size=Tablet" class="fa fa-tablet" title="View on Tablet Sizes"></a></li>
    <li><a href="inc/_resize.php?url=<?= $full_url ?>&size=Desktop" class="fa fa-desktop" title="View on Desktop Sizes"></a></li>
    <li><a href="inc/_resize.php?url=<?= $full_url ?>&size=All" title="View on All Sizes">ALL</a></li>
</ul>
<a href="index.php" class="resizer-icon new" title="Go Back and Fill the form">
    <i class="fa fa-sign-out"></i>
</a>
<a href="javascript:void(0)" class="resizer-icon refresh" title="Refresh Page">
    <i class="fa fa-refresh"></i>
</a>
<span class="hide capture_url"><?= $full_url ?></span>
</body>
<script src="js/jquery.js"></script>
<script src="js/resizer.min.js"></script>
</html>
