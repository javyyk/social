<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
	require("estructura.php");
	
	require_once("validador.class.php");
	$Validador = new Validador();
	$Validador->SetInput(array('name' => 'mensaje_privado', 'alias' => 'Mensaje', 'min' => '2'));
	$Validador->GeneraValidadorJS();
	
	echo "<h2>Mensajeria Privada</h2>";
	
	
	
	
	if($_GET['receptor']){
		$query=mysql_query("SELECT * FROM usuarios WHERE idusuarios='".$_GET['receptor']."'");
		$usuario=mysql_fetch_assoc($query);
		?>
		Destinatario: <?php echo $usuario['nombre']; ?> </h2>
		
		<form method="POST" action="post.php">
			Mensaje:<br>
			<textarea name="mensaje_privado" cols="60" rows="2"></textarea>
			<input type="hidden" name="receptor" value="<?php echo $usuario['idusuarios']; ?>" /><br>
			<button type="button" onclick="validador('submit');">Enviar</button>
		</form>
		<?php
	}else{
		$query=mysql_query("		
			SELECT *
			FROM amigos, usuarios
			WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios 
		");
		
		if(mysql_num_rows($query)>0){
			echo "<form method='POST' action='post.php'>";
			echo "Destinatario: <select name='receptor'>";
			while($row=mysql_fetch_assoc($query)){
				echo "<option value='".$row['idusuarios']."'>".$row['nombre']." ".$row['apellidos']."</option>";
			}
			?>
				</select><br>
				Mensaje:<br>
				<textarea name="mensaje_privado" cols="60" rows="2"></textarea><br>
			  	<button type="button" onclick="validador('submit');">Enviar</button>
			</form>
		<?php
		}
	}
?>