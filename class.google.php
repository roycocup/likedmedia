<?php

set_include_path("google-api-php-client-master/src/" . PATH_SEPARATOR . get_include_path());
require_once('class.config.php');
require_once 'Google/Client.php';
require_once 'Google/Service/Calendar.php';

class Goo {

	//main configurations object
	private $config; 

	public function __construct(){
		$this->config = new Config();
	}


	public function getClient(){
		$client = new Google_Client();
		$client->setApplicationName("Calendar Demo with Google API");
		$client->setClientId($this->config->getCred('ID'));
		$client->setClientSecret($this->config->getCred('secret'));
		$client->setRedirectUri($this->config->getCred('callback'));
		$client->setDeveloperKey($this->config->getCred('dev-key'));
		$client->setScopes(array(
			'https://www.googleapis.com/auth/calendar', 
			)
		);
		return $client;
	}

	public function authenticate(){
		$client = $this->getClient();
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
		
	}

}



