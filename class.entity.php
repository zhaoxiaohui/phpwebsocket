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
		$clientid = $id;
		$curip = $ip;
	}
}

class OnLineUser{
	private $users = array();
	
	public function addUser($user, $name){
		$this->users[$name] = $user;
		print_r($this->users[$name]);
	}
	public function getUser($name){
		if(in_array($name,$this->users)){
			return $this->users[$name];
		}
		return null;
	}
}
?>
