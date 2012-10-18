<?php
	require("verify_login.php");
	head("Inicio - Social");
	require("estructura.php");
?>
<div id="barra_izq" class="">
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
<div id="cuerpo" class="">
	Aqui van las novedades y ezas cozas, tu sabeh
</div>

