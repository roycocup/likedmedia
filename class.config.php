<?php

class Config {

	public $config_file = 'config.ini';
	private $_oauth_credentials; 

	public function __construct(){
		$this->_oauth_credentials = parse_ini_file($this->config_file);
	}

	public function getCred($credential){
		return $this->_oauth_credentials[$credential];
	}


}
