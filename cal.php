<?php 
//session_id($_GET['PHPSESSID']);
session_start();
var_dump($_SESSION);

require 'class.google.php';



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
	<div class="container">
		<div class="h1 text-center">Welcome to the calendar app</div>
		<div class="h3">This is a tiny application just to show that I can actually plug into the google API and move things around</div>	
	</div>
	
</body>
</html>