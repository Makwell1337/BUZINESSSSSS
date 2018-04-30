<?php

	echo '<div style="font-family: Arial;
	font-size: 24px;
	color: #AF083F;
	text-align: center;"> Оплата успешно произведена'.'<a style="font-family: Arial;
	font-size: 24px;
	color: #AF083F;
	display: block;" href="../index.php"> Вернуться на главную'.'</a>'.'</div>';

	header('Content-Type: text/plain');
	
	$file = "./resulttest.txt";
	$text = file_get_contents($file);
	$newFile = fopen("result.php", 'w');
	fwrite($newFile, $text);
	fclose($file);

?>