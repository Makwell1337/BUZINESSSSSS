<?php
require "db.php";
$data = $_POST;
$user = R::find('users',"id = ?", array($_POST['ban_id']));
foreach( $user as $user )
{
	$ub = R::load('users', $_POST['ban_id']);
  $ub->chatban = 1;
  R::store($ub);
  $ub = $ub->fresh();
  $chat = R::dispense('chat');
  $chat->name = 'Роскомнадзор';
  $chat->message = $user->login." был забанен и будет разбанен на след. день!";
  $chat->img = "system.svg";
  R::store($chat);
}
?>