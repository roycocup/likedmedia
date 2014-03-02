<?php
session_start();
error_reporting(E_ALL); 
ini_set( 'display_errors','1');
require 'class.google.php';


$goo = new Goo();

$authUrl = $goo->getAuthUrl(); 

//get me out of here
if (isset($_GET['logout'])) {
	unset($_SESSION['token']);
}

if (empty($_SESSION['token'])){
	$authenticated = false;
	if (isset($_GET['code'])) {
		$authenticated = $goo->authenticate($_GET['code']);
	}

	if ($authenticated){
		header('Location: http://' . $_SERVER['HTTP_HOST']);
	}
} 

$goo->setToken();



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
	<?php //landing page ?>
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
	<?php //end of landing page ?>

	<?php //select your calendar page ?>
	<?php elseif (!empty($_POST['next_stage'])): ?>
		<div class="container">
			<div>
				<h3>Buy the full version!</h3>
				<p>I would have loved to keep going but I really started to run out of time... <br>
				I hope this would have served the purpose of showing how I would plug in to google and start fiddling around with its data. <br>
				Thank you very much for your attention and I hope to see you very shortly.</p>
				<address>
					<strong>Rodrigo Dias</strong><br>
					<abbr title="phone">P</abbr> 0759643964 <br>
					<abbr title="email">E</abbr> <a href="mailto:rodrigo@rodderscode.co.uk">rodrigo@rodderscode.co.uk</a>	
				</address>
			</div>
		</div>

	<?php else: ?>
		<?php 
			//Start dealing with the list
			$calendars = $goo->getCalList(); 
			$numCalendars = count($calendars['data']['items']); 
		?>
		<div class="container">
			<div class="h1 text-center">Welcome to the calendar app</div>
			<div class="h3">This is a tiny application just to show that I can actually plug into the google API and move things around</div>	
			<div>
				<?php if ($numCalendars < 1): ?>
					<h3>Unfortunately you dont seem to have any calendars on your Gmail.</h3>
					<h4>Go back and make some and then come back to this.</h4>
				<?php else: ?>
					<form action="" method="post">
						<h3>You have <?php echo $numCalendars ?> calendars in your gmail account</h3>
						<h4>Please select one</h4>
						<select class="form-control" style="width:30%;">
							<?php foreach ($calendars as $calendar) : ?>
								<option><?php echo $calendar['summary']; ?></option>
							<?php endforeach; ?>
						</select>
						<br>
						<input type="hidden" name='next_stage' value='super_hyper_cool_stuff_next_screen'>
						<button type="button" class="btn btn-primary" onclick="submit();">Select</button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</body>
</html>



