<?php
  header('Content-Type: text/html; charset=utf-8');
  $name = $_POST['ms_name'];
  $mail = $_POST['ms_mail'];
  $about = $_POST['ms_about'];
  $userid = $_POST['ms_userid'];
  $text = $_POST['ms_message'];
  $headers = "MIME-Version: 1.0" . PHP_EOL .
  "Content-Type: text/html; charset=utf-8" . PHP_EOL .
  'From: '.$mail . PHP_EOL .
  'Reply-To: stickslol@mail.ru' . PHP_EOL;
  $message = "Имя пользователя: $name, почта: $mail, тема: $about, ID пользователя: $userid, сообщение: $text";

  mail('stickslol@mail.ru', 'Техподдержка', $message, $headers);

  echo("<div class='mail_success'>Сообщение отправлено<div>");