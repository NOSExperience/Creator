<?php

	function writeItem($name, $type, $material, $tab) {
		
		if(!(check($name) && check($type) && check($material) && check($tab))) {
			return false;
		}
		
		$regname = generateRegistryName($name);
		
		if(!shouldProceed($regname)) {
			return false;
		}
		
		if(!createXML($regname, $name, $type, $material, $tab)) {
			return false;
		}
		
		/*
		if(!writeOut()) {
		}
		*/
		
		return true;
	}
	
	function check($name) {
		return ($name == htmlspecialchars($name) && $name == stripslashes($name) && $name == trim($name) && stristr($name, '/') == '' && stristr($name, '.') == '');
	}
	
	function generateRegistryName($name) {
		$pieces = explode(' ', $name);
		$joined = join($pieces);
		return strtolower($joined);
	}
	
	function shouldProceed($filename) {
		return !file_exists('xml/' . $filename);
	}
	
	function createXML($regname, $name, $type, $material, $tab) {
		//echo $name . $type . $material . $tab;
		
		if(isset($regname) && isset($name) && isset($type) && isset($tab)) {
			$str = "<?xml version = '1.0'?>\n<xml>\n\t<" . $type . ">\n";

			$str .= "\t\t<registryname>" . $regname . "</registryname>\n";
			$str .= "\t\t<englishname>" . $name . "</englishname>\n";
			//$str .= "\t<type>" . $type . "</type>\n";
			$str .= "\t\t<inventorytab>" . $tab . "</inventorytab>\n";
			if(isset($material)) {
				$str .= "\t\t<material>" . $material . "</material>\n";
			}
			$str .= "\t\t<owner>" . $_SESSION['user'] . "</owner>\n";
			
			$str .= "\t</" . $type . ">\n";
			$str .= '</xml>';
			
			writeOut($str, 'xml/' . $regname . '.xml');
			
			//$xml->addChild('registryname', $regname);
			//$xml->addChild('englishname', $name);
			//echo $xml->asXML();
		} else {
			return false;
		}
		
		/*
		if(isset($material)) {
			echo 'hi';
		} else {
			echo 'hello';
		}
		*/
		
		return true;
	}
	
	function writeOut($string, $filename) {
		$file = fopen($filename, "w");
		if(!file) {
			return false;
		}
		
		if(!fputs($file, $string)) {
			return false;
		}
		
		if(!fclose($file)) {
			return false;
		}
		
		return true;
	}
	
?>
