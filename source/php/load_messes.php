<?php
require "db.php";
$data = $_POST;
$chat = R::findAll('chat',"ORDER BY `id` DESC LIMIT 20");
foreach( $chat as $chat )
{
	$users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
	foreach( $users as $user )
	{
		$userRole = $user->role;
	}
    if( $userRole == "admin" or $userRole == "mod" )
    {
    	echo('<div class="chat_chat"><div class="chat_left">
      <div style="background-image: url(img/profiles/'.$chat->name.'/'.$chat->img.');" class="chat_img"></div><div class="chat_name">'.$chat->name.':</div></div>
      <div class="chat_message"> '.$chat->message.'</div>
      <div class="chat_date">'.$chat->date.'</div><form action="php/chatban.php" method="POST"><input id="banid" name="ban_id" type="hidden" value="'.$chat->userid.'"><button name="ban" type="submit" class="chat_ban">X</button></form></div>
      ');
    } else
    {
    	echo('<div class="chat_chat"><div class="chat_left">
      <div style="background-image: url(img/profiles/'.$chat->name.'/'.$chat->img.');" class="chat_img"></div><div class="chat_name">'.$chat->name.':</div></div>
      <div class="chat_message"> '.$chat->message.'</div>
      <div class="chat_date">'.$chat->date.'</div></div>
      ');
    }
}
?>