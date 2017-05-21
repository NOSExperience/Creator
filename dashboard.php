<?php

session_start();
require('auth.php');
enforceLogin();

$xml_names = array();
$xml_type = array();
$xml_registry = array();
$xml_material = array();

function parse($data, $request) {
	$xml = simplexml_load_file($data);
	if(!$xml) {
		foreach(libxml_get_errors() as $err) {
			echo $err->message . '<br>';
		}
	}	
	if($request == 'img'){
		echo '<img src="logo.png"/>' . "\n";
		//echo '&nbsp;&nbsp;&nbsp;&nbsp;block: ' . $xml->block->registryname . '<br>';
	} else if($request == 'array'){
		global $xml_names;
		if($xml->block[0] == null && $xml->item[0] != null){
			array_push($xml_names, $xml->item[0]->englishname);
		} else if($xml->block[0] != null && $xml->item[0] == null){
			array_push($xml_names, $xml->block[0]->englishname);
		}else{
			fancyDie('XML File Error', 'An XML file does not have the main node of eather "Block" or "Item"');
		}
	}
}

function discoverAndParseAll($request) {
	$files = scandir('../nosemod');
	
	if(count($files) > 0) {
		foreach($files as $i) {
			/*
			if($i == '_dirlist.html') {
				continue;
			} else if($i == 'NoseRes.zip') {
				continue;
			} else if($i == 'options.txt') {
				continue;
			}
			*/
			
			$subs = explode('.', $i);
			if($subs[count($subs) - 1] != 'xml') {
				continue;
			}
			
			//echo $i . '<br>';
			parse('../nosemod/' . $i, 'img');
			parse('../nosemod/' . $i, 'array');
		}
	}
}

function printArray($title, $array){
		echo 'var ' . $title . ' = [';
		foreach($array as $i){
			if($i != null){
				print_r("'" . $i . "'" . ', ');
			}
		}
		echo '"ending"];' . "\n";
}

function fancyDie($title, $subtitle){
	if($_POST['ignore'] == null){
	die('<html>
			<head>
				<link rel = "stylesheet" href="css/main.css" type="text/css">
			</head>
			<body>
				<div class="fancydie">
					<h1>'. $title . '</h1>
					<p>' . $subtitle . '</p>
					<p color="red">Please contact technical support to help with this issue</p>
					<form action="dashboard.php" method="POST">
						<input type="submit" value="Ignore Errors" name="ignore">
					</form>
				</div>
			</body>
		</html>
	');
	}
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset = 'utf-8'>
		<title>NOSE Dashboard</title>
		<link rel = 'icon' type = 'image/png' href = 'logo.png'>
		<link rel = 'stylesheet' href = 'css/coverflow.css'>
		<link rel = 'stylesheet' href = 'css/main.css' type = 'text/css'>
		<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	</head>
	<body style = 'background-image: url("img/playstation-pattern.png");' >
	<a href = 'logout.php' class = 'btn btn-neutral' id='logout'>Logout</a>
	<div>
		<div id='coverflow'>
			<?php
			discoverAndParseAll();
			?>
		</div><br>		
	</div>
	<div id='info'></div>
	<form action = 'create.php' method = 'GET'>
		<div id = 'edit'></div>
	</form>
	<script src = 'js/coverflow.js'></script>
	<script>
	<?php  printArray('titles' , $xml_names); ?>
	$(function() {
		$('#coverflow').coverflow({
			select: function(event, ui){
				document.getElementById('info').innerHTML = titles[ui.index];
				document.getElementById('edit').innerHTML = "<button type = 'submit' name = 'edit' value = '" + titles[ui.index] + "'>Edit</button>";
			}
		});
	});
	$(function(){
		for(i = titles.length - 1; i > 0; i--) {
			setTimeout(function(num) {
				//console.log(num);
				$('#coverflow').coverflow('select', num);
			}, 200 * (i ** -1.5), i - 1);
		}
	});
	</script>
	</body>
</html>
