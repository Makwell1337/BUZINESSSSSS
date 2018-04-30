<?php

header('Content-Type: text/html; charset=utf-8');
require "db.php";
$data = $_POST;

if ( $_POST['enter'] ) {
  $users = R::find('users',"id = ?", array($_SESSION['logged_user']->id));
  foreach( $users as $users )
  {
    if($_POST['sum'] <= $users->money )
    {
    require_once('cpayeer.php');
    $accountNumber = 'P83120260';
    $apiId = '455386396';
    $apiKey = '123';
    $payeer = new CPayeer($accountNumber, $apiId, $apiKey);

    if ($payeer->isAuth())
    {
      $arTransfer = $payeer->transfer(array(
        'curIn' => 'RUB',
        'sum' => $_POST['sum'],
        'curOut' => 'RUB',
        'to' => $_POST['wallet'],
        'comment' => 'Вывод денег',
      ));
      if (empty($arTransfer['errors']))
      {
        echo ": Перевод средств успешно выполнен, сумма: $_POST[sum], транзакция: $arTransfer[historyId]";
        $user = R::load('users', $_SESSION['logged_user']->id);
        $user->money = $user->money - $_POST['sum'];
        R::store($user);
        $user = $user->fresh();
      }
      else
      {
        echo '<pre>'.print_r($arTransfer["errors"], true).'</pre>';
      }
    }
    else
    {
      echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
    }
  } else {
      echo '<pre>Нельзя вывести больше чем твой баланс</pre>';
  }
  }

}

?>