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
?>