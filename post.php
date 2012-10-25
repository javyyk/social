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
	
	if($_POST['comentario_tablon']!=""){
		mysql_query("INSERT INTO tablon (emisor,receptor,comentario) VALUES ('".$global_idusuarios."','".$_POST['receptor']."','".$_POST['comentario_tablon']."')");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}else{
			header("Location: gente.php?id=".$_POST['receptor']);
		}
	}
	
	if($_POST['mensaje_privado']!=""){
		mysql_query("INSERT INTO mps (emisor,receptor,mp) VALUES ('".$global_idusuarios."','".$_POST['receptor']."','".$_POST['mensaje_privado']."')");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}else{
			header("Location: gente.php?id=".$_POST['receptor']."&mp_enviado");
		}
	}
	
	if($_GET['mensaje_leido']!=""){
		mysql_query("UPDATE mps SET estado='leido' WHERE idmps='".$_GET['mensaje_leido']."'");
		if(mysql_errno()!=0){
			error_mysql();
		}
	}
	echo "<pre>";
	print_r($_POST);
	echo "<br>";
	print_r($_GET);
	echo "</pre>";
?>