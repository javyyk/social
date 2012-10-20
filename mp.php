<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
	require("estructura.php");
	
	$query=mysql_query("SELECT * FROM usuarios WHERE idusuarios='".$_GET['receptor']."'");
	$usuario=mysql_fetch_assoc($query);
	
	echo "<h2>Enviar mensaje a ".$usuario['nombre']."</h2>";
?>

	
	<form method="POST" action="post.php">
		<textarea name="mensaje_privado" cols="60" rows="2"></textarea>
		<input type="hidden" name="receptor" value="<?php echo $usuario['idusuarios']; ?>" />
		<input type="submit" value="Submit">
	</form>
	
<?php
	$query=mysql_query("SELECT * FROM mps,usuarios WHERE receptor='".$global_idusuarios."' AND idusuarios=emisor");
	while($mps=mysql_fetch_assoc($query)){
		echo "<div class='mp'>".$mps['nombre']." te dijo: ".$mps['mp']."</div>";
	}
?>