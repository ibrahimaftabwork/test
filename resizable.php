<!DOCTYPE html>
<html>
<head>
    <title>Resizable</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .alert {
            color: red;
            font-size: 16px;
        }
        iframe {
            padding-top: 40px;
            width: 100%;
            height: 100%;
        }
        .resizable-size {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            line-height: 40px;
            background-color: #efefef;
            display: block;
        }
        .resizable-size span {
            font-size: 12px;
            font-family: Arial, sans-serif;
            display: inline-block;
            padding: 0 15px;
        }
        .pull-left {
            float: left
        }
        .pull-right {
            float: right
        }
        .resizable-size .device-size {
            display: block;
            text-align: center;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>

	<script>
		function watch_resize() {
			var w = window.innerWidth;
			var span = document.querySelectorAll('.resizable-size span');
			if(w >= 1200)
				span[1].innerHTML = 'Large Desktop Size';
			else if((w < 1200) && (w > 991))
				span[1].innerHTML = 'Desktop Size';
			else if((w < 992) && (w > 767))
				span[1].innerHTML = 'Tablet Size';
			else if(w < 768 && (w > 580))
				span[1].innerHTML = 'Mobile Size';
			else
				span[1].innerHTML = 'Small Mobile Size';
			span[0].innerHTML = w;
			span[2].innerHTML = w;
		}
		window.addEventListener('load', watch_resize, true);
		window.addEventListener('resize', watch_resize, true);
	</script>
</head>
<body>
<? if(!empty($_GET['url'])) {
    $url = $_GET['url'];
} else
    $error = TRUE;
if(empty($error))
    echo "<div class='resizable-size'><span class='pull-left'></span> <span class='device-size'></span> <span class='pull-right'></span></div><iframe src='$url' frameborder='0'></iframe>";
else
    header('Location: index.php'); ?>

<div class="resizable-size">
</div>
</body>
</html>