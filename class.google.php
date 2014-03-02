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
		$client->setClientId($this->config->getCred('ID'));
		$client->setClientSecret($this->config->getCred('secret'));
		$client->setRedirectUri($this->config->getCred('callback'));
		$client->setDeveloperKey($this->config->getCred('dev-key'));
		return $client;
	}

	public function authenticate(){
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);
		$t = $client->authenticate($this->config->getCred('dev-key'));

		var_dump($t); die;

		if (isset($_SESSION['oauth_access_token'])) {
            $client->setAccessToken($_SESSION['oauth_access_token']);
        } else {
            $token = $client->authenticate();
            var_dump($token); die; 
            $_SESSION['oauth_access_token'] = $token;
        }

		
	}

}



