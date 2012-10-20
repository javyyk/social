<div id="barra_sup" class="">
	<a href="inicio.php">Inicio</a>
	<a href="perfil.php">Perfil</a>
	<a href="fotos.php">Fotos</a>
	
	<?php
		$query=mysql_query("SELECT * FROM mps WHERE receptor='".$global_idusuarios."' AND estado='nuevo'");
		if(mysql_num_rows($query)>0){
			echo "<a href='mp.php'>Mensajes Privados (".mysql_num_rows($query).")</a>";
		}else{
			echo "<a href='mp.php'>Mensajes Privados</a>";
		}
	?>
	
	<a href="buscador.php">Buscador</a>
	<a href="subir_fotos.php">Subir fotos</a>
	<a href=".php">Ajustes</a>
	<a href="logout.php">Salir</a>
</div>