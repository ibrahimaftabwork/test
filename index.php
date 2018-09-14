<?
session_start();
require_once('inc/setting.php');
require_once('inc/function_errors.php');
$current_url = '';
$submitted = 'FALSE';
$rc = 'full-form';
if(isset($_SESSION['agent']) && ($_SESSION['agent'] == md5($_SERVER['HTTP_USER_AGENT']))) {
    $current_url = $_SESSION['url'];
    $submitted = 'TRUE';
    $rc = 'resizer-filter';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Re-sizer</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main class="main <?=$rc?>" id="main">
    <form class="form" method="post"> <!-- action="resizer_submit.php" -->
        <? if($rc === 'full-form') : ?>
            <fieldset>
                <legend>Resizer</legend>
        <? endif; ?>
            <label>
                <span><i class="fa fa-globe"></i> URL</span>
                <input type="url" name="url" id="url" value="<?=$current_url?>" placeholder="Enter URL" required>
            </label>
            <input type="hidden" name="submitted" id="submitted" value="<?=$submitted?>">
            <button id="submit" type="submit" name="submit">Submit <i class="fa fa-search"></i></button>
        <? if($rc === 'full-form') : ?>
            </fieldset>
        <? endif; ?>

    </form>
    <script src="js/jquery.js"></script>
    <script src="js/resizer.min.js"></script>
    <!--[if lt IE 9]>
    <script>
        document.createElement("device");
        document.createElement("ruler");
    </script>
    <![endif]-->
    <? if(!empty($current_url)) {
        require_once('inc/_resize.php');
    } if(!empty($current_url)) { ?>
        <script>
            var url = "<?=$current_url ?>";
            $('body').trigger('resizer', [url]);
        </script>
    <? } ?>
</main>
</body>
</html>