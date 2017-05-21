<?php 
	session_start();
	require('auth.php');
	enforceLogin();
	
	$err = '';
	
	require('xmlify.php');
	if(isset($_POST['submit'])){
		if(!writeItem($_POST['name'], $_POST['type'], $_POST['material'], $_POST['inventory'])) {
			$err = 'Error';
		}
		//header('Location: dashboard.php');
		//exit;
	}
	
	function fileCheck(){
		if(!isset($_GET['edit'])){
			echo 'var taken = new Set();' . "\n";
			$dir = scandir('xml/');
			foreach($dir as $i){
				echo 'taken.add("' . $i . '");' . "\n";
			}
			echo "if(taken.has(document.forms['createForm']['name'].value)){ 
			document.getElementById('error').innerHTML = '<p>This name is already taken!</p>'; 
			return false;
			}";
		}
	}
	
	function isEdit(){
		if(isset($_GET['edit'])){
			$xml = simplexml_load_file('xml/' . generateRegistryName($_GET['edit'] . '.xml'));
			print_r($xml->children());
			/*
			if($xml->owner == $_SESSION['user']){
				echo "
				function isEdit(){
					document.getElementById('name').value = '" . $xml->englishname . "';
					document.getElementById('type').value = '" . $xml . "';
				}
				window.onload = isEdit();
				";
			}else{
				return false;
			}
			* */
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>NOSE Dashboard | Create</title>
		<link rel = 'icon' type = 'image/png' href = 'logo.png'>
		<link rel = 'stylesheet' type = 'text/css' href = 'css/main.css'>
		<script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	</head>
	<body style = 'background-image: url("img/playstation-pattern.png");'>
		<div class = 'center-box'>
			<div class = 'header'>
				<p class = 'large'>Create!</p>
				<div class = 'divider'></div>
			</div>
			<div id = 'error' style = 'color: red'><?php echo $err;?></div>
			<form action = 'create.php' method = 'POST' onsubmit = 'return checkForm()' name = 'createForm' style = 'margin-top: 3%'>
				<input class = 'input-pretty' type = 'text' name = 'name' placeholder = 'Name' id = 'name'><br>
				<!-- <textarea class = 'top-margin-small input-pretty para-box' placeholder = 'Description...' form = 'createForm' name = 'desc'></textarea><br> -->
				<select class = 'top-margin-small' name = 'type' id = 'type' onchange = 'contentTypeMenu()'>
					<option value = 'item'>Item</option>
					<option value = 'block'>Block</option>
				</select>
				<div id = 'material-fill'></div>
				<select class = 'top-margin-small' name = 'inventory' id = 'inventory'>
					<option value = 'misc'>Miscellaneous</option>
					<option value = 'block'>Block</option>
					<option value = 'decoration'>Decoration</option>
					<option value = 'redstone'>Redstone</option>
					<option value = 'transportation'>Transportation</option>
					<option value = 'food'>Food</option>
					<option value = 'tools'>Tools</option>
					<option value = 'combat'>Combat</option>
					<option value = 'brewing'>Brewing</option>
					<option value = 'materials'>Materials</option>
				</select><br>
				 <input class = 'top-margin-medium' name = 'submit' type = 'submit' value = 'Create!'>
			</form>
			
		</div>
		<script>
			function contentTypeMenu(){
				var type = document.getElementById('type');
				if(type.options[type.selectedIndex].value == 'item'){
						document.getElementById('material-fill').innerHTML = "";
				} else if(type.options[type.selectedIndex].value == 'block'){
					document.getElementById('material-fill').innerHTML = "<select class = 'top-margin-small' name = 'material'><option value='grass'>Grass</option><option value='ground'>Ground</option><option value='wood'>Wood</option><option value='rock'>Rock</option><option value='iron'>Iron</option><option value='anvil'>Anvil</option><option value='water'>Water</option><option value='lava'>Lava</option><option value='leaves'>Leaves</option><option value='plants'>Plants</option> <option value='vine'>Vine</option><option value='sponge'>Sponge</option><option value='cloth'>Cloth</option><option value='fire'>Fire</option><option value='sand'>Sand</option><option value='circuits'>Circuits</option> <option value='materialCarpet'>Carpet Material</option> <option value='glass'>Glass</option><option value='redstoneLight'>Redstone Light</option> <option value='tnt'>Tnt</option><option value='coral'>Coral</option><option value='ice'>Ice</option><option value='snow'>Snow</option><option value='craftedSnow'>Snow Crafted</option><option value='cactus'>Cactus</option><option value='clay'>Clay</option><option value='pumpkin'>Pumpkin</option><option value='dragonEgg'>Dragon Egg</option><option value='portal'>Portal</option><option value='cake'>Cake</option><option value='web'>Web</option><option value='piston'>Piston</option></select>";
				}
			}
			function checkForm(){
				<?php fileCheck(); ?>
				if(document.forms['createForm']['name'].value == ''){
					document.getElementById('error').innerHTML = '<p>Please enter a correct name</p>';
					return false;
				}
			}
			<?php isEdit(); ?>
			
		</script>
	</body>
</html>

