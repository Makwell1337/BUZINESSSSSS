<?


if ($_SERVER['REQUEST_URI'] == '/')
	$page = 'home';
else
	$page = substr($_SERVER['REQUEST_URI'], 1);


session_start();


if (file_exists('all/'.$page.'.php'))
	include 'all/'.$page.'.php';


else if ($_SESSION['id'] == 1 and file_exists('auth/'.$page.'.php'))
	include 'auth/'.$page.'.php';


else if ($_SESSION['id'] != 1 and file_exists('guest/'.$page.'.php'))
	include 'guest/'.$page.'.php';


else
	exit('Страница 404');



function top($title) {
	include 'html/top.php';
}


function bottom() {
	include 'html/bottom.php';
}


?>