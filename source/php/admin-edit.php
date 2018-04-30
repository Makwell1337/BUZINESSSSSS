<?php
  require "db.php";

  $data = $_POST;
  if( isset($data['do_team-add']) )
  {
  	$coef1 = round(100/$data['winperteam1'], 2);
  	$coef2 = round(100/$data['winperteam2'], 2);
    $lccoef1 = round(100/$data['lcwinperteam1'], 2);
    $lccoef2 = round(100/$data['lcwinperteam2'], 2);
    $lccoef3 = round(100/$data['lcwinperteam3'], 2);
    $lccoef4 = round(100/$data['lcwinperteam4'], 2);
    $match = R::dispense('matches');
    $match->team1 = $data['team1'];
    $match->photosrc1 = $data['photosrc1'];
    $match->photosrc2 = $data['photosrc2'];
    $match->team2 = $data['team2'];
    $match->coef1 = $coef1;
    $match->coef2 = $coef2;
    $match->lccoef1 = $lccoef1;
    $match->lccoef2 = $lccoef2;
    $match->lccoef3 = $lccoef3;
    $match->lccoef4 = $lccoef4;
    $match->teamid1 = 1;
    $match->teamid2 = 2;
    $match->liga = $data['liga'];
    $match->BO = $data['BO'];
    $match->winteam1 = 0;
    $match->winteam2 = 0;
    $match->winteam1P1R1 = 0;
    $match->winteam2P1R1 = 0;
    $match->winteam1P2R1 = 0;
    $match->winteam2P2R1 = 0;
    $match->status1 = "";
    $match->status2 = "";
    $match->allow = "allow";
    $match->date = $data['date'];
    $match->time = date("Y-m-d");
    R::store($match);
    echo '<div class="admin_login-success"> Матч добавлен'.'</div>';
    die();
  }
?>
<?php 
  $users = R::find('users',' id = ? ', array($_SESSION['logged_user']->id) );
	foreach( $users as $user )
	{
		$userRole = $user->role;
	}
  if( $userRole == "admin" ) : 
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
          <form action="admin-edit.php" accept-charset="utf-8" method="POST" class="form">
              <input type="text" name="photosrc1" class="input" value="img/teams/">
              <input type="text" name="team1" class="input">
              <input type="text" name="photosrc2" class="input" value="img/teams/">
              <input type="text" name="team2" class="input">
              <input type="text" name="winperteam1" placeholder="%team1" class="input">
              <input type="text" name="winperteam2" placeholder="%team2" class="input">
              <input type="text" name="lcwinperteam1" placeholder="%team1" class="input">
              <input type="text" name="lcwinperteam2" placeholder="%team2" class="input">
              <input type="text" name="lcwinperteam3" placeholder="%team3" class="input">
              <input type="text" name="lcwinperteam4" placeholder="%team4" class="input">
              <input type="text" name="liga" placeholder="Лига" class="input">
              <input type="text" name="BO" placeholder="BO" class="input">
              <input type="text" name="date" placeholder="Дата игры" class="input">
              <button name="do_team-add" type="submit">Добавить тимы</button>
            </form>
        </main>
      </div>
      <script src="/js/foundation.js"></script>
      <script src="/js/app.js"></script>
    </body>
  </html>
<?php else : ?>
<?php endif; ?>