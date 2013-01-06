<?php
	require("verify_login.php");
	head("Buscador - Social");
	require("estructura.php");
	

?>
<div class="barra_izq_centro">
	<?php
		if(!$_GET['iduser']){
			$_GET['iduser']=$global_idusuarios;
			echo "<h2>Mis Albums de imagenes</h2>";
		}else{
			$usuario = mysql_query("SELECT * FROM usuarios WHERE idusuarios='".$_GET['iduser']."'");
			if(mysql_num_rows($usuario)>0){
				$row = mysql_fetch_assoc($usuario);
				echo "<h2>Albums de imagenes de ".$row['nombre']."</h2>";
			}
		}
		//Subidas
		echo "<a href='fotos.php?iduser=".$_GET['iduser']."&idalbum=subidas'><div class='album'><div class='album_foto'>fotos...</div>Subidas</div></a>";
		
		//Etiquetadas
		echo "<a href='fotos.php?iduser=".$_GET['iduser']."&idalbum=etiquetadas'><div class='album'><div class='album_foto'>fotos...</div>Etiquetadas</div></a>";
		
		//Perfil
		echo "<a href='fotos.php?iduser=".$_GET['iduser']."&idalbum=perfil'><div class='album'><div class='album_foto'>fotos...</div>Perfil</div></a>";
		
		//Personalizados
		echo "<div>Albums personalizados</div>";
		$personalizados = mysql_query("SELECT * FROM `albums` WHERE usuarios_idusuarios='".$_GET['iduser']."'");
		if(mysql_num_rows($personalizados)>0){
			while($row = mysql_fetch_assoc($personalizados)){
				echo "<a href='fotos.php?iduser=".$_GET['iduser']."&album=".$row['idalbums']."'><div class='album'><div class='album_foto'>fotos...</div>".$row['album']."</div></a>";
			}
		}else{
			?>
			Aun no tienes ningun album personalizado<br>
			Crea uno:<br>
			<form method="post" action="post.php">
				Nombre del album: <input type="text" name="album" />
				<button>Crear album</button>
			</form>
			<?php
		}
	?>
</div>