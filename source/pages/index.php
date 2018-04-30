<?php
      require "./php/db.php";
      $data = $_POST;
      $title = 'Ставки на киберспорт. CS:GO ставки. Букмекерская кантора.';

      $mw = R::findAll('matches',"ORDER BY `id` DESC");
      foreach( $mw as $mw )
      {
        if( $mw->winteam1 == "1" )
        {
          $mwc = R::load('matches', $mw->id);
          $mwc->status1 = "WON";
          $mwc->status2 = "LOST";
          R::store($mwc);
          $mwc = $mwc->fresh();
        }
        if( $mw->winteam2 == "1" )
        {
          $mwc = R::load('matches', $mw->id);
          $mwc->status1 = "LOST";
          $mwc->status2 = "WON";
          R::store($mwc);
          $mwc = $mwc->fresh();
        }
        if( $mw->winteam1 == "0" && $mw->winteam2 == "0" )
        {
          $mwc = R::load('matches', $mw->id);
          $mwc->status1 = "";
          $mwc->status2 = "";
          R::store($mwc);
          $mwc = $mwc->fresh();
        }
      }
      
      $ms = R::findAll('matches',"ORDER BY `id` DESC");
      foreach( $ms as $ms )
      {
        $i = $ms->winteam1;
        while( $i > 0 )
        {
          $i -= 1;
          $bet = R::find('bets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k < 2 )
            {
              $k += 2;
              $betwin = R::load('bets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
        $b = $ms->winteam2;
        while( $b > 0 )
        {
          $b -= 1;
          $bet = R::find('bets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k > 1 )
            {
              $k -= 2;
              $betwin = R::load('bets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
      }
      // P1R1
      $mlc = R::findAll('matches',"ORDER BY `id` DESC");
      foreach( $mlc as $ms )
      {
        $i = $ms->winteam1p1r1;
        while( $i > 0 )
        {
          $i -= 1;
          $bet = R::find('lcbets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k < 2 )
            {
              $k += 2;
              $betwin = R::load('lcbets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
        $b = $ms->winteam2p1r1;
        while( $b > 0 )
        {
          $b -= 1;
          $bet = R::find('lcbets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k > 1 )
            {
              $k -= 2;
              $betwin = R::load('lcbets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
      }
      // P2R1
      $smlc = R::findAll('matches',"ORDER BY `id` DESC");
      foreach( $smlc as $ms )
      {
        $i = $ms->winteam1p2r1;
        while( $i > 0 )
        {
          $i -= 1;
          $bet = R::find('lcbets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k < 2 )
            {
              $k += 2;
              $betwin = R::load('lcbets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
        $b = $ms->winteam2p2r1;
        while( $b > 0 )
        {
          $b -= 1;
          $bet = R::find('lcbets', "matchid = ?", array($ms->id));
          foreach( $bet as $bet )
          {
            $k = $bet->teamid;
            while( $k > 1 )
            {
              $k -= 2;
              $betwin = R::load('lcbets', $bet->id);
              $betwin->win = 1;
              R::store($betwin);
              $betwin = $betwin->fresh();
            }
          }
        }
      }
      
      $bets = R::find('bets',"win = ?", array(1));
      foreach( $bets as $bets )
      {
        $i = $bets->win;
        while( $i > 0 )
        {
          $i -= 1;
          $user = R::load('users', $bets->userid);
          $user->money = $user->money + ($bets->money * $bets->coef);
          $user->wonmoney = $user->wonmoney + ($bets->money * $bets->coef);
          R::store($user);
          $user = $user->fresh();
          $m = R::find('matches',"id = ?", array($bets->matchid));
          foreach( $m as $m ) 
            { 
              $playedbets = R::dispense('playedbets'); 
              $playedbets->team1 = $m->team1; 
              $playedbets->team2 = $m->team2; 
              $playedbets->coef = $bets->coef; 
              $playedbets->win = 1; 
              $playedbets->money = $bets->money; 
              $playedbets->winmoney = $bets->money * $bets->coef;
              $playedbets->userid = $bets->userid;
              $playedbets->date = $bets->date; 
              $playedbets->team = $bets->team; 
              $playedbets->status = "Победа";
              $playedbets->color = "green";
              R::store($playedbets); 
            }
        }
        R::trash($bets);
      }

      $lcbets = R::find('lcbets',"win = ?", array(1));
      foreach( $lcbets as $bets )
      {
        $i = $bets->win;
        while( $i > 0 )
        {
          $i -= 1;
          $user = R::load('users', $bets->userid);
          $user->money = $user->money + ($bets->money * $bets->coef);
          $user->wonmoney = $user->wonmoney + ($bets->money * $bets->coef);
          R::store($user);
          $user = $user->fresh();
          $m = R::find('matches',"id = ?", array($bets->matchid));
          foreach( $m as $m ) 
            { 
              $playedbets = R::dispense('lcplayedbets'); 
              $playedbets->team1 = $m->team1; 
              $playedbets->team2 = $m->team2; 
              $playedbets->coef = $bets->coef; 
              $playedbets->win = 1; 
              $playedbets->money = $bets->money; 
              $playedbets->winmoney = $bets->money * $bets->coef;
              $playedbets->userid = $bets->userid;
              $playedbets->date = $bets->date; 
              $playedbets->kind = $bets->kind;
              $playedbets->matchid = $m->id;
              $playedbets->team = $bets->team; 
              $playedbets->status = "Победа";
              $playedbets->color = "green";
              R::store($playedbets); 
            }
        }
        R::trash($bets);
      }

      $betscheck = R::findLike('bets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
      foreach( $betscheck as $betscheck )
      {
        $matchescheck = R::findLike('matches', array(
                'id' => array($betscheck->matchid)
              ), 'ORDER BY `id` ASC');
        foreach( $matchescheck as $matchescheck )
        {
          if( $matchescheck->winteam1 == "1" && $betscheck->teamid = $matchescheck->teamid2)
          {
            $bet = R::load('bets', $betscheck->id);
            $bet->win = 2;
            R::store($bet);
            $bet = $bet->fresh();
            $playedbets = R::dispense('playedbets'); 
            $playedbets->team1 = $matchescheck->team1; 
            $playedbets->team2 = $matchescheck->team2; 
            $playedbets->coef = $betscheck->coef; 
            $playedbets->win = 2; 
            $playedbets->money = $betscheck->money; 
            $playedbets->winmoney = $betscheck->money * $betscheck->coef;
            $playedbets->userid = $betscheck->userid;
            $playedbets->date = $betscheck->date;
            $playedbets->matchid = $matchescheck->id;
            $playedbets->team = $betscheck->team; 
            $playedbets->color = "red";
            $playedbets->status = "Поражение";
            R::store($playedbets);
            R::trash($betscheck);
          }
          if( $matchescheck->winteam2 == "1" && $betscheck->teamid = $matchescheck->teamid1)
          {
            $bet = R::load('bets', $betscheck->id);
            $bet->win = 2;
            R::store($bet);
            $bet = $bet->fresh();
            $playedbets = R::dispense('playedbets'); 
            $playedbets->team1 = $matchescheck->team1; 
            $playedbets->team2 = $matchescheck->team2; 
            $playedbets->coef = $betscheck->coef; 
            $playedbets->win = 2; 
            $playedbets->money = $betscheck->money; 
            $playedbets->winmoney = $betscheck->money * $betscheck->coef;
            $playedbets->userid = $betscheck->userid;
            $playedbets->date = $betscheck->date;
            $playedbets->matchid = $matchescheck->id;
            $playedbets->team = $betscheck->team; 
            $playedbets->color = "red";
            $playedbets->status = "Поражение";
            R::store($playedbets);
            R::trash($betscheck);
          }
        }
      }

      $lcbetscheck = R::findLike('lcbets', array(
                'userid' => array($_SESSION['logged_user']->id)
              ), 'ORDER BY `id` ASC');
      foreach( $lcbetscheck as $betscheck )
      {
        $matchescheck = R::findLike('matches', array(
                'id' => array($betscheck->matchid)
              ), 'ORDER BY `id` ASC');
        foreach( $matchescheck as $matchescheck )
        {
          if( $matchescheck->winteam1p1r1 == "1" && $betscheck->teamid = $matchescheck->teamid1)
          {
            $bet = R::load('lcbets', $betscheck->id);
            $bet->win = 2;
            R::store($bet);
            $bet = $bet->fresh();
            $playedbets = R::dispense('lcplayedbets'); 
            $playedbets->team1 = $matchescheck->team1; 
            $playedbets->team2 = $matchescheck->team2; 
            $playedbets->coef = $betscheck->coef; 
            $playedbets->win = 2; 
            $playedbets->money = $betscheck->money; 
            $playedbets->winmoney = $betscheck->money * $betscheck->coef;
            $playedbets->userid = $betscheck->userid;
            $playedbets->date = $betscheck->date;
            $playedbets->kind = $betscheck->kind; 
            $playedbets->matchid = $matchescheck->id; 
            $playedbets->team = $betscheck->team; 
            $playedbets->color = "red";
            $playedbets->status = "Поражение";
            R::store($playedbets);
            R::trash($betscheck);
          }
          if( $matchescheck->winteam2 == "1" && $betscheck->teamid = $matchescheck->teamid1)
          {
            $bet = R::load('lcbets', $betscheck->id);
            $bet->win = 2;
            R::store($bet);
            $bet = $bet->fresh();
            $playedbets = R::dispense('lcplayedbets'); 
            $playedbets->team1 = $matchescheck->team1; 
            $playedbets->team2 = $matchescheck->team2; 
            $playedbets->coef = $betscheck->coef; 
            $playedbets->win = 2; 
            $playedbets->money = $betscheck->money; 
            $playedbets->winmoney = $betscheck->money * $betscheck->coef;
            $playedbets->userid = $betscheck->userid;
            $playedbets->date = $betscheck->date;
            $playedbets->kind = $betscheck->kind; 
            $playedbets->matchid = $matchescheck->id; 
            $playedbets->team = $betscheck->team; 
            $playedbets->color = "red";
            $playedbets->status = "Поражение";
            R::store($playedbets);
            R::trash($betscheck);
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
    <link href="style/app.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="style/foundation.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
<!--Подключаем Jquery!-->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  //Загружаем библиотеку JQuery
  google.load("jquery", "1.3.2");
  google.load("jqueryui", "1.7.2");
  window.addEventListener("keydown", checkKeyPress, false);
  //Функция отправки сообщения
  function send()
  {
    //Считываем сообщение из поля ввода с id mess_to_add
    var mess=$("#mess_to_send2").val();
    // Отсылаем паметры
       $.ajax({
                type: "POST",
                url: "./php/add_mess.php",
                data:"mess="+mess,
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Если все успешно, загружаем сообщения
          load_messes();
          //Очищаем форму ввода сообщения
          $("#mess_to_send2").val('');
                }
        });
  }
  function send2()
  {
    //Считываем сообщение из поля ввода с id mess_to_add
    var mess=$("#mess_to_send").val();
    // Отсылаем паметры
       $.ajax({
                type: "POST",
                url: "./php/add_mess.php",
                data:"mess="+mess,
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Если все успешно, загружаем сообщения
          load_messes();
          load_messes2();
          //Очищаем форму ввода сообщения
          $("#mess_to_send").val('');
                }
        });
  }
  function unchatban()
  {
    //Считываем сообщение из поля ввода с id mess_to_add
    var unchatban='123';
    // Отсылаем паметры
       $.ajax({
                type: "POST",
                url: "./php/unchatban.php",
                data:"unchatban="+unchatban,
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Если все успешно, загружаем сообщения
          load_messes();
          //Очищаем форму ввода сообщения
                }
        });
  }
  function load_messes()
  {
    $.ajax({
                type: "POST",
                url:  "./php/load_messes.php",
                data: "req=ok",
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Очищаем форму ввода
          $("#messages").empty();
          //Выводим что вернул нам php
          $("#messages").append(html);
          //Прокручиваем блок вниз(если сообщений много)
          $("#messages").scrollTop(0);
                }
        });
  }
  function load_messes2()
  {
    $.ajax({
                type: "POST",
                url:  "./php/load_messes.php",
                data: "req=ok",
                // Выводим то что вернул PHP
                success: function(html)
        {
          //Очищаем форму ввода
          $("#messages2").empty();
          //Выводим что вернул нам php
          $("#messages2").append(html);
          //Прокручиваем блок вниз(если сообщений много)
          $("#messages2").scrollTop(0);
                }
        });

  }

</script>
    <title><?php echo($title) ?></title>
    <!--[if it IE 8]>
    <p class="browserhappy">
      Ваш браузер <strong>устарел</strong>. Пожалуйста <a href="http://browsehappy.com/"обновите</a> браузер.
    </p>
  <![endif]-->
  </head>
  <body>
    <header class="header">
      <div class="header_left">
        <a href="index.php" class="header_title">ICE.BET</a>
        <a href="./php/about.php" class="header_text">О нас</a>
        <a href="./php/contacts.php" class="header_text">Связь</a>
      </div>
      <div class="header_right">
        <?php if( isset($_SESSION['logged_user']) ) : ?>
          <div class="header_profile">
            <a href="php/client.php" class="header_profile-link"><img src="img/profile.png" class="header_profile-img">Профиль</a>
            <div class="header_balance"> <strong>
              <?php
                $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                foreach( $users as $user )
                {
                  echo $user->money;
                }
              ?>
              </strong><img src="img/ices.svg" class="header_balance-img">
            </div>
          </div>
        <?php else : ?>
          <div class="header_profile">
            <a href="php/login.php" class="header_profile-link">Вход</a>
            <a href="php/reg.php" class="header_profile-link circle">Регистрация</a>
          </div>
        <?php endif; ?>
      </div>
    </header>
    <main>
      <?php
        if( isset($data['bet']) && isset($_SESSION['logged_user']) )
        {
          $matchbet = R::find('matches'," id = ? ", array($_POST['matchid']) );
          foreach( $matchbet as $matchbet )
          {
            echo ('<div id="match_bet" class="match_bet">'
              .'<div class="match_bet-title">Информация о матче</div>'.'<a onClick="matchBetClose()" class="match_bet-exit">→'.'</a>'.
              '<form method="POST">'.
              '<button class="match_bet-teamone" name="betOnTeamOne" type="submit">'.
              '<div class="match_bet-team1"><input class="input_absolute" name="coef1" type="hidden" value="'.$matchbet->coef1.'"><input class="input_absolute" name="team1" type="hidden" value="'.$matchbet->team1.'"><input class="input_absolute" name="teamid1" type="hidden" value="'.$matchbet->teamid1.'"><input class="input_absolute" name="date" type="hidden" value="'.$matchbet->date.'">'.$matchbet->team1.'</div>'.'<div class="match_bet-coef1">Коэф. '.$matchbet->coef1.'</div>'.'</button>'.
              '<div class="match_bet-vs">VS</div>'.
              '<button class="match_bet-teamtwo" name="betOnTeamTwo" type="submit">'
              .'<div class="match_bet-team2"><input class="input_absolute" name="coef2" type="hidden" value="'.$matchbet->coef2.'"><input class="input_absolute" name="team2" type="hidden" value="'.$matchbet->team2.'"><input class="input_absolute" name="teamid2" type="hidden" value="'.$matchbet->teamid2.'"><input class="input_absolute" name="matchidtobet" type="hidden" value="'.$_POST['matchid'].'">'.$matchbet->team2.'</div>'.'<div class="match_bet-coef2">Коэф. '.$matchbet->coef2.'</div>'.'</button>'.'<button class="match_bet-teamone bet_kind" name="betOnTeamOneWin1P1R" type="submit">Победа '.$matchbet->team1.' в 1-ой половине в 1-ом раунде<div class="match_bet-coef1">Коэф: '.$matchbet->lccoef1.'</div></button>'.'<button class="match_bet-teamone bet_kind" name="betOnTeamOneWin2P1R" type="submit">Победа '.$matchbet->team1.' в 2-ой половине в 1-ом раунде<div class="match_bet-coef1">Коэф: '.$matchbet->lccoef2.'</div></button>'.'<button class="match_bet-teamone bet_kind" name="betOnTeamTwoWin1P1R" type="submit">Победа '.$matchbet->team2.' в 1-ой половине в 1-ом раунде<div class="match_bet-coef1">Коэф: '.$matchbet->lccoef3.'</div></button>'.'<button class="match_bet-teamone bet_kind" name="betOnTeamTwoWin2P1R"type="submit">Победа '.$matchbet->team2.' в 2-ой половине в 1-ом раунде<div class="match_bet-coef1">Коэф: '.$matchbet->lccoef4.'</div></button>'.'<p><p class="match_bet-money__sum">Сумма</p><input id="money" name="money" type="text" class="match_bet-money"></p>'.'<input class="input_absolute" name="lccoef1" type="hidden" value="'.$matchbet->lccoef1.'"><input class="input_absolute" name="lccoef2" type="hidden" value="'.$matchbet->lccoef2.'"><input class="input_absolute" name="lccoef3" type="hidden" value="'.$matchbet->lccoef3.'"><input class="input_absolute" name="lccoef4" type="hidden" value="'.$matchbet->lccoef4.'"></form>'.
              '<div class="match_bet-liga">Лига: '.$matchbet->liga.'</div>'.
              '<div class="match_bet-date">Дата игры: '.$matchbet->date.'</div>'.'<div class="match_bet-date">'.$matchbet->BO.'</div>'.
              '</div>');
          }
        } else if( isset($data['bet']) && !isset($_SESSION['logged_user']) )
        {
          echo ('<div id="notification_background" class="notification_background"></div>
        <div id="notification_box" class="notification_box">
          <div class="notification_title">Уведомление</div>
          <div class="notification_text">Вы не авторизованы!</div>
          <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
        </div>');
        }
      ?>
        <div class="main_twitch">
          <div class="all">
            <div class="channels">
              <div class="channels_title">Каналы<img class="channels_img" src="img/live.svg"></div>
              <ul class="channels_list">
                <li class="channels_item">
                  <a href="#" class="channels_link" onClick="channelSwitch1()" id="channeldisplayname1">
                    
                  </a>
                  <div id="channelstatus1"></div>
                  <div id="channelname1">Starladder5</div>
                </li>
                <li class="channels_item">
                  <a href="#" onClick="channelSwitch2()" class="channels_link" id="channeldisplayname2">
                    
                  </a>
                  <div id="channelstatus2"></div>
                  <div id="channelname2">ESL_CSGO</div>
                </li>
                <li class="channels_item">
                  <a href="#" class="channels_link" onClick="channelSwitch3()" id="channeldisplayname3">
                    
                  </a>
                  <div id="channelstatus3"></div>
                  <div id="channelname3">UCCleague</div>
                </li>
              </ul>
            </div>
            <ul id="slider1" class="streams_list slider">
              <div class="streams_title">Трансляции</div>
              <li id="slide1" class="streams_item slide slide1"><iframe class="stream" src="https://player.twitch.tv/?channel=starladder5&autoplay=false" frameborder="0" allowfullscreen="true" scrolling="no" height="400px" width="600px"></iframe></li>
              <li id="slide2" class="streams_item slide slide2"><iframe class="stream" src="https://player.twitch.tv/?channel=esl_csgo&autoplay=false" frameborder="0" allowfullscreen="true" scrolling="no" height="400px" width="600px"></iframe></li>
              <li id="slide3" class="streams_item slide slide3"><iframe class="stream" src="https://player.twitch.tv/?channel=uccleague&autoplay=false" frameborder="0" allowfullscreen="true" scrolling="no" height="400px" width="600px"></iframe></li>
            </ul>
        </div>
        </div>
        <section class="main_section">
          <div class="games_block">
            <a href="index.php" class="bet_title"><img class="bet_img" src="img/csgo.png"><p class="bet_title-link">CS:GO</p></a>
            <a href="pubg-index.php" class="bet_title bet_title-last"><img class="bet_img" src="img/pubg.png"><p class="bet_title-link">PUBG</p></a>
          </div>
          <div class="upcoming_text upcoming_text2"><img src="img/playing.svg" class="upcoming_img upcoming_img-blue">Матчи онлайн</div>
          <div class="chat_block">
              <div class="upcoming_text" style="margin-left: 10px;"><img src="img/chat.svg" class="upcoming_img">Чат</div>
              <div class="chat_text">
                Напишите сообщение:
                <form action="javascript:send();" method="POST" class="chat_form">
                  <input name="c_message2" maxlength="256" id="mess_to_send2" class="chat_input">
                  <button type="submit" class="form__button chat_button" id="form__button" name="do_message">Отправить</button>
                </form>
              </div>
              <table>
              <tr>
              <td>
              <div id="messages">
              </div>
              </td>
              </tr>
              <tr>
              <td>
              </td>
              </tr>
              </table>
            </div>
            <?php if( $_SESSION['logged_user']->role == "admin" ) : ?>
            <div class="unchatban_block">
              <form action="javascript:unchatban()" method="POST" class="chat_form">
                  <button type="submit" class="form__button chat_button" id="form__button" name="do_unchatban">unchatban</button>
                </form>
            </div>
            <?php else : ?>
            <?php endif; ?>
            <?php
            $matches = R::findCollection('matches',"ORDER BY `id` ASC");
            while( $match = $matches->next() )
            {
              if( $match->allow == "deny" && $match->winteam1 == "0" && $match->winteam2 == "0")
              {
                echo ('<a class="bet_match bet_match2">'.'<form method="POST">'
                .'<div class="bet_team1">'.
                '<img class="bet_icon bet_icon1" src="'.$match->photosrc1.'">'.'
                <div class="bet_team bet_team11">'.$match->team1.'</div>
                <div class="bet_coef bet_coef1">'.$match->coef1.'X</div>'.'<div class="team_status">'.$match->status1.'</div>'.'</div>'.'<div class="bet_team2">'.
                '<img class="bet_icon" src="'.$match->photosrc2.'">'.'
                <div class="bet_team">'.$match->team2.'</div>
                <div class="bet_coef2 bet_coef">'.$match->coef2.'X</div>'.'<div class="team_status">'.$match->status2.'</div>'.'</div>'.'<div class="bet_info">'.'<div class="bet_vs">'.$match->BO.'</div>'.'<div class="bet_date">'.$match->date.'</div>'.'<div class="bet_liga">'.$match->liga.'</div>'.'<input name="matchid" type="hidden" value="'.$match->id.'">'.'<div class="bet_deny" style="margin-top: 5px;"> Матч уже начался, ставка не возможна'.'</div>'.'
                </div>'.'</form>'.'</a>');
              }
              }

            ?>
            <?php
              if( isset($data['betOnTeamOne']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('bets');
                            $bet->team = $data['team1'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->money = $data['money'];
                            $bet->matchid = $data['matchidtobet'];
                            $bet->teamid = $data['teamid1'];
                            $bet->coef = $data['coef1'];
                            $bet->date = date("Y/m/d - h:i:sa");
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
              if( isset($data['betOnTeamTwo']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('bets');
                            $bet->team = $data['team2'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->matchid = $data['matchidtobet'];
                            $bet->money = $data['money'];
                            $bet->teamid = $data['teamid2'];
                            $bet->coef = $data['coef2'];
                            $bet->date = date("Y/m/d");
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
                    if( isset($data['betOnTeamOneWin1P1R']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('lcbets');
                            $bet->team = $data['team1'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->money = $data['money'];
                            $bet->matchid = $data['matchidtobet'];
                            $bet->teamid = $data['teamid1'];
                            $bet->coef = $data['lccoef1'];
                            $bet->kind = 'T:1;P:1;R:1';
                            $bet->date = date("Y/m/d - h:i:sa");
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
              if( isset($data['betOnTeamTwoWin1P1R']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('lcbets');
                            $bet->team = $data['team2'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->matchid = $data['matchidtobet'];
                            $bet->money = $data['money'];
                            $bet->teamid = $data['teamid2'];
                            $bet->coef = $data['lccoef2'];
                            $bet->date = date("Y/m/d");
                            $bet->kind = 'T:2;P:1;R:1';
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
              //
              //
              //
              if( isset($data['betOnTeamOneWin2P1R']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('lcbets');
                            $bet->team = $data['team1'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->money = $data['money'];
                            $bet->matchid = $data['matchidtobet'];
                            $bet->teamid = $data['teamid1'];
                            $bet->coef = $data['lccoef3'];
                            $bet->kind = 'T:1;P:2;R:1';
                            $bet->date = date("Y/m/d - h:i:sa");
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
              if( isset($data['betOnTeamTwoWin2P1R']) && isset($_SESSION['logged_user']) && is_numeric($data['money']) )
                    {
                      $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
                    foreach( $users as $user )
                    {
                      $userMoney = $user->money;
                    }
                      if ($data['money'] <= $userMoney)
                      {
                        if( $data['money'] < 15001 )
                        {
                          if( $data['money'] > 0 )
                          {
                            $user = R::load('users', $_SESSION['logged_user']->id);
                            $user->money = $user->money - $data['money'];
                            R::store($user);
                            $user = $user->fresh();
                            $bet = R::dispense('lcbets');
                            $bet->team = $data['team2'];
                            $bet->userid = $_SESSION['logged_user']->id;
                            $bet->username = $_SESSION['logged_user']->login;
                            $bet->matchid = $data['matchidtobet'];
                            $bet->money = $data['money'];
                            $bet->teamid = $data['teamid2'];
                            $bet->coef = $data['lccoef4'];
                            $bet->date = date("Y/m/d");
                            $bet->kind = 'T:2;P:2;R:1';
                            $bet->win = 0;
                            R::store($bet);
                            echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Вы успешно сделали ставку!</div>
                              <a href="https://link-construct.com/build/build/index.php" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                          }
                        } else if ( $data['money'] > 15001 ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Нельзя ставить больше 15000 рублей за раз!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                      } else if ( $data['money'] > $userMoney ) {
                          echo ('
                            <div id="notification_box" class="notification_box">
                              <div class="notification_title">Уведомление</div>
                              <div class="notification_text">Не хватает денег на балансе!</div>
                              <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
                            </div>');
                        }
                    }
              ?>
          </div>
          </div>
          <div class="rate_block">
            <div class="rate_title">Рейтинг</div>
            <div class="rating_block">
              <ul class="rating_list">
                <?php
                  $ur = R::findAll('users','ORDER BY `wonmoney` DESC LIMIT 10');
                  foreach( $ur as $ur )
                  {
                    echo('<li class="rating_item">
                          <img src="./img/profiles/'.$ur->login.'/'.$ur->img.'" class="rating_img">
                          <div class="rating_login">'.$ur->login.'</div>
                          <div class="rating_money">'.$ur->wonmoney.'<img src="./img/ices.svg" class="rating_img rating_img2"></div>
                        </li>');
                  }
                ?>
              </ul>
            </div>
          </div>
          <div class="bet_block bet_block3">
                <div class="upcoming_text"><img src="img/hot.svg" class="upcoming_img">Ближайшие матчи</div>
                <div class="match_blocks">
            <?php
            $matches = R::findCollection('matches',"ORDER BY `id` ASC");
            while( $match = $matches->next() )
            {
              if( $match->allow == "allow" )
              {
                echo ('<a class="bet_match">'.'<form method="POST">'
                .'<div class="bet_team1">'.
                '<img class="bet_icon bet_icon1" src="'.$match->photosrc1.'">'.'
                <div class="bet_team bet_team11">'.$match->team1.'</div>
                <div class="bet_coef bet_coef1">'.$match->coef1.'X</div></div>'.'<div class="bet_team2">'.
                '<img class="bet_icon" src="'.$match->photosrc2.'">'.'
                <div class="bet_team">'.$match->team2.'</div>
                <div class="bet_coef2 bet_coef">'.$match->coef2.'X</div></div>'.'<div class="bet_info">'.'<div class="bet_vs">'.$match->BO.'</div>'.'<div class="bet_date">'.$match->date.'</div>'.'<div class="bet_liga">'.$match->liga.'</div>'.'<input name="matchid" type="hidden" value="'.$match->id.'">'.'<button class="bet_bet" name="bet" type="submit"> Поставить'.'</button>'.'
                </div>'.'</form>'.'</a>');
              }
              }

            ?>
              </div>
            </div>
          </div>
            <div class="bet_block">
                <div class="upcoming_text"><img src="img/past.svg" class="upcoming_img">Прошедшие матчи</div>
                  <?php
                  $pmatches = R::findCollection('matches',"ORDER BY `id` ASC LIMIT 5");
                  while( $match = $pmatches->next() )
                  {
                    if( $match->winteam1 == "1" or $match->winteam2 == "1" )
                    {
                      echo ('<a class="bet_match">'.'<form method="POST">'
                .'<div class="bet_team1">'.
                '<img class="bet_icon bet_icon1" src="'.$match->photosrc1.'">'.'
                <div class="bet_team bet_team11">'.$match->team1.'</div>
                <div class="bet_coef bet_coef1">'.$match->coef1.'X</div>'.'<div class="team_status team_status1">'.$match->status1.'</div>'.'</div>'.'<div class="bet_team2">'.
                '<img class="bet_icon" src="'.$match->photosrc2.'">'.'
                <div class="bet_team">'.$match->team2.'</div>
                <div class="bet_coef2 bet_coef">'.$match->coef2.'X</div>'.'<div class="team_status team_status2">'.$match->status2.'</div>'.'</div>'.'<div class="bet_info">'.'<div class="bet_vs">'.$match->BO.'</div>'.'<div class="bet_date">'.$match->date.'</div>'.'<div class="bet_liga">'.$match->liga.'</div>'.'<input name="matchid" type="hidden" value="'.$match->id.'">'.'<div class="bet_deny" style="margin-top: 5px; width: 100px;">Матч окончен'.'</div>'.'
                </div>'.'</form>'.'</a>');
                    }
                    }
                  ?>
            </div>
            </div>
        </section>
    </main>
    <footer class="footer">
      <div class="footer_description">
        <div class="footer_description_text">Сайт по ставкам на киберспорт, домен защищён. Пользовательские права защищены. По любым вопросам, писать на почту или в вк. Удачных ставок, с уважением, HardBet.</div>
        <a href="php/agreement.php" class="footer_agreement">Пользовательское соглашение</a>
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
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="js/foundation.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script refer type="text/javascript" src="js/foundation.js"></script>
    <script>
    //При загрузке страницы подгружаем сообщения
    load_messes();
    load_messes2();
    //Ставим цикл на каждые три секунды
    setInterval(load_messes,1000);
    setInterval(load_messes2,1000);
    </script>
    <script>
    $(document).ready(function(){
        var url1 = "https://api.twitch.tv/kraken/streams/Starladder5?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url1).done(function(data){
            if(data.stream === null) {
                $('#channelstatus1').html('OFFLINE');
                $('#channeldisplayname1').html("CHANNEL IS OFFLINE");
            } else {
                $('#channelstatus1').html('ONLINE');
            }
        });
    });
    $(document).ready(function(){
        var url2 = "https://api.twitch.tv/kraken/streams/ESL_CSGO?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url2).done(function(data){
            if(data.stream === null) {
                $('#channelstatus2').html('OFFLINE');
                $('#channeldisplayname2').html("CHANNEL IS OFFLINE");
            } else {
                $('#channelstatus2').html('ONLINE');
            }
        });
    });
    $(document).ready(function(){
        var url3 = "https://api.twitch.tv/kraken/streams/UCCleague?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url3).done(function(data){
            if(data.stream === null) {
                $('#channelstatus3').html('OFFLINE');
                $('#channeldisplayname3').html("CHANNEL IS OFFLINE");
            } else {
                $('#channelstatus3').html('ONLINE');
            }
        });
    });
    $(document).ready(function(){
        var url1 = "https://api.twitch.tv/kraken/streams/Starladder5?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url1).done(function(data2){
            var name = data2.stream.channel.status;
            $('#channeldisplayname1').html(name);
        });
    });
    $(document).ready(function(){
        var url2 = "https://api.twitch.tv/kraken/streams/ESL_CSGO?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url2).done(function(data2){
            var name = data2.stream.channel.status;
            $('#channeldisplayname2').html(name);
        });
    });
    $(document).ready(function(){
        var url3 = "https://api.twitch.tv/kraken/streams/UCCleague?client_id=v1gmd0bdz5l8hbzzg9cbm624tf3c4h";
        $.getJSON(url3).done(function(data2){
            var name = data2.stream.channel.status;
            $('#channeldisplayname3').html(name);
        });
    });
    function matchBetClose(){
        document.getElementById("match_bet").style="display: none";
    }

    function channelSwitch1(){
      document.getElementById("slide1").style="display: block";
      document.getElementById("slide2").style="display: none";
      document.getElementById("slide3").style="display: none";
    }
    function channelSwitch2(){
      document.getElementById("slide1").style="display: none";
      document.getElementById("slide2").style="display: block";
      document.getElementById("slide3").style="display: none";
    }
    function channelSwitch3(){
      document.getElementById("slide1").style="display: none";
      document.getElementById("slide2").style="display: none";
      document.getElementById("slide3").style="display: block";
    }
    function notificationClose() {
      document.getElementById("notification_box").style="display: none";
      document.getElementById("notification_background").style="display: none";
      window.location="http://link-construct.com/index.php";
    }
    $( "#channeldisplayname1" ).mouseenter(function() {
      document.getElementById("channelalt1").style="display: block";
    });
  </script>
  </body>
</html>