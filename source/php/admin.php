<?php
  require "db.php";

  $login = 'link';
      $password = 'sticks18rus';

      $data = $_POST;
      if( isset($data['do_login']) )
      {
        $errors = array();

        if ($data['login'] != $login) {
          $errors[] = 'Неверный логин';
        }

        if ($data['password'] != $password) {
          $errors[] = 'Неверный пароль';
        }

        if( ! empty($errors) )
        {
          echo '<div class="reg__errors">'.array_shift($errors).'</div>';
        } else {
          echo '<a class="reg__done" href="admin-edit.php"> Войти'.'</a>';
        }
      }
?>

<html>
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <link href="../style/app.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="../style/foundation.css" rel="stylesheet" media="screen, projection, print"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <title><?php echo($title) ?></title>
  </head>
  <body>
    <div class="wrapper">
      <main class="client__main">
        <form action="admin.php" accept-charset="utf-8" method="POST" class="client__editor email__editor">
            <input type="text" name="login" class="login">
            <input type="password" name="password" class="password">
            <button class="client__editor-confirm" type="submit" id="client__submit" name="do_login">Войти</button>
        </form>
      </main>
    </div>
    <script src="/js/foundation.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>