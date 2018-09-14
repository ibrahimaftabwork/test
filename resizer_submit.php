<?
session_start();
require_once('inc/setting.php');
$u = null; $s = null; $error = null;
if (!empty($_POST['url'])) {
    $u = $_POST['url'];
} else {
    $error = 1;
}
if (!empty($_POST['device'])) {
    $s = $_POST['device'];
    $s = str_replace('_', ' ', $s);
} else {
    $s = "Desktop Screens";
}
if(isset($_POST['submitted'])) :
    if(!isset($_SESSION['agent'])) {
        if (empty($error)) {
            $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
            $_SESSION['url'] = $u;
            $_SESSION['screens'] = $s;
        }
    }
endif;

$_SESSION['url'] = ($_SESSION['url'] != $u ? $u : $_SESSION['url']);
$_SESSION['screens'] = ($_SESSION['screens'] != $s ? $s : $_SESSION['screens']);
if($_POST['resize'] == 'true') {
    require_once ('inc/_resize.php');
}
