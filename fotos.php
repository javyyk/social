<?php
	require("verify_login.php");
	
	if($_GET['principal']){
		mysql_query("UPDATE usuarios SET idfotos_princi='".$_GET['principal']."' WHERE idusuarios='".$global_idusuarios."'");
		header("location:index.php");
	}
	
	
	head("Fotos - Social");
	require("estructura.php");
?>

<div id="cuerpo" class="">
<?php

	if($_GET['idfotos'] AND $_GET['uploader']){
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$_GET['uploader']."' AND idfotos<='".$_GET['idfotos']."' ORDER BY idfotos DESC LIMIT 2");
	}else{
		$fotos=mysql_query("SELECT * from fotos WHERE uploader='".$global_idusuarios."' ORDER BY idfotos DESC LIMIT 2");
		$_GET['uploader']=$global_idusuarios;
	}
	$row=mysql_fetch_assoc($fotos);
	echo "<br>ID: ".$row['idfotos']." - File: ".$row['archivo']."<br>\n";
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
	<a href="fotos.php?principal=<?php echo $row['idfotos'];?>">Principal</a>
</div>