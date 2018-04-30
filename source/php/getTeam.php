<?php
	require "db.php";
	$data = $_POST;
	$match = R::find('matches',' id = ? ', (int)$_POST[matchid] );
    foreach( $match as $match )
    {
      echo ('<div class="match">'.$id.'</div>');
    }
?>