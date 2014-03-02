<?php
session_start();
error_reporting(E_ALL);
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
	header('Location: http://' . $_SERVER['HTTP_HOST']);
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
	<?php if (empty($_SESSION)): ?>
		<?php if (!empty($authUrl)): ?>
			<div class="jumbotron">
				<h1>Like Digital Media</h1>
				<p>This is a simple app that enables you to see your google calendar</p>
				<p><a href="<?php echo $authUrl; ?>" class="btn btn-primary btn-lg" role="button">Begin!</a></p>
			<?php elseif(empty($_SESSION)): ?>
				<h1>Sorry...</h1>
				<p>If you can't see a button below, its because something is not working.... </p>
			</div>
		<?php endif; ?>

	<?php else: ?>
		<div class="container">
			<div class="h1 text-center">Welcome to the calendar app</div>
			<div class="h3">This is a tiny application just to show that I can actually plug into the google API and move things around</div>	
			<div>
				here
				<?php var_dump($goo->getCalList()); ?>
				there
			</div>
		</div>
	<?php endif; ?>
</body>
</html>