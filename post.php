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
		error_mysql("exit");
		if(mysql_num_rows($query)>0){
			header("Location: inicio.php?yasoisamigos");
		}

		mysql_query("INSERT INTO amigos (user1,user2) VALUES ('".$_GET['emisor']."','".$global_idusuarios."')");
		error_mysql("exit");

		mysql_query("DELETE FROM peticiones WHERE emisor='".$_GET['emisor']."' AND receptor='".$global_idusuarios."'");
		error_mysql("exit");
		header("Location: inicio.php");
	}

	if($_POST['comentario_tablon']!=""){
		mysql_query("INSERT INTO tablon (emisor,receptor,comentario,fecha) VALUES ('".$global_idusuarios."','".$_POST['receptor']."','".$_POST['comentario_tablon']."', now())");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}else{
			header("Location: gente.php?id=".$_POST['receptor']);
		}
	}

	if($_POST['mensaje_privado']!=""){
		mysql_query("INSERT INTO mps (emisor,receptor,mp,fecha) VALUES ('".$global_idusuarios."','".$_POST['receptor']."','".$_POST['mensaje_privado']."',now())");
		if(mysql_errno()!=0){
			error_mysql("exit");
		}else{
			header("Location: gente.php?id=".$_POST['receptor']."&mp_enviado");
		}
	}

	if($_GET['mensaje_leido']!=""){
		mysql_query("UPDATE mps SET estado='leido' WHERE idmps='".$_GET['mensaje_leido']."'");
		error_mysql();
	}
	
	/***************	FOTOS	*****************/
	if($_GET['foto_principal']){
		mysql_query("UPDATE usuarios SET idfotos_princi='".$_GET['foto_principal']."' WHERE idusuarios='".$global_idusuarios."'");
		header("location:perfil.php");
	}

	if($_GET['foto_borrar']){
		$result=mysql_query("SELECT * from fotos WHERE uploader='".$global_idusuarios."' AND idfotos='".$_GET['foto_borrar']."'");
		if(mysql_num_rows($result)==1){
			$result=mysql_fetch_assoc($result);
			unlink($result['archivo']);

			mysql_query("DELETE FROM fotos WHERE uploader='".$global_idusuarios."' AND idfotos='".$_GET['foto_borrar']."'");
		}
		//header("location:fotos.php");
	}

	if($_POST['foto_comentario']){
		mysql_query("INSERT INTO fotos_comentarios (fotos_idfotos,emisor,comentario,fecha) VALUES ('".$_POST['idfotos']."','".$global_idusuarios."','".$_POST['foto_comentario']."',now())");
		header($_SERVER['referer']);
		die();
	}


	/*************	CHAT	*********************/
	if($_POST['chat_estado']){
		$_SESSION['chat_estado']=$_POST['chat_estado'];
		die();
	}
	
	if($_POST['estado_online']){
		mysql_query("UPDATE usuarios SET online=now() WHERE idusuarios='".$global_idusuarios."'");
	}

	if($_POST['chat_enviar']){
		mysql_query("INSERT INTO chat (emisor,receptor,mensaje,fecha) VALUES ('".$global_idusuarios."','".$_POST['receptor']."','".$_POST['mensaje']."',now())");
	}

	if($_POST['chat_leer']){
		$result=mysql_query("SELECT *,(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS archivo from chat,usuarios WHERE  idusuarios=emisor AND receptor='".$global_idusuarios."' AND chat.estado='nuevo'");

		if(mysql_num_rows($result)>0){
			while($row=mysql_fetch_assoc($result)){
				echo "<div iduser='".$row['emisor']."' nombre='".$row['nombre']." ".$row['apellidos']."' img='".$row['archivo']."' >".$row['nombre']." dijo: ".$row['mensaje']."</div>";
			}
		}
		mysql_query("UPDATE chat SET estado='leido' WHERE receptor='".$global_idusuarios."'");
		die();
	}
	
	if($_POST['chat_contactos']){
		if($_SESSION['chat_estado']=="on"){
			//CONECTADOS
			$result=mysql_query("
								SELECT *,(@tiempo:=TIME_TO_SEC(TIMEDIFF(now(),online))) AS segundos_off,
								CASE
								WHEN @tiempo<60 THEN 'conectado'
								WHEN @tiempo<86000 THEN TIME_FORMAT(TIMEDIFF(now(),online), '%H:%i:%s')
								ELSE DATE_FORMAT(online, '%d/%m/%Y %H:%i') END AS online,
								(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS archivo
								FROM amigos, usuarios
								WHERE TIME_TO_SEC(TIMEDIFF(now(),online))<95 AND
								(user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios)
								ORDER BY nombre
			");
			echo "<ul>";
			while ($row=mysql_fetch_assoc($result)) {
				echo "<li onclick=\"chat_init_conv('".$row['idusuarios']."','".$row['nombre']." ".$row['apellidos']."','".$row['archivo']."')\"><div class='conectado'></div>".$row['nombre']." ".$row['apellidos']."</li>";
			}
			echo "</ul>";
			//	NO CONECTADOS
			$result=mysql_query("
								SELECT *,(@tiempo:=TIME_TO_SEC(TIMEDIFF(now(),online))) AS segundos_off,
								CASE
								WHEN @tiempo<60 THEN 'conectado'
								WHEN @tiempo<86000 THEN TIME_FORMAT(TIMEDIFF(now(),online), '%H:%i:%s')
								ELSE DATE_FORMAT(online, '%d/%m/%Y %H:%i') END AS online,
								(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS archivo
								FROM amigos, usuarios
								WHERE TIME_TO_SEC(TIMEDIFF(now(),online))>95 AND
								(user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios)
								ORDER BY nombre
			");
			echo "<ul>";
			while ($row=mysql_fetch_assoc($result)) {
				echo "<li onclick=\"chat_init_conv('".$row['idusuarios']."','".$row['nombre']." ".$row['apellidos']."','".$row['archivo']."')\"><div class='desconectado'></div>".$row['nombre']." ".$row['apellidos']."</li>";
			}
			echo "</ul>";
			echo "<p style='cursor:pointer;' onclick=\"chat_turn('off')\">Desactivar Chat</p>";
		}else{
			echo "<p style='cursor:pointer;' onclick=\"chat_turn('on')\">Activar Chat</p>";
		}
		die();
	}
/*
	if($_POST['chat_conv_new']){
		$result=mysql_query("
								SELECT *,(@tiempo:=TIME_TO_SEC(TIMEDIFF(now(),online))) AS segundos_off,
								CASE
								WHEN @tiempo<60 THEN 'conectado'
								WHEN @tiempo<86000 THEN TIME_FORMAT(TIMEDIFF(now(),online), '%H:%i:%s')
								ELSE DATE_FORMAT(online, '%d/%m/%Y %H:%i') END AS online,
								(SELECT archivo FROM fotos WHERE idfotos=idfotos_princi) AS archivo
								FROM amigos, usuarios
								WHERE (user1='".$global_idusuarios."' AND user2='".$_POST['chat_conv_new']."' OR user2='".$global_idusuarios."' AND user1='".$_POST['chat_conv_new']."')
									AND idusuarios='".$_POST['chat_conv_new']."'
			");
		$row=mysql_fetch_assoc($result);
		print(
			"<div id='chat_conv_".$row['idusuarios']."_min' class='chat_ventana_min' onclick=\"max('".$row['idusuarios']."')\">
				&nbsp;<img src='".$row['archivo']."' alt='".$row['nombre']."' />&nbsp;
				<div class='mensajes'></div>
			</div>
			<div id='chat_conv_".$row['idusuarios']."' class='chat_ventana'>
				".$row['nombre']." ".$row['apellidos']."
				<div class='boton cerr' onclick=\"cerrar('".$row['idusuarios']."')\"></div>
				<div class='boton max'></div>
				<div class='boton mini' onclick=\"mini('".$row['idusuarios']."')\"></div>
				<div id='mensajes'></div>
				<textarea name='mensaje' onkeypress=\"chat_press_enter(event,this,'".$row['idusuarios']."')\" /></textarea>
				<button type='button' onclick=\"enviar('".$row['idusuarios']."')\">Enviar</button>
			</div>");
			die();
	}
*/
	echo "<pre>";
	if($_POST){
		echo "POST:<br>";
		print_r($_POST);
		echo "<br>";
	}

	if($_GET){
		echo "GET:<br>";
		print_r($_GET);
	}
	echo "</pre>";
?>