<?php
	require("verify_login.php");
	head("Buscador - Social");
	require("estructura.php");
?>
<div class="barra_izq_centro">
	<?php
		//Subidas
		echo "<a href='fotos.php?album=subidas'><div class='album'><div class='album_foto'>fotos...</div>Subidas</div></a>";
		
		//Etiquetadas
		echo "<a href='fotos.php?album=perfil'><div class='album'><div class='album_foto'>fotos...</div>Etiquetadas</div></a>";
		
		//Perfil
		echo "<a href='fotos.php?album=perfil'><div class='album'><div class='album_foto'>fotos...</div>Perfil</div></a>";
		
		//Personalizados
		echo "<div>Albums personalizados</div>";
		$personalizados = mysql_query("SELECT * FROM `albums` WHERE usuarios_idusuarios='".$global_idusuarios."'");
		if(mysql_num_rows($personalizados)>0){
			while($row = mysql_fetch_assoc($personalizados)){
				echo "<a href='fotos.php?album=".$row['idalbums']."'><div class='album'><div class='album_foto'>fotos...</div>".$row['album']."</div></a>";
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