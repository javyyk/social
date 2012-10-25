<?php
	require("verify_login.php");
	
	//Comprueba amistad
	$query=mysql_query("SELECT count(*) FROM amigos WHERE user1='".$_GET['id']."' AND user2='".$global_idusuarios."' OR user2='".$_GET['id']."' AND user1='".$global_idusuarios."'");
	if(mysql_num_rows($query)!=1){
		header("Location: inicio.php?nosoisamigos");
		die();
	}else{
		$query=mysql_query("SELECT * FROM usuarios WHERE idusuarios='".$_GET['id']."'");
		$usuario=mysql_fetch_assoc($query);
	}
	head($usuario['nombre']." - Social");
	require("estructura.php");


?>
<div id="barra_izq" class="">
	<?php
		if($usuario['idfotos_princi']){
			$foto=mysql_query("SELECT * from fotos WHERE idfotos='".$usuario['idfotos_princi']."'");
			$foto=mysql_fetch_assoc($foto);
			echo "<img alt='foto principal' height='200' width='200' src='".$foto['archivo']."' />";
		}
		echo $usuario['nombre']." ".$usuario['apellidos'];
		echo "<br>Edad: ".$usuario['edad']."<br>";
		echo "<a href='mp_redactar.php?receptor=".$usuario['idusuarios']."'>Enviar mensaje privado</a>"
	?>
</div>
<div id="cuerpo" class="">
	<h2>Comentarios</h2>
	
	<form method="POST" action="post.php">
		<textarea name="comentario_tablon" cols="60" rows="2"></textarea>
		<input type="hidden" name="receptor" value="<?php echo $usuario['idusuarios']; ?>" />
		<input type="submit" value="Submit">
	</form>
	<?php
	$query=mysql_query("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') AS fechaf FROM tablon,usuarios WHERE receptor='".$usuario['idusuarios']."' AND idusuarios=emisor ORDER BY idtablon DESC");
	if(mysql_num_rows($query)>0){
		while($comentarios=mysql_fetch_assoc($query)){
			echo "<div>".$comentarios['nombre']." ".$comentarios['apellidos']." ".$comentarios['fechaf']."<br>";
			echo "Dijo: ".$comentarios['comentario']."</div><br>";
		}
	}else{
		echo "<div>".$usuario['nombre']." aun no tiene comentarios en su tablon, escribe uno!</div>";
	}
	?>
</div>

