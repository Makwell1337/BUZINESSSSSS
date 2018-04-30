<?php
require "db.php";
$data = $_POST;
if($_POST['mess'] != "" && $_POST['mess'] != " " && strlen($_POST['mess']) < 257 )
{
	$user = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
	foreach( $user as $user )
	{
	  if( $user->chatban == 0 )
	  {
		  $chat = R::dispense('chat');
		  $chat->img = $user->img;
		  $chat->date = date("h:i:s");
		  $chat->name = $_SESSION['logged_user']->login;
		  $chat->message = $_POST['mess'];
		  $chat->userid = $_SESSION['logged_user']->id;
		  R::store($chat);
	  } else {
	  	exit('Вы были забанены в чате!');
	  }
	}
}
?>