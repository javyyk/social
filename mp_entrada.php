<?php
	require("verify_login.php");
	head("Mensajeria Privada - Social");
	require("estructura.php");
	
	echo "<h2>Mensajeria Privada</h2>";
	$query=mysql_query("SELECT * FROM mps,usuarios WHERE receptor='".$global_idusuarios."' AND idusuarios=emisor");
	echo "<div id='accordion'>";
	while($mps=mysql_fetch_assoc($query)){
		echo "<h3 onclick=\"ajax('post.php?mensaje_leido=".$mps['idmps']."')\">".$mps['nombre']." te dijo:</h3>";
		echo "<div><p>".$mps['mp']."</p></div>";
	}
	echo "</div>";
?>

 
<script>
    $(function() {
        $("#accordion").accordion({
        	active: "false",
            collapsible: "true",
            heightStyle: "content"
        });
    });
    function ajax(url){
		$.ajax({
			url: url,
		})/*.done(function ( data ) {
			alert(data);
		})*/;
	}
</script>