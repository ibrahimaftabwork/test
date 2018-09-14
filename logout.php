<? require_once('inc/functions.php');
$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '', time() - 3600, '/', '', 0, 0);
$homepage = home_url();
header("Location: $homepage");
