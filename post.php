<?php
	require("verify_login.php");
	
	if($_POST['estado']){
		mysql_query("UPDATE usuarios SET estado='".$_POST['estado']."' WHERE idusuarios='".$global_idusuarios."'");
		if(mysql_errno()==0){
			header("Location: perfil.php?estado_cambiado");
		}else{
			error_mysql();
		}
	}
	
	
	if($_GET['aceptarpeticion']){
		$query=mysql_query("SELECT * FROM amigos WHERE user1='".$_GET['emisor']."' AND user2='".$global_idusuarios."' OR user1='".$global_idusuarios."' AND user2='".$_GET['emisor']."'");	
		if(mysql_errno()!=0){
			error_mysql("exit");
		}
		if(mysql_num_rows($query)>0){
			header("Location: inicio.php?yasoisamigos");
		}
		
		mysql_query("INSERT INTO amigos (user1,user2) VALUES ('".$_GET['emisor']."','".$global_idusuarios."')");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}
		mysql_query("DELETE FROM peticiones WHERE emisor='".$_GET['emisor']."' AND receptor='".$global_idusuarios."'");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}
		header("Location: inicio.php");
	}
	
?>