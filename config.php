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
				<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
				<link rel='shortcut icon' href='css/favicon.ico' />
				<link rel='icon' href='css/favicon.ico' type='image/x-ico' />
				<link rel="shortcut icon" href="css/favicon.ico" type="image/x-icon">
				<meta name="Keywords" content="Social,red social,gratuito,asir">
				<meta name="Description" content="Proyecto de Red Social de 2� ASIR">
				<link rel='stylesheet' href='css/style.css' type='text/css' />
				<script type="text/javascript" src="jscripts/jquery.metadata.js"></script>
				<script type="text/javascript" src="jscripts/general.js"></script>
				<title><?php echo $title; ?></title>
			</head>
			<body>
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
	function limpia_texto($cadena){
		$tofind = "����������������������������������������������������� ?�";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn___";
		return strtr($cadena, $tofind, $replac);
	}
	
	//ERROR MYSQL
	function error_mysql($p1){
		echo "No error: ".mysql_errno()." -> ".mysql_error()."<br>";
		if($p1=="exit"){
			die("Script detenido por fallo PHP");
		}
	}
?>