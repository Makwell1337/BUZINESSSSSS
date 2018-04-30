<?


if ( $_POST['enter'] ) {


require_once('cpayeer.php');
$accountNumber = 'P58037670';
$apiId = '303964686';
$apiKey = 'ay7ETQDHwwcHUqvF';
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
if ($payeer->isAuth())
{
	$arTransfer = $payeer->transfer(array(
		'curIn' => 'RUB',
		'sum' => $_POST['sum'],
		'curOut' => 'RUB',
		'to' => 'P22293214',
		'comment' => 'php.youtube',
	));
	if (empty($arTransfer['errors']))
	{
		echo ": Перевод средств успешно выполнен, сумма: $_POST[sum], транзакция: $arTransfer[historyId]";
	}
	else
	{
		echo '<pre>'.print_r($arTransfer["errors"], true).'</pre>';
	}
}
else
{
	echo '<pre>'.print_r($payeer->getErrors(), true).'</pre>';
}
	

}


?>