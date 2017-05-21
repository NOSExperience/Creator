<?php

function enforceLogin() {
	if(!isset($_SESSION['user'])) {
		header('Location: login.php');
		exit;
	}
}

function checkLogin($user, $pass) {
	//No, we don't even begin to think this is finished :P
	return ($user == 'admin' && $pass == 'temp');
}

?>
