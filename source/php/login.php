<?php
	require "db.php";
	require "./libs/recaptcha.php";
	require "./config.php";
	$title = 'Ставки на киберспорт. CS:GO ставки. Букмекерская кантора.';

	$data = $_POST;
	if( isset($data['do_login']) )
	{
		$secret = "6Le0vVQUAAAAAETQR3Dv5JsSZnjUJjse6JG3txnm";
		$response = $_POST['g-recaptcha-response'];
		$remoteip = $_SERVER['REMOTE_ADDR'];

		$result = json_decode($url, TRUE);
		$errors = array();
		$userlogin = R::findOne('users', 'login = ?', array($data['login']));
		$useremail = R::findOne('users', 'email = ?', array($data['login']));
		if( isset($_SESSION['logged_user']) )
		{
			$errors[] = 'Вы уже вошли';
		}
		if( $userlogin )
		{
			if( password_verify($data['password'], $userlogin->password) )
			{
				$_SESSION['logged_user'] = $userlogin;
	        	echo ('
		        <div id="notification_box" class="notification_box">
		            <div class="notification_title">Уведомление</div>
		            <div class="notification_text">Вы успешно авторизованы! Можете перейти на <a class="auth_link" href="../index.php">главную</a>.</div>
		            <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
		        </div>');
			} else
			{
				$errors[] = 'Неверно введён пароль';
			}
		} else if ( $useremail ) {
			if( password_verify($data['password'], $useremail->password) )
			{
				$_SESSION['logged_user'] = $useremail;
	        	echo ('
		        <div id="notification_box" class="notification_box">
		            <div class="notification_title">Уведомление</div>
		            <div class="notification_text">Вы успешно авторизованы! Можете перейти на <a class="auth_link" href="../index.php">главную</a>.</div>
		            <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
		        </div>');
			} else
			{
				$errors[] = 'Неверно введён логин или пароль';
			}
		} else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}

		if( ! empty($errors) )
		{
			echo ('
		        <div id="notification_box" class="notification_box">
		            <div class="notification_title">Уведомление</div>
		            <div class="notification_text">Ошибка! '.array_shift($errors).'</div>
		            <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
		        </div>');
		}
	}
?>

<html lang="ru">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="content-language" content="ru" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Ставки на киберспорт. CS:GO ставки."/>
    <meta name="robots" content="index,follow" />
    <meta name="keywords" content="ставки, ставки на ксго, ставки на cs:go, киберспорт, ставки на киберспорт, бк, букмекерская контора">
    <link href="../style/app.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="../style/foundation.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
    <title><?php echo($title) ?></title>
  </head>
  <body>
  	<div class="wrapper">
  		<header class="header">
      <div class="header_left">
        <a href="../index.php" class="header_title">ICE.BET</a>
        <a href="about.php" class="header_text">О нас</a>
        <a href="contacts.php" class="header_text">Связь</a>
      </div>
      <div class="header_right">
        <?php if( isset($_SESSION['logged_user']) ) : ?>
          <div class="header_profile">
            <a href="client.php" class="header_profile-link"><img src="../img/profile.png" class="header_profile-img">Профиль</a>
            <div class="header_balance"> <strong>
              <?php
                $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                foreach( $users as $user )
                {
                  echo $user->money;
                }
              ?>
              </strong><img src="../img/ices.svg" class="header_balance-img">
            </div>
          </div>
        <?php else : ?>
          <div class="header_profile">
            <a href="login.php" class="header_profile-link">Вход</a>
            <a href="reg.php" class="header_profile-link circle">Регистрация</a>
          </div>
        <?php endif; ?>
      </div>
    </header>
  		<main class="main__login">
			<form action="login.php" accept-charset="utf-8" method="POST" id="form" class="form">
				<p>
					<p class="form__text">Введите логин или почту</p>
					<input type="login" value="<?php echo @$data['login']?>" name="login" class="login form__input" id="login">
				</p>
				<p>
					<p class="form__text">Введите пароль</p>
					<input type="password" value="<?php echo @$data['password']?>" name="password" class="password form__input" id="password">
				</p>
				<p>
					<div align="center" class="g-recaptcha-outer">
    					<div align="center" class="g-recaptcha-inner">
							<div align="center" data-theme="dark" class="g-recaptcha" data-sitekey="6Le0vVQUAAAAAJpm1XCpkGzjpvNMt62WcwcfRn4q" data-callback="YourOnSubmitFn"></div>
						</div>
					</div>
				</p>
				<p>
					<button type="submit" class="form__button" id="form__button" name="do_login">Войти</button>
				</p>
			</form>
  		</main>
	</div>
    <script src="/js/foundation.js"></script>
    <script src="/js/app.js"></script>
    <script>
	    function notificationClose() {
	      document.getElementById("notification_box").style="display: none";
	      document.getElementById("notification_background").style="display: none";
	    }
    </script>
  </body>
</html>