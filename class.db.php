<?php
/*
 * Created on 2013-11-5
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class DB{
 	function DB(){}
 	function getFriends($username){
 		 	$msg = array("type"=>"getfriends","playboard"=>array(array(
					"name"=>"xxx",
					"label"=>array("1","2","3"),
					"img"=>""
				),array(
				
					"name"=>"yy2",
					"label"=>array("1","2","3"),
					"img"=>""
				),array(
                    "name"=>"赵辉",
                    "label"=>null,
                    "img"=>""
                ))
			);
			return json_encode($msg);
 	}
 }
?>
