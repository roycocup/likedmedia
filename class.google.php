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
		return $client;
	}

	public function authenticate(){
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);
		if (isset($_REQUEST['logout'])) {
			unset($_SESSION['access_token']);
		}

		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		}

		if (isset($_SESSION['access_token'])) {
			$client->setAccessToken($_SESSION['access_token']);
		}

		if ($client->getAccessToken()) {
			$me = $plus->people->get('me');

			// These fields are currently filtered through the PHP sanitize filters.
			// See http://www.php.net/manual/en/filter.filters.sanitize.php
			$url = filter_var($me['url'], FILTER_VALIDATE_URL);
			$img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
			$name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

			$optParams = array('maxResults' => 100);
			$activities = $plus->activities->listActivities('me', 'public', $optParams);
			$activityMarkup = '';
			foreach($activities['items'] as $activity) {
		    // These fields are currently filtered through the PHP sanitize filters.
		    // See http://www.php.net/manual/en/filter.filters.sanitize.php
				$url = filter_var($activity['url'], FILTER_VALIDATE_URL);
				$title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
				$activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
			}

  			// The access token may have been updated lazily.
			$_SESSION['access_token'] = $client->getAccessToken();
		} else {
			$authUrl = $client->createAuthUrl();
		}
		
	}

}



