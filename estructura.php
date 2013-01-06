<ul id="menudrop">
	<li><a href="inicio.php">Inicio</a></li>
	<li><a href="perfil.php">Perfil

			<?php
				$query=mysql_query("SELECT * FROM tablon WHERE receptor='".$global_idusuarios."' AND estado='nuevo'");
				if(mysql_num_rows($query)>0){
					echo " (".mysql_num_rows($query).")";
				}
			?>
		</a>
	</li>
	<li>
		<a href="albums.php">Albums</a>
		<ul>
			<li><a href="fotos.php?album=etiquetadas">Etiquetadas</a></li>
			<li><a href="fotos.php?album=subidas">Subidas</a></li>
			<li><a href="fotos.php?album=perfil">Perfil</a></li>
			<?php
			$result=mysql_query("SELECT * FROM albums WHERE usuarios_idusuarios='".$global_idusuarios."'");
			if(mysql_num_rows($result)>0){
				while($row=mysql_fetch_assoc($result)){
					echo "<li><a href='fotos.php?album=".$row['idalbums']."'>".$row['album']."</a></li>";
				}
			}
			?>
		</ul>
	</li>
	<li>
		<a href="mp_entrada.php">
			Mensajes
			<?php
			$query=mysql_query("SELECT * FROM mps WHERE receptor='".$global_idusuarios."' AND estado='nuevo'");
			if(mysql_num_rows($query)>0){
				echo " (".mysql_num_rows($query).")";
			}
			?>
		</a>
		<ul>
			<li><a href="mp_entrada.php">Mensajes Recibidos</a></li>
			<li><a href="mp_salida.php">Mensajes Enviados</a></li>
			<li><a href="mp_redactar.php">Escribir Mensajes</a></li>
		</ul>
	</li>
	<li><a href="buscador.php">Buscador</a></li>
	<li><a href="subir_fotos.php">Subir fotos</a></li>
	<li style="float:right;margin-right:10px;"><a href="logout.php">Salir</a></li>
	<li style="float:right;"><a href=".php">Ajustes</a></li>
</ul>