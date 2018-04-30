<?php
  require "db.php";
  $data = $_POST;
  $title = 'Ставки на киберспорт. CS:GO ставки. Букмекерская кантора.';

  if( isset($data['do_edit-email']) )
  {

    $errors = array();
    if( trim($data['edit__email']) == '' )
    {
      $errors[] = 'Введите Email!';
    }
    if( R::count('users', "email = ?", array($data['edit__email'])) > 0 )
    {
      $errors[] = 'Пользователь с такой почтой уже зарегистрирован';
    }

    if( empty($errors) )
    {
      $user = R::load('users', $_SESSION['logged_user']->id);
      $user->email = $data['edit__email'];
      R::store($user);
      echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно изменили почту!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
    } else 
    {
      echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Ошибка! '.array_shift($errors).'</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
    }

  }
  if( isset($data['do_edit-password']) )
  {

    $errors = array();
    if( $data['edit__password'] == '' )
    {
      $errors[] = 'Введите пароль!';
    }
    if( empty($errors) )
    {
      $user = R::load('users', $_SESSION['logged_user']->id);
      $user->password = password_hash($data['edit__password'], PASSWORD_DEFAULT);
      R::store($user);
      echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно изменили пароль!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
      $user = $user->fresh();
    } else 
    {
      echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Ошибка! '.array_shift($errors).'</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
    }
  }

  if( isset($data['do_edit-img']) )
  {

    $errors = array();
    if( empty($errors) )
    {
      foreach (glob('../img/profiles/'.$_SESSION['logged_user']->login.'/*') as $file)
      {
        unlink($file);
      }
      $path = "../img/profiles/".$_SESSION['logged_user']->login."/";
      $path = $path . basename( $_FILES['edit_img']['name']);
      if(move_uploaded_file($_FILES['edit_img']['tmp_name'], $path)) {
        $user = R::load('users', $_SESSION['logged_user']->id);
        $user->img = basename( $_FILES['edit_img']['name']);
        R::store($user);
        echo ('
              <div id="notification_box" class="notification_box">
                  <div class="notification_title">Уведомление</div>
                  <div class="notification_text">Вы успешно изменили фото!</div>
                  <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
              </div>');
        $user = $user->fresh();
      } else{
          echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Ошибка! Фото не выбрано!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
      }
    } else 
    {
      echo ('
            <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Ошибка! '.array_shift($errors).'</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
            </div>');
    }
  }

  if( isset($data['cleanbets']) )
  {
    $cleanwonbets = R::findLike('playedbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
    foreach( $cleanwonbets as $cleanwonbets )
    {
      R::trash($cleanwonbets);
    }
    $cleanbets = R::findLike('bets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
    foreach( $cleanbets as $cleanbets )
    {
      $i = $cleanbets->win;
      while($i > 1)
      {
        $i -= 2;
        R::trash($cleanbets);
      }
    }
    $cleanwonbets = R::findLike('lcplayedbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
    foreach( $cleanwonbets as $cleanwonbets )
    {
      R::trash($cleanwonbets);
    }
    $cleanbets = R::findLike('lcbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
    foreach( $cleanbets as $cleanbets )
    {
      $i = $cleanbets->win;
      while($i > 1)
      {
        $i -= 2;
        R::trash($cleanbets);
      }
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
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
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
            <div class="header_profile">
            <a href="logout.php" class="header_profile-link">Выход</a>
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
    <?php if( "true" == "true" ) : ?>
    <div class="wrapper">
      <main class="client__main">
        <nav class="client_menu">
          <ul class="menu_list">
            <li class="menu_item">
              <a href="#" onclick="turnSectionOne();" id="menu_linkone" class="menu_link bold">Данные</a>
            </li>
            <li class="menu_item">
              <a href="#" onclick="turnSectionTwo();" id="menu_linktwo" class="menu_link">Ставки</a>
            </li>
            <div id="client_info" class="client_info">Важная информация: T: Команда, P: Половина матча, R: Раунд.</div>
          </ul>
        </nav>
        <section id="sectionone" class="client__section">
          <div class="settings">
          <form action="client.php" accept-charset="utf-8" method="POST" class="client__editor email__editor">
            <div class="editor">
              <div class="email__edit">
                <input type="text" class="email__edit-input edit__input" name="edit__email" value="<?php
                $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                  foreach( $users as $user )
                  {
                    echo $user->email;
                  }
                 ?>">
              </div>
              <button class="client__editor-confirm edit__button" type="submit" id="client__submit" name="do_edit-email">Изменить почту</button>
            </div>
            <div class="user__id">
              <input type="text" name="user__id-email edit__input" value="<?php echo $_SESSION['logged_user']->id ?>">
            </div>
          </form>
          <form action="client.php" accept-charset="utf-8" method="POST" class="client__editor password__editor">
            <div class="editor">
              <div class="password__edit">
                <div class="password__edit">
                  <input type="text" class="password__edit-input edit__input" name="edit__password" value="Введите пароль">
                </div>
              </div>
              <button class="client__editor-confirm edit__button" type="submit" id="client__submit" name="do_edit-password">Изменить пароль</button>
            </div>
            <p><input type="hidden" name="id" value="<?php echo $_SESSION['logged_user']->id ?>"></p>
          </form>
          <form action="client.php" enctype="multipart/form-data" accept-charset="utf-8" method="POST" class="client__editor password__editor">
            <div class="editor">
              <div class="password__edit">
                <div class="password__edit">
                  <input type="file" class="password__edit-input edit__input" name="edit_img" value="Введите пароль">
                </div>
              </div>
              <button class="client__editor-confirm edit__button" type="submit" id="client__submit" name="do_edit-img">Изменить фото</button>
            </div>
            <p><input type="hidden" name="id" value="<?php echo $_SESSION['logged_user']->id ?>"></p>
          </form>
          </div>
          <div class="kassas">
          <div class="kassa">
            <div class="kassa_title">Пополнение счёта</div>
            <div class="kassa_text">Пополнить кошельком Payeer</div>
            <a href="payeer/100.php" class="payeer_link payeer_input">Пополнить(100 рублей)</a>
            <a href="payeer/300.php" class="payeer_link payeer_input">Пополнить(300 рублей)</a>
            <a href="payeer/500.php" class="payeer_link payeer_input">Пополнить(500 рублей)</a>
            <a href="payeer/1000.php" class="payeer_link payeer_input">Пополнить(1000 рублей)</a>
            <a href="payeer/5000.php" class="payeer_link payeer_input">Пополнить(5000 рублей)</a>
          <div class="kassa_text">Пополнить всеми остальными кошельками</div>
          <form name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
            <input type="hidden" name="ik_co_id" value="5a3a8b803c1eaf90288b456e">
            <input type="hidden" name="ik_pm_no" value="<?=time()?>">
            <p><input type="text" class="edit__input" name="ik_am" placeholder="Сумма"></p>
            <p><input type="hidden" name="ik_x_login" value="<?php echo $_SESSION['logged_user']->id ?>"></p>
            <input type="hidden" name="ik_cur" value="RUB">
            <input type="hidden" name="ik_desc" value="Пополнение счёта">
            <p><input type="submit" class="payeer_input" value="Пополнить"></p>
          </form>
          </div>
          <div class="kassa">
            <div class="kassa_title">Вывод денег</div>
            <div class="kassa_text">Вывод денег на кошелёк Payeer</div>
            <form action="payeer.php" method="post">
              <p><input type="text" class="edit__input" name="sum" placeholder="Сумма"></p>
              <p><input type="text" class="edit__input" name="wallet" placeholder="Номер кошелька Payeer"></p>
              <p><input type="submit" class="payeer_input" name="enter" value="Снять"></p>
            </form>
            <div class="kassa_text">Вывод денег на все остальные кошельки</div>
            <form action="withdraw.php" method="post">
              <p><input type="text" class="edit__input" name="w_sum" placeholder="Сумма"></p>
              <p><input type="text" class="edit__input" name="w_wallet" placeholder="Номер кошелька"></p>
              <p><input type="submit" class="payeer_input" name="withdraw" value="Снять"></p>
            </form>
          </div>
          </div>
        </section>
        <section id="sectiontwo" class="client__bets-section">
          <form accept-charset="utf-8" method="POST">
            <button type="submit" name="cleanbets" class="clean_button">Очистить список ставок</button>
          </form>
          <a href="#" class="show_link" onclick="showBets();" id="show_bets">Обычные ставки</a>
          <a href="#" class="show_link" onclick="showLCBets();" id="show_lcbets">Доп. Ставки</a>
          <div class="client_bets" id="bets_block">
            <?php
              $betsinfo = R::findLike('bets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` DESC');
              foreach( $betsinfo as $betsinfo )
              {
                $m = R::find('matches', "id = ?", array($betsinfo->matchid));
                foreach( $m as $m )
                {
                  if( $betsinfo->win == "0" )
                  {
                    echo('<div class="betinfo_bet"><div class="betinfo_team">Команда N1: '.$m->team1.'</div><div class="betinfo_vs">VS</div><div class="betinfo_team">Команда N2: '.$m->team2.' </div> <div class="betinfo_team betinfo_teambet"> Команда: '.$betsinfo->team.'</div><div class="betinfo_coef">Коэф: '.$betsinfo->coef.'</div><div class="betinfo_money">Деньги: '.$betsinfo->money.' рублей</div><div class="betinfo_money">Возможный выигрыш: '.$betsinfo->money*$betsinfo->coef.' рублей</div><div class="betinfo_status-grey">Статус: Не сыгран</div><div class="betinfo_money">Дата: '.$betsinfo->date.'</div></div>');
                  }
                }
              }
              $wonbetsinfo = R::findLike('playedbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` DESC');
              foreach( $wonbetsinfo as $wonbetsinfo )
              {
                echo('<div class="betinfo_bet"><div class="betinfo_team">Команда N1: '.$wonbetsinfo->team1.'</div><div class="betinfo_vs">VS</div><div class="betinfo_team">Команда N2: '.$wonbetsinfo->team2.' </div> <div class="betinfo_team betinfo_teambet"> Команда: '.$wonbetsinfo->team.'</div><div class="betinfo_coef">Коэф: '.$wonbetsinfo->coef.'</div><div class="betinfo_money">Деньги: '.$wonbetsinfo->money.' рублей</div><div class="betinfo_money">Возможный выигрыш: '.$wonbetsinfo->winmoney.' рублей</div><div id="status" style="color: '.$wonbetsinfo->color.'" class="betinfo_status-green">Статус: '.$wonbetsinfo->status.'</div><div class="betinfo_money">Дата: '.$wonbetsinfo->date.'</div></div>');
              }
            ?>
          </div>
          <div class="client_bets" id="lcbets_block">
            <?php
              $lcbetsinfo = R::findLike('lcbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` DESC');
              foreach( $lcbetsinfo as $betsinfo )
              {
                $m = R::find('matches', "id = ?", array($betsinfo->matchid));
                foreach( $m as $m )
                {
                  if( $betsinfo->win == "0" )
                  {
                    echo('<div class="betinfo_bet"><div class="betinfo_team">Команда N1: '.$m->team1.'</div><div class="betinfo_vs">VS</div><div class="betinfo_team">Команда N2: '.$m->team2.' </div> <div class="betinfo_team betinfo_teambet"> Команда: '.$betsinfo->team.'</div><div class="betinfo_coef">Коэф: '.$betsinfo->coef.'</div><div class="betinfo_money">Деньги: '.$betsinfo->money.' рублей</div><div class="betinfo_money">Возможный выигрыш: '.$betsinfo->money*$betsinfo->coef.' рублей</div><div class="betinfo_status-grey">Статус: Не сыгран</div><div class="betinfo_money">Дата: '.$betsinfo->date.'</div><div class="betinfo_money">Тип: '.$betsinfo->kind.'</div></div>');
                  }
                }
              }
              $lcwonbetsinfo = R::findLike('lcplayedbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` DESC');
              foreach( $lcwonbetsinfo as $wonbetsinfo )
              {
                echo('<div class="betinfo_bet"><div class="betinfo_team">Команда N1: '.$wonbetsinfo->team1.'</div><div class="betinfo_vs">VS</div><div class="betinfo_team">Команда N2: '.$wonbetsinfo->team2.' </div> <div class="betinfo_team betinfo_teambet"> Команда: '.$wonbetsinfo->team.'</div><div class="betinfo_coef">Коэф: '.$wonbetsinfo->coef.'</div><div class="betinfo_money">Деньги: '.$wonbetsinfo->money.' рублей</div><div class="betinfo_money">Возможный выигрыш: '.$wonbetsinfo->winmoney.' рублей</div><div id="status" style="color: '.$wonbetsinfo->color.'" class="betinfo_status-green">Статус: '.$wonbetsinfo->status.'</div><div class="betinfo_money">Дата: '.$wonbetsinfo->date.'</div><div class="betinfo_money">Тип: '.$wonbetsinfo->kind.'</div></div>');
              }
            ?>
          </div>
        </section>
      </main>
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
    <script>

    function showLCBets() {
      document.getElementById("bets_block").style="display: none";
      document.getElementById("lcbets_block").style="display: block";
    }

    function showBets() {
      document.getElementById("bets_block").style="display: block";
      document.getElementById("lcbets_block").style="display: none";
    }

    function notificationClose() {
      document.getElementById("notification_box").style="display: none";
      document.getElementById("notification_background").style="display: none";
    }

    function turnSectionOne(){
      document.getElementById("sectionone").style="display: block";
      document.getElementById("sectiontwo").style="display: none";
      document.getElementById("menu_linkone").classList.add("bold");
      document.getElementById("menu_linktwo").classList.remove("bold");
    }
    function turnSectionTwo(){
      document.getElementById("sectionone").style="display: none";
      document.getElementById("sectiontwo").style="display: block";
      document.getElementById("menu_linkone").classList.remove("bold");
      document.getElementById("menu_linktwo").classList.add("bold");
    }
  </script>
    <?php else : ?>
    <?php endif; ?>
  </body>
</html>