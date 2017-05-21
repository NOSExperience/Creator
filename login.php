<?php

	session_start();
	
	require('auth.php');

	if(isset($_SESSION['user'])) {
		header('Location: dashboard.php');
		exit;
	}

	if(isset($_POST['submit'])) {
		if(checkLogin($_POST['username'], $_POST['password'])) {
			header('Location: dashboard.php');
			$_SESSION['user'] = 'admin';
		}
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = 'utf-8'>
		<title>NOSE Login</title>
		<link rel = 'icon' type = 'image/png' href = 'logo.png'>
		<link rel = 'stylesheet' type = 'text/css' href = 'css/main.css'>
	</head>
	<body style = 'background-image: url("img/hip-square.png");'>
		<div class = 'center-box' style = 'margin-top: 4%;'>
			<div class = 'header'>
				<p class = 'large'>Welcome</p>
				<div class = 'divider'></div>
				<p class = 'small'>To get started with the creator, login below</p>
			</div>
			<form method = 'post' action = '#'>
				<input type = 'text' name = 'username'><br>
				<input type = 'password' name = 'password'><br>
				<input type = 'submit' name = 'submit' value = 'Login'>
			</form>
		</div>
	</body>
</html>
