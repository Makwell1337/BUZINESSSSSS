<?php
  require "db.php";
  $data = $_POST;
  $userunban = R::findLike('users', array(
                'chatban' => array('1')
              ), 'ORDER BY `id` ASC');
        foreach( $userunban as $userunban )
        {  
          $ub = R::load('users', $userunban->id);
          $ub->chatban = 0;
          R::store($ub);
          $ub = $ub->fresh();
          $chat = R::dispense('chat');
          $chat->name = 'Роскомнадзор';
          $chat->message = $userunban->login." был разбанен!";
          $chat->img = "system.svg";
          R::store($chat);
        }
?>