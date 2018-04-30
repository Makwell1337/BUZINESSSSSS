<?php
	require "db.php";
	require "./libs/recaptcha.php";
	require "./config.php";
	$title = 'Ставки на киберспорт. CS:GO ставки. Букмекерская кантора.';

	function getRealIP()
		{

		   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
		   {
		      $client_ip =
		         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
		            $_SERVER['REMOTE_ADDR']
		            :
		            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
		               $_ENV['REMOTE_ADDR']
		               :
		               "unknown" );
		      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

		      reset($entries);
		      while (list(, $entry) = each($entries))
		      {
		         $entry = trim($entry);
		         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
		         {
		            $private_ip = array(
		                  '/^0\./',
		                  '/^127\.0\.0\.1/',
		                  '/^192\.168\..*/',
		                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
		                  '/^10\..*/');

		            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

		            if ($client_ip != $found_ip)
		            {
		               $client_ip = $found_ip;
		               break;
		            }
		         }
		      }
		   }
		   else
		   {
		      $client_ip =
		         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
		            $_SERVER['REMOTE_ADDR']
		            :
		            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
		               $_ENV['REMOTE_ADDR']
		               :
		               "unknown" );
		   }

		   return $client_ip;

		}

	$data = $_POST;
	if( isset($data['do_signup']) )
	{
		$secret = "6Le0vVQUAAAAAETQR3Dv5JsSZnjUJjse6JG3txnm";
		$response = $_POST['g-recaptcha-response'];
		$remoteip = $_SERVER['REMOTE_ADDR'];

		$result = json_decode($url, TRUE);
		$errors = array();

		if( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин!';
		}
		if( trim($data['email']) == '' )
		{
			$errors[] = 'Введите Email!';
		}
		if( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль!';
		}
		if( $data['password2'] != $data['password'] )
		{
			$errors[] = 'Пароли не совподают';
		}
		if( R::count('users', "login = ?", array($data['login'])) > 0 )
		{
			$errors[] = 'Пользователь с таким логином уже зарегистрирован';
		}
		if( R::count('users', "email = ?", array($data['email'])) > 0 )
		{
			$errors[] = 'Пользователь с такой почтой уже зарегистрирован';
		}
		if( $data['agreement'] == false )
		{
			$errors[] = 'Вы не подписали пользовательское соглашение';
		}
		if(empty($errors) )
		{
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
			$user->money = 0;
			$user->wonmoney = 0;
			$user->role = 'user';
			$user->agreement = 1;
			$user->ip = getRealIP();
			$user->img = "profile.png";
			mkdir("../img/profiles/".$data['login']."", 0700);
			copy( '../img/profiles/profile.png', '../img/profiles/'.$user->login.'/profile.png' );
			$user->chatban = 0;
			R::store($user);
			echo ('
		        <div id="notification_box" class="notification_box">
		            <div class="notification_title">Уведомление</div>
		            <div class="notification_text">Вы успешно зарегистрированы! Теперь можете <a class="auth_link" href="login.php">авторизоваться</a>.</div>
		            <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
		        </div>');
		} else 
		{
			echo '<div class="reg__errors">'.array_shift($errors).'</div>';

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
  		<main class="main__reg">
			<form action="reg.php" accept-charset="utf-8" method="POST" id="form" class="form">
				<p>
					<p class="form__text">Придумайте логин</p>
					<input type="text" name="login" length="255" class="login form__input" value="<?php echo @$data['login']?>" id="login">
				</p>
				<p>
					<p class="form__text">Ваш Email</p>
					<input type="email" value="<?php echo @$data['email']?>" name="email" length="255" class="email form__input" id="email">
				</p>
				<p>
					<p class="form__text">Придумайте пароль</p>
					<input type="password" value="<?php echo @$data['password']?>" name="password" length="255" class="password form__input" id="password">
				</p>
				<p>
					<p class="form__text">Повторите пароль</p>
					<input type="password" name="password2" length="255" class="password2 form__input" id="password2" value="<?php echo @$data['password2']?>">
				</p>
				<p>
					<div align="center" class="g-recaptcha-outer">
    					<div align="center" class="g-recaptcha-inner">
							<div align="center" data-theme="dark" class="g-recaptcha" data-sitekey="6Le0vVQUAAAAAJpm1XCpkGzjpvNMt62WcwcfRn4q" data-callback="YourOnSubmitFn"></div>
						</div>
					</div>
				</p>
				<p>
				    <a href="agreement.php" class="form_link">Пользовательское соглашение</a>
				    <div class="pretty p-default p-icon p-smooth p-round p-fill">
				        <input type="checkbox" name="agreement"/>
				        <div class="state p-info">
				            <label>Принять</label>
				        </div>
				    </div>
				</p>
				<p>
					<button type="submit"  class="form__button" id="form__button" name="do_signup">Зарегистрироваться</button>
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