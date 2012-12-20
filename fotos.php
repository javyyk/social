<?php
	require("verify_login.php");
	head("Fotos - Social");
	echo "<script type='text/javascript' src='fotos/foto_etiqueta.js'></script>";
	echo "<script type='text/javascript' src='fotos/foto_visualizador.js'></script>";
	require("estructura.php");
		if(!$_GET['user']){
		$_GET['user']=$global_idusuarios;
		$uploader=1;
	}
	
	if(!$_GET['idfotos']){
		$_GET['idfotos']="999999999";
	}
	
	if($_GET['album']=='subidas'){
		$permiso_foto="dueño";
		$fotos=mysql_query("SELECT * FROM fotos WHERE uploader='".$_GET['user']."' AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
	}elseif($_GET['album']=='etiquetadas'){
		$fotos=mysql_query("SELECT * FROM fotos, etiquetas WHERE usuarios_idusuarios = '".$global_idusuarios."' AND idfotos = fotos_idfotos AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
		if(mysql_num_rows($fotos)){
			$t=mysql_fetch_assoc($fotos);
			if($t['uploader']==$global_idusuarios){
				$permiso_foto=="dueño";
			}else{
				$permiso_foto=="etiquetado";
			}
			mysql_data_seek($fotos, 0);
		}
	}elseif($_GET['album']=='perfil'){
		$permiso_foto=="dueño";
		// TODO: Fotos del perfil
		$fotos=mysql_query("");
	}elseif($_GET['album']){
		
	}else{
		die("Error 1075");
	}
	require("fotos/foto.php");
	require("fotos/barra.php");
	require("fotos/comentarios.php");
?>