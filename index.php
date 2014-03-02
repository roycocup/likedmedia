<?php

require 'class.google.php';


$goo = new Goo();

$authUrl = $goo->getAuthUrl(); 


//get me out of here
if (isset($_GET['logout'])) {
	unset($_SESSION['token']);
}

$authenticated = false;
if (isset($_GET['code'])) {
	$authenticated = $goo->authenticate($_GET['code']);
}

if ($authenticated){
	header('Location: http://' . $_SERVER['HTTP_HOST'] . "/cal");
}



?>



<html>
<head>
	<meta charset="UTF-8">
	<title>Like Digital Media Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
	<link rel="shortcut icon" href="http://localhost/golders_green/img/favico.ico" />
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/main.css">
	
</head>
<body>
	<div class="jumbotron">
		<?php if (!empty($authUrl)): ?>
			<h1>Like Digital Media</h1>
			<p>This is a simple app that enables you to see your google calendar</p>
			<p><a href="<?php echo $authUrl; ?>" class="btn btn-primary btn-lg" role="button">Begin!</a></p>
		<?php else: ?>
			<h1>Sorry...</h1>
			<p>If you can't see a button below, its because something is not working.... </p>
		<?php endif; ?>

	</div>
</body>
</html>