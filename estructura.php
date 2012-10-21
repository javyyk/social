<script>
	$(document).ready(function(){
		// Al poner y quitar el raton sobre los input
		$("div.desplegable").hover(
			function(){
				$(this).find("div").each(function(){
					$(this).css({'display':'block'});
				});
			},
			function(){
				$(this).find("div").each(function(){
					$(this).css({'display':'none'});
				});
			}
		);
	});
</script>

<div id="barra_sup" class="">
	<a href="inicio.php">Inicio</a>
	<a href="perfil.php">Perfil</a>
	<a href="fotos.php">Fotos</a>
	<div class="desplegable">
		<a href='mp_entrada.php'>Mensajes Privados</a>
		<div class="submenus">
			<div><a href="mp_redactar.php">Escribir Mensajes</a></div>
			<div><a href="mp_entrada.php">Mensajes Recibidos</a></div>
			<div><a href="mp_salida.php">Mensajes Enviados</a></div>
		</div>
	</div>
	<?php /*
		$query=mysql_query("SELECT * FROM mps WHERE receptor='".$global_idusuarios."' AND estado='nuevo'");
		if(mysql_num_rows($query)>0){
			echo "<a href='mp_entrada.php'>Mensajes Privados (".mysql_num_rows($query).")</a>";
		}else{
			echo "<a href='mp_entrada.php'>Mensajes Privados</a>";
		}*/
	?>
	
	<a href="buscador.php">Buscador</a>
	<a href="subir_fotos.php">Subir fotos</a>
	<a href=".php">Ajustes</a>
	<a href="logout.php">Salir</a>
</div>