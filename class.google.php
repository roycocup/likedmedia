<?php

set_include_path("google-api-php-client-master/src/" . PATH_SEPARATOR . get_include_path());
require_once('class.config.php');
require_once 'Google/Client.php';
require_once 'Google/Service/Calendar.php';

class Goo {

	//main configurations object
	private $_config; 

	//Authorizarion Url - endpoint for the initial request before getting the token.
	private $_authUrl = ''; 

	//the oauth token (also stored in session)
	private $_token = ''; 

	//google client object
	protected $client; 

	//google calendar object
	public $cal; 



	//construct
	public function __construct(){
		$this->_config = new Config();
		$this->init();
	}

	public function getAuthUrl(){
		return $this->_authUrl; 
	}


	public function init(){
		$this->getClient();
		$this->cal = new Google_Service_Calendar($this->client);

		if ($this->client->getAccessToken()){
			$this->authenticate();
		} else {
			$this->_authUrl = $this->client->createAuthUrl();
		}
	}


	public function getClient(){
		$this->client = new Google_Client();
		$this->client->setApplicationName("Calendar Demo with Google API");
		$this->client->setClientId($this->_config->getCred('ID'));
		$this->client->setClientSecret($this->_config->getCred('secret'));
		$this->client->setRedirectUri($this->_config->getCred('callback'));
		$this->client->setDeveloperKey($this->_config->getCred('dev-key'));
		$this->client->setScopes(array(
			'https://www.googleapis.com/auth/calendar', 
			)
		);
	}

	public function authenticate($code){

		//get the app code and exchange it for the oauth token
		$this->client->authenticate($_GET['code']);
		$_SESSION['token'] = $this->_token = $this->client->getAccessToken();

		if (isset($_SESSION['token'])) {
			$this->client->setAccessToken($_SESSION['token']);
			return true;
		}

		return false;

	}


	public function getCalList(){
		$calList = $cal->calendarList->listCalendarList();
		$str = "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";
		return $str;
		// $_SESSION['token'] = $this->client->getAccessToken();
	}
	

}

?>





