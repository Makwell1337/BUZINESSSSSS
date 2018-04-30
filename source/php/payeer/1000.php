<?php
  require "../db.php";
  $data = $_POST;

  $m_amount = number_format(1000, 2, '.', '');
  $m_shop = '455387153';
  $m_orderid = '1';
  $m_curr = 'RUB';
  $m_desc = $_SESSION['logged_user']->id;
  $m_key = 'sticks18rus';
  $m_user_id = $_SESSION['logged_user']->id;
  $arHash = array(
        $m_shop,
        $m_orderid,
        $m_amount,
        $m_curr,
        $m_desc,
        $m_key
    );
  $sign = strtoupper(hash('sha256', implode(':', $arHash)));
 
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="interkassa-verification" content="c8c6250e3a7808a38c1feec9c65de3f1" />
    <meta name="viewport" content="width=device-width"/>
    <link href="../../style/app.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="../../style/foundation.css" rel="stylesheet" media="screen, projection, print"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <title><?php echo($title) ?></title>
  </head>
<body>
	<form method="POST" action="https://payeer.com/merchant/">
	  <input type="hidden" name="m_shop" value="<?=$m_shop?>"> <!-- 92.53.96.120 -->
	  <input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
	  <input type="hidden" name="m_amount" value="<?=$m_amount?>">
	  <input type="hidden" name="m_curr" value="<?=$m_curr?>">
	  <input type="hidden" name="m_desc" value="<?=$m_desc?>">
	  <input type="hidden" name="m_sign" value="<?=$sign?>">
	  <input type="hidden" name="m_user_id" value="<?php echo $_SESSION['logged_user']->id ?>">
	  <input type="submit" class="payeer_input" name="m_process" value="Пополнить" />
	</form>
</body>
</html>