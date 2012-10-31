<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
	require("estructura.php");

	echo "<h2>Mensajeria Privada</h2>";




	$query=mysql_query("
		SELECT *
		FROM amigos, usuarios
		WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios
	");
	if(mysql_num_rows($query)>0){
		echo "<h3>Enviar Mensaje</h3>";
		echo "Destinatario: <select name='receptor'>";
		while($row=mysql_fetch_assoc($query)){
			echo "<option value='".$row['idusuarios']."'>".$row['nombre']." ".$row['apellidos']."</option>";
			//echo $row['nombre']." ".$row['apellidos']." <a href='gente.php?id=".$row['idusuarios']."'>Ver perfil</a><br>";
		}
		?>
		</select>
		<form method="POST" action="post.php">
			<textarea name="mensaje_privado" cols="60" rows="2"></textarea>
			<input type="hidden" name="receptor" value="<?php echo $usuario['idusuarios']; ?>" />
			<input type="submit" value="Submit">
		</form>
	<?php
	}






	if($_GET['receptor']){
		$query=mysql_query("SELECT * FROM usuarios WHERE idusuarios='".$_GET['receptor']."'");
		$usuario=mysql_fetch_assoc($query);
		?>
		Enviar mensaje a <?php echo $usuario['nombre']; ?></h2>
		<form method="POST" action="post.php">
			<textarea name="mensaje_privado" cols="60" rows="2"></textarea>
			<input type="hidden" name="receptor" value="<?php echo $usuario['idusuarios']; ?>" />
			<input type="submit" value="Submit">
		</form>
		<?php
	}

	$query=mysql_query("SELECT * FROM mps,usuarios WHERE emisor='".$global_idusuarios."' AND idusuarios=receptor");
	while($mps=mysql_fetch_assoc($query)){
		echo "<div class='mp'>".$mps['nombre']." te dijo: ".$mps['mp']."</div>";
	}
?>