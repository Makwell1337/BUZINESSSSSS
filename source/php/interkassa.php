<?

$dataSet = $_POST;
require "db.php";


if (!$dataSet)
	exit('Ошибка платежа');


unset($dataSet['ik_sign']); // удаляем из данных строку подписи
ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
array_push($dataSet, 'efm1DsLcz4lWdyTD'); // добавляем в конец массива "секретный ключ"
$signString = implode(':', $dataSet); // конкатенируем значения через символ ":"
$sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64


if ($sign != $_POST['ik_sign'])
	exit('Ошибка обработки платежа');



file_put_contents('1.txt', "Логин: $_POST[ik_x_login], сум: $_POST[ik_am]");
//$ticket = R::dispense('tickets');
//$ticket->user = $_POST[ik_x_login];
//$ticket->money = $_POST[ik_am];
//R::store($ticket);
$user = R::load('users', $_POST['ik_x_login']);
$user->money += $_POST['ik_am'];
R::store($user);
$user = $user->fresh();

?>