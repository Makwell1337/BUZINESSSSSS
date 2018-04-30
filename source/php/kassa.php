<?

require "./db.php";
$data = $_POST;

$m_shop = '455387153';
$m_login = $_SESSION['logged_user']->id;
$m_orderid = '1';
$m_amount = number_format(0.1, 2, '.', '');
$m_curr = 'RUB';
$m_desc = base64_encode('Пополнение счёта');
$m_key = 'sticks18rus';

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
<meta name="interkassa-verification" content="c8c6250e3a7808a38c1feec9c65de3f1" />
    <meta name="viewport" content="width=device-width"/>
    <link href="../style/app.css" rel="stylesheet" media="screen, projection, print"/>
    <link href="../style/foundation.css" rel="stylesheet" media="screen, projection, print"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
	<form method="post" action="https://payeer.com/merchant/">
      <input type="hidden" name="m_shop" value="<?=$m_shop?>">
      <input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
      <input type="hidden" name="m_amount" value="<?=$m_amount?>">
      <input type="hidden" name="m_curr" value="<?=$m_curr?>">
      <input type="hidden" name="m_desc" value="<?=$m_desc?>">
      <input type="hidden" name="m_sign" value="<?=$sign?>">
      <input type="hidden" name="m_login" value="<?$m_login?>">
      <input type="submit" name="m_process" value="Пополнить" />
    </form>
</body>
</html>