<?php
      require "./php/db.php";
      $data = $_POST;
      $title = 'Ставки на киберспорт';
      if(isset($data['send']))
      {
      	$message = R::dispense('messages');
	    $message->name = $data['name'];
	    $message->text = $data['text'];
	    $message->time = date("Y-m-d");
	    R::store($message);
      }


?>

<html>
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="interkassa-verification" content="c8c6250e3a7808a38c1feec9c65de3f1" />
    <script src="/js/foundation.js"></script>
    <script src="/js/app.js"></script>
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://cdn.jsdelivr.net/emojione/1.3.0/lib/js/emojione.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/emojione/1.3.0/assets/css/emojione.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title><?php echo($title) ?></title>
  </head>
  <body>
  	<form method="POST" class="form">
  		<input type="text" value="<?php @data['name'] ?>" name="name" class="text">
  		<br>
  		<input type="text" name="text" value="<?php @data['text'] ?>" class="text">
  		<br>
  		<button class="submit" name="send" type="submit">Отправить</button>
  	</form>
  	<div class="block">
  		<?php
  			$messages = R::findCollection('messages',"ORDER BY `id` DESC");
  			while( $message = $messages->next() )
            {
              echo ($message->name.':'.$message->text.'<br>/'.$message->time.'<br>/'.'<br>/'.'<br>/');
              }
  		?>
  	</div>
    <script src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>
    <script src="/js/foundation.js"></script>
    <script src="/js/app.js"></script>
    <script src="http://cdn.jsdelivr.net/emojione/1.3.0/lib/js/emojione.min.js"></script>
    <script src="./assets/js/script.js"></script>
  </body>
</html>