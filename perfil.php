<?php
	require("verify_login.php");
	head("Perfil - Social");
	require("estructura.php");
?>
<div id="barra_izq" class="">
	<?php
		if($usuario['idfotos_princi']){
			$foto=mysql_query("SELECT * from fotos WHERE idfotos='".$usuario['idfotos_princi']."'");
			$foto=mysql_fetch_assoc($foto);
			echo "<img alt='foto principal' height='300' width='300' src='".$foto['archivo']."' />";
		}
		echo $global_nombre." ".$global_apellidos;
		echo "<br>Edad: ".$usuario['edad'];
	?>
</div>
<div id="estado" class="">
	<form method="POST" action="post.php" id="cambio_estado">
		<textarea name="estado" cols="60" rows="2">
		<?php
			if($usuario['estado']){
				echo $usuario['estado'];
			}else{
				echo "Pon un estado huevon";
			}
		?></textarea>
		<button type="submit" form="cambio_estado" value="Submit">Cambiar</button>
	</form>
</div>
<div id="cuerpo" class="">
las cosas dle tablon<br>
los comentarios del personal
</div>

