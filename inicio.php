<?php
	require("verify_login.php");
	head("Inicio - Social");
	require("estructura.php");
?>
<div class="barra_izq">
	<?php
		if($usuario['idfotos_princi']){
			$foto=mysql_query("SELECT * from fotos WHERE idfotos='".$usuario['idfotos_princi']."'");
			$foto=mysql_fetch_assoc($foto);
			echo "<img alt='foto principal' height='50' width='50' src='".$foto['archivo']."' />";
		}
		echo $global_nombre." ".$global_apellidos;
		echo "<br>Edad: ".$usuario['edad'];
	?>
</div>



<div class="barra_centro" class="">
	<div class="marco_full">
		<h2>Lista de amigos</h2>
		<?php
			$query=mysql_query("

			SELECT *
	FROM amigos, usuarios
	WHERE user1='".$global_idusuarios."' AND user2=idusuarios OR user2='".$global_idusuarios."' AND user1=idusuarios
			");
			if(mysql_num_rows($query)>0){
				//echo "Tienes ".mysql_num_rows($query)." peticion(es) de amistad:<br>";
				while($row=mysql_fetch_assoc($query)){
					//print_r($row);
					echo $row['nombre']." ".$row['apellidos']." <a href='gente.php?id=".$row['idusuarios']."'>Ver perfil</a><br>";

				}
			}
		?>
	</div>


	<div class="marco_full">
		<h2>Peticiones de amistad</h2>
		<?php
			$query=mysql_query("SELECT * FROM peticiones, usuarios WHERE receptor = '".$global_idusuarios."' AND idusuarios = emisor");
			if(mysql_num_rows($query)>0){
				echo "Tienes ".mysql_num_rows($query)." peticion(es) de amistad:<br>";
				while($row=mysql_fetch_assoc($query)){
					//print_r($row);
					echo $row['nombre']." ".$row['apellidos']." <a href='post.php?aceptarpeticion=1&emisor=".$row['idusuarios']."'>Aceptar peticion</a><br>";

				}
			}
		?>
	</div>
</div>

<div id="chat">
	<div id="chat_boton" onclick="chat_toggle()"></div>
	<div id="chat_contactos">
		<?php
		if($_SESSION['chat_estado']!="on")
			echo "<p style='cursor:pointer;' onclick=\"chat_turn('on')\">Activar Chat</p>";
		?>
	</div>
	<div id='chat_conv_tmp' style='display:none;'></div>
</div>