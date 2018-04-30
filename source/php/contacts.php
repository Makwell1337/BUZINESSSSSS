<?php
  require "db.php";
  $data = $_POST;
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
    <div class="wrapper">
        <section class="main_section">
          <div class="main">
          <div class="contacts_title">Связь с нами</div>
          <div class="container">
            <div class="mail_block">
              <form action="send.php" method="post" id="form" class="mail_form">
                  <input type="text" required name="ms_name" class="form_input contacts_input" placeholder="Имя">
                  <input type="text" required name="ms_mail" class="form_input contacts_input" placeholder="Почта">
                  <input type="text" required name="ms_about" class="form_input contacts_input" placeholder="Тема">
                  <input type="hidden" name="ms_userid" class="form_input contacts_input" value="<?php echo $_SESSION['logged_user']->id ?>">
                  <textarea type="text" required name="ms_message" class="form_textarea contacts_textarea" placeholder="Сообщение"></textarea>
                  <input type="submit" class="form_submit" value="Отправить">
              </form>
            </div>
            <ul class="constacts_list">
              <li class="contacts_item">
                  <a href="https://vk.com/public163917685" class="contacts_link"><img src="../img/vk.png" class="contacts_img">Вконтакте</a>
              </li>
              <li class="contacts_item">
                  <a href="mailto:stickslol@mail.ru" class="contacts_link"><img src="../img/mail.png" class="contacts_img">Почта</a>
              </li>
            </ul>
          </div>
          </div>
        </section>
    </div>
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
    <script src="/js/foundation.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>