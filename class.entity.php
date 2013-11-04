<?php
/*
 * Created on 2013-11-4
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class User{
	private $username = null;
	private $curip = null;
	public function User($name, $ip){
		$username = $name;
		$curip = $ip;
	}
	public function getUsername(){
		return $username;
	}
	public function getCurip(){
		return $curip;
	}
}
?>
