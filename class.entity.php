<?php
/*
 * Created on 2013-11-4
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class User{
	public $clientid = null;
	public $curip = null;
	public function User($id, $ip){
		$this->clientid = $id;
		$this->curip = $ip;
	}
}

class OnLineUser{
	private $users = array();
	
	public function addUser($user, $name){
		$this->users[$name] = $user;
		print_r($this->users[$name]);
	}
	public function getUser($name){
        print_r($name);
		if(array_key_exists($name,$this->users)){
			return $this->users[$name];
		}
        print_r("false");
		return null;
	}
}
?>
