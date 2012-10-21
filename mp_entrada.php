<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
	require("estructura.php");
	
	echo "<h2>Mensajeria Privada</h2>";
	
	$query=mysql_query("SELECT * FROM mps,usuarios WHERE receptor='".$global_idusuarios."' AND idusuarios=emisor");
	while($mps=mysql_fetch_assoc($query)){
		echo "<div class='mp'>".$mps['nombre']." te dijo: ".$mps['mp']."</div>";
	}
?>