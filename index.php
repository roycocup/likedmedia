<?php
error_reporting(E_ALL); 
ini_set( 'display_errors','1');
set_include_path("google-api-php-client-master/src/" . PATH_SEPARATOR . get_include_path());
require_once 'Google/Client.php';
require_once 'Google/Service/Calendar.php';
session_start();


$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");

// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('699975976929.apps.googleusercontent.com');
$client->setClientSecret('-SHbDcMUZ5xXvVW2xIaJ6jrV');
$client->setRedirectUri('http://likedmedia.rodderscode.co.uk');
$client->setDeveloperKey('AIzaSyDPf-yxc-KOVzy8765STLmUAlPdrRtd6I8');
$cal = new Google_Service_Calendar($client);
if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $calList = $cal->calendarList->listCalendarList();
  print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";


$_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}

