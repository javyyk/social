<?php
	require("verify_login.php");
	head("Fotos - Social");
	require("estructura.php");
?>

<div class="cuerpo_centro">
<?php

	if($_GET['idfotos'] AND $_GET['uploader']){
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$_GET['uploader']."' AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
	}else{
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$global_idusuarios."' ORDER BY idfotos DESC LIMIT 2");
		if(mysql_num_rows($fotos)<1){
			echo "Todavia no has subido ninguna foto, <a href='subir_fotos.php'>hazlo ahora</a>";
			die();
		}
		$_GET['uploader']=$global_idusuarios;
	}
	$row=mysql_fetch_assoc($fotos);
	
	echo "<br>".$row['titulo']."<br>\n";
	
	//echo "<br>ID: ".$row['idfotos']." - File: ".$row['archivo']."<br>\n";
	//echo mysql_num_rows($fotos);
	echo "<img alt='' height='300' width='300' src='".$row['archivo']."'";
	$row=mysql_fetch_assoc($fotos);
	if(mysql_num_rows($fotos)==2){
		?>
		onclick="
		location.href='<?php echo "?uploader=".$_GET['uploader']."&amp;idfotos=".$row['idfotos']; ?>'"
		<?php
	}
	 mysql_data_seek($fotos,0); //foto actual
	$row=mysql_fetch_assoc($fotos);
	 
	?>
	/>
	<a href="post.php?foto_principal=<?php echo $row['idfotos'];?>">Principal</a>
	<a href="post.php?foto_borrar=<?php echo $row['idfotos'];?>">Borrar foto</a>
</div>