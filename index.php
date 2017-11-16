<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
$callback = urlencode('http://' . $_SERVER['HTTP_HOST']  . '/callback.php');
$key = sha1(microtime());
$url = 'https://access.line.me/oauth2/v2.1/authorize?scope=profile&response_type=code&client_id=1546810912&redirect_uri=' . $callback . '&state=' . $key;
echo '<a href=' . $url . ' class="btn btn-primary">Login</a>' . PHP_EOL;

?>
</div>
</body>
</html>
