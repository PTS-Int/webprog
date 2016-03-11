<?php
	session_start();
	require_once('dbDemoUtil.php');
	$db = dbDemo_connect();
	if(!isset($db)){
		$content .= 'ERROR: Cannot connect to the database.';
	}else{
		if(!isset($_GET['page'])){
			$page = 'home';
		}else{
			$page = $_GET['page'];
		}
		$content .= dbDemo_gen_content($page);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Student DB</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="dbDemo.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script src="dbDemo.js"></script>
	</head>
	<body>
		<?php print $content;?>
		<div style="clear:both;"></div>
	</body>
</html>