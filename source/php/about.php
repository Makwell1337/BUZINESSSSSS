<?php
      require "./db.php";
      $title = 'Ставки на киберспорт. CS:GO ставки. Букмекерская кантора.';
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
    <title><?php echo($title) ?></title>
  </head>
  <body>
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
    <section class="main_section about_section">
      <p class="about_title">Коротко и ясно о нас</p>
      <p class="about_text">Мы - это команда, создавшая сайт со ставками на киберспорт. Прелесть сайта это то что, честность его главная составляющая, мы не подкручиваем, не обманываем, берём информацию о командах только с сайта <a class="about_link" href="https://www.hltv.org/">HLTV</a>.</p>
    </section>
    <footer class="footer">
      <div class="footer_description">
        <div class="footer_description_text">Сайт по ставкам на киберспорт, домен защищён. Пользовательские права защищены. По любым вопросам, писать на почту или в вк. Удачных ставок, с уважением, HardBet.</div>
        <a href="agreement.php" class="footer_agreement">Пользовательское соглашение</a>
      </div>
      <div class="footer_soc">
        <ul class="footer_soc-list">
          <li class="footer_soc-item">
            <a href="https://vk.com/public163917685" class="footer_soc-link">Вконтакте</a>
          </li>
          <li class="footer_soc-item">
            <a href="mailto:stickslol@mail.ru" class="footer_soc-link">Почта</a>
          </li>
        </ul>
      </div>
    </footer>
    <script src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script src="../js/foundation.js"></script>
    <script src="../js/app.js"></script>
    <script src="http://cdn.jsdelivr.net/emojione/1.3.0/lib/js/emojione.min.js"></script>
    <script src="../assets/js/script.js"></script>
  </body>
</html>