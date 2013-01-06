<?php
	//CONEXION BBDD
	$link = mysql_connect('127.0.0.1', 'root', '');
	mysql_select_db("social");
	//CABECERA
	function head($title){
		?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<!-- METAS -->
				<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
				<meta name="Keywords" content="Social,red social,gratuito,asir">
				<meta name="Description" content="Proyecto de Red Social de 2 ASIR">
				<!-- FAVICON -->
				<link rel='shortcut icon' href='css/favicon.ico' />
				<link rel='icon' href='css/favicon.ico' type='image/x-ico' />
				<link rel="shortcut icon" href="css/favicon.ico" type="image/x-icon">
				<!-- CSS -->
				<link rel='stylesheet' href='css/style.css' type='text/css' />
				<link rel='stylesheet' href='jscripts/jquery-ui/css/redmond/jquery-ui-1.9.0.custom.css' type='text/css' />
				<!-- JS -->
				<script type="text/javascript" src="jscripts/jquery-1.8.2.min.js"></script>
				<script type="text/javascript" src="jscripts/jquery-ui/jquery-ui-1.9.0.js"></script>
				<script type="text/javascript" src="jscripts/general.js"></script>
				<?php
					if($_SESSION['chat_estado']=="on")
						echo "<script type='text/javascript' src='jscripts/chat.js'></script>";
				?>
				<title><?php echo $title; ?></title>
	<?php
	}

	//LAST ID
	function consulta_last_id($tabla,$campo){
		$sql="SELECT IFNULL(MAX(".$campo.")+1,1) AS id FROM ".$tabla;
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		return $row['id'];
	}

	//LIMPIA CADENAS
	function limpia_texto($string){
		$string = trim($string);
		$string = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
		$string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
		$string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
		$string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
		$string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
		$string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C'), $string);
		$string = str_replace(array("\\", "¨", "º", "-", "~", "#", "@", "|", "!", "\"", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "`", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":", ".", " "), '-', $string);
		return $string;
	}

	//ERROR MYSQL
	function error_mysql($p1){
		if(mysql_error()!=0){
			echo "No error: ".mysql_errno()." -> ".mysql_error()."<br>";
			if($p1=="exit"){
				die("Script detenido por fallo PHP");
			}
		}
	}
?>