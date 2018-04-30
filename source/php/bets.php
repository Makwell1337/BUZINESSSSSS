<?php
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
              $bet = R::dispense('LCbets');
              $bet->team = $data['team1'];
              $bet->userid = $_SESSION['logged_user']->id;
              $bet->username = $_SESSION['logged_user']->login;
              $bet->money = $data['money'];
              $bet->matchid = $data['matchidtobet'];
              $bet->teamid = $data['teamid1'];
              $bet->coef = $data['coef1'];
              $bet->kind = 'T:1;P:1;R:1';
              $bet->date = date("Y/m/d - h:i:sa");
              $bet->win = 0;
              R::store($bet);
              echo ('
              <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно сделали ставку!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
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
              $bet = R::dispense('LCbets');
              $bet->team = $data['team2'];
              $bet->userid = $_SESSION['logged_user']->id;
              $bet->username = $_SESSION['logged_user']->login;
              $bet->matchid = $data['matchidtobet'];
              $bet->money = $data['money'];
              $bet->teamid = $data['teamid2'];
              $bet->coef = $data['coef2'];
              $bet->date = date("Y/m/d");
              $bet->kind = 'T:2;P:1;R:1';
              $bet->win = 0;
              R::store($bet);
              echo ('
              <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно сделали ставку!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
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
              $bet = R::dispense('LCbets');
              $bet->team = $data['team1'];
              $bet->userid = $_SESSION['logged_user']->id;
              $bet->username = $_SESSION['logged_user']->login;
              $bet->money = $data['money'];
              $bet->matchid = $data['matchidtobet'];
              $bet->teamid = $data['teamid1'];
              $bet->coef = $data['coef1'];
              $bet->kind = 'T:1;P:2;R:1';
              $bet->date = date("Y/m/d - h:i:sa");
              $bet->win = 0;
              R::store($bet);
              echo ('
              <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно сделали ставку!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
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
              $bet = R::dispense('LCbets');
              $bet->team = $data['team2'];
              $bet->userid = $_SESSION['logged_user']->id;
              $bet->username = $_SESSION['logged_user']->login;
              $bet->matchid = $data['matchidtobet'];
              $bet->money = $data['money'];
              $bet->teamid = $data['teamid2'];
              $bet->coef = $data['coef2'];
              $bet->date = date("Y/m/d");
              $bet->kind = 'T:2;P:2;R:1';
              $bet->win = 0;
              R::store($bet);
              echo ('
              <div id="notification_box" class="notification_box">
                <div class="notification_title">Уведомление</div>
                <div class="notification_text">Вы успешно сделали ставку!</div>
                <a href="#" class="notification_close" onclick="notificationClose()">Закрыть</a>
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