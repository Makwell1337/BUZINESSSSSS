<?
require "db.php";
$data = $_POST;


if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189'))) exit('Ошибка платежа (IP)');

if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
{
	$m_key = 'sticks18rus';
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
	if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
	{
		echo $_POST['m_orderid'].'|success';
      	$user = R::load('users', $_POST['m_desc']);
      	$user->money = $user->money + $_POST['m_amount'];
      	R::store($user);
      	$user = $user->fresh();
		exit;
	}
	echo $_POST['m_orderid'].'|error';
}
?>