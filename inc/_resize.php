<?
if(basename($_SERVER['PHP_SELF']) == '_resize.php') {
    header('Location: index.php');
    exit();
}
$url = NULL;
$screen = NULL;
$first_element= '';
$device_sizes_css[] = array();
if(isset($_SESSION['url']))
    $url = $_SESSION['url'];
$arr = substr($url, 0, 7);
if (!empty($arr[1])) {
    $full_url = ($arr == "http://") ? $url : ($arr == "https:/") ? $url : "http://$url";
} else {
    $full_url = "http://$url";
}
$wide = (isset($_SESSION['screens'])) ? $_SESSION['screens'] : "Desktop Screens";
$device = explode(' ', trim($wide));
$device = ' ' . strtolower($device[0]);
?>
<ruler class="ruler<?=$device?>-ruler">
    <a href="javascript:void(0)" class="guide screen-width desktop all guide-active">
        <span class="guide-start"><i class="fa fa-external-link"></i></span>
        <span class="guide-end"><i class="fa fa-external-link"></i></span>
    </a>
    <? foreach ($resolution as $Type => $res) {
        $class = explode(' ', trim($Type));
        $class = strtolower($class[0]);
        $i = 0;
        foreach($res as $size_type => $size) { $i++; ?>
            <? $class_type = explode(' ', trim($size_type)); $active = '';
                $class_type = strtolower($class_type[0]) . '-' . strtolower($class_type[1]);
                if(!file_exists("scss/_device-sizes.scss")) {
                    if ($i == 1) {
                        if ($class != 'desktop')
                            $device_sizes_css[] = ".$class-device { width: $size" . "px }";
                    }
                    $device_sizes_css[] = ".$class_type-device { width: $size" . "px }";
                }
            if (($i == 1) && ($class != 'desktop'))
                $active = ' guide-active';
            $class_type = ' ' . $class_type; ?>
            <a href="javascript:void(0)" class="guide <?=$class,$class_type,$active?>" style="width: <?= $size ?>px" title="<?=$size_type?>">
                <span class="guide-start"><?= $size ?><i class="fa fa-external-link"></i></span>
                <span class="guide-end"><i class="fa fa-external-link"></i><?= $size ?></span>
            </a>
        <? }
    } ?>
</ruler>
<section class="viewport">
    <device class="device<?=$device?>-device">
        <iframe src="<?= $full_url ?>" frameborder="0">Invalid Url</iframe>
    </device>
</section>
<aside class="resize-widget">
    <h4>Devices Option</h4>
    <nav class="devices-option">
        <ul>
            <? foreach ($resolution as $key => $value) { ?>
                <? switch($key) {
                    case "Desktop Screens":
                        $fa_icon = "laptop";
                        break;
                    case "Tablet Screens":
                        $fa_icon = "tablet";
                        break;
                    case "Mobile Screens":
                        $fa_icon = "mobile";
                        break;
                    default:
                        $fa_icon = "";
                }
                $devices_active = '';
                if($_SESSION['screens'] == $key) {
                    $devices_active = ' class=devices-active';
                }
                ?>
                <li<?=$devices_active?>><a class="d-option d-option-<?=$fa_icon?>" href="javascript:void(0)" title="<?=$key?>"><i class="fa fa-<?=$fa_icon?>"></i></a></li >
            <? } ?>
        </ul>
    </nav>
    <nav class="links">
        <ul>
            <li>
                <a href="#" class="resizer-icon capture" title="Screen Capture"
                   target="_blank">
                    <i class="fa fa-camera"></i>
                    <span>Take Screen Shot</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="resizer-icon refresh" title="Refresh Page">
                    <i class="fa fa-refresh"></i>
                    <span>Reload WebSite</span>
                </a>
            </li>
            <li>
                <a href="<?=url?>logout.php" class="resizer-icon new" title="Go Back and Fill the form">
                    <i class="fa fa-sign-out"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </nav>
    <a href="javascript:void(0)" class="resize-widget-toggle">
        <span class="open-menu">Menu</span>
        <span class="close-menu">Close</span>
        <i class="fa fa-chevron-right" aria-hidden="true"></i>
    </a>
</aside>
<span class="hide capture_url"><?= $full_url ?></span>
<script>
    $('body').trigger('resize_active');
</script>
<? clearstatcache(); if(!file_exists("scss/_device-sizes.scss")) {
    $fp = fopen("scss/_device-sizes.scss","w");
    fwrite($fp,"0");
    fclose($fp);
    $output = '';
    foreach($device_sizes_css as $dsc) {
        if (is_array($dsc)) {
            foreach($dsc as $sc)
                $output .= $sc."\n";
        } else
            $output .= $dsc."\n";
    }
    file_put_contents("scss/_device-sizes.scss", $output);
} ?>
