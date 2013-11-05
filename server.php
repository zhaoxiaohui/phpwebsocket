<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';
require 'class.taobao.php';
require 'class.db.php';
require 'class.entity.php';
// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	
	global $taobao;
	global $onlines;
	global $Server;
	global $db;
	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
	//分析消息
	$messagejson = json_decode($message,true);

	var_dump($messagejson);
	switch($messagejson["type"]){
		case "login":
			$msg = null;
            if($taobao->login($messagejson["playboard"]["username"],$messagejson["playboard"]["password"])){
            	$user = new User($clientID,long2ip( $Server->wsClients[$clientID][6]));
				$onlines->addUser($user,$messagejson["playboard"]["username"]);
			    $msg = array("type"=>"login","playboard"=>array("login"=>$messagejson["playboard"]["username"]));
            }
            else $msg = array("type"=>"login","playboard"=>array("login"=>null));
			$Server->wsSend($clientID, json_encode($msg));
			break;
		case "getfriends":
			$Server->wsSend($clientID, $db->getFriends($messagejson["playboard"]["username"]));
			break;
		case "conversation":
			//if($messagejson["playboard"]["to"] != null && in_array($messagejson["playboard"]["to"],$clients))
			var_dump($onlines);
			$to = $onlines->getUser($messagejson["playboard"]["to"]);
			if($to)
            	$Server->wsSend($to->clientid,$message);
			break;
	}
	//$Server->wsSend($clientID, "xx");
	/**
	$ip = long2ip( $Server->wsClients[$clientID][6] );
	//The speaker is the only person in the room. Don't let them feel lonely.
	if ( sizeof($Server->wsClients) == 1 )
		$Server->wsSend($clientID, "There isn't anyone else in the room, but I'll still listen to you. --Your Trusty Server");
	else
		//Send the message to everyone but the person who said it
		foreach ( $Server->wsClients as $id => $client )
			if ( $id != $clientID )
				$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
	*/
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );
	$Server->log( "$ip ($clientID) has connected." );

	//Send a join notice to everyone but the person who joined
	//foreach ( $Server->wsClients as $id => $client )
	//	if ( $id != $clientID )
	//		$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.");
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has disconnected." );

	//Send a user left notice to everyone in the room
	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
}

$onlines = new OnLineUser();
$taobao = new Taobao();
$db = new DB();
// start the server
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$Server->wsStartServer('0.0.0.0', 9300);

?>
