<?php
	session_start();
	require('config.php');
	//echo $_SESSION['idsesion']."...";
	if(isset($_SESSION['idsesion'])) {
		$login=mysql_query("SELECT * FROM usuarios WHERE idsesion='".$_SESSION['idsesion']."'");
		//echo mysql_num_rows($login);
		if(mysql_num_rows($login)!=1){
			header("Location: logout.php?auth_error");
		}
		$usuario=mysql_fetch_assoc($login);
		$global_idusuarios=$usuario['idusuarios'];
		$global_nombre=$usuario['nombre'];
		$global_apellidos=$usuario['apellidos'];
		$global_nombrefull=$usuario['nombre']." ".$usuario['apellidos'];
		$global_idsesion=$usuario['idsesion'];
	} else {
		header("Location: logout.php?no_sesion");
	}
?>